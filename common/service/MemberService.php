<?php
namespace app\common\service;
use app\common\service\BaseService;
use app\models\Activity;
use app\models\User;
use app\models\Answer;
use app\models\profile;
use app\models\UserIdcardCheck;
use app\models\UserSelectTags;
use app\models\YellowCard;
use app\models\AuthAssignment;
use yii\web\Response;
use Yii;
use yii\db\ActiveQuery;
use app\component\CommonFunction;
use yii\data\Pagination;
class MemberService extends BaseService{

	/**
	 * 获取用户列表
	 * 管理员，发起人，黑名单，封禁，申诉
	 */
	public static function getList($data=[]){
		$query = User::find()->select([
			'user.id','user.username','user.wechat_id','user.mobile','user.created_at','user.black_label','user.status'
		]);
		if($data['is_founder']){
			$query= $query->joinWith('assignment')
                    ->where([
                        'status' => User::STATUS_ACTIVE,
                        'auth_assignment.item_name' => 'founder',
                    ])
                    ->with(['assignment'])
                    ->orderBy(['id' => SORT_DESC]);
		}
		if($data['is_black']){
			$where = ['status' => User::STATUS_ACTIVE, 'black_label' => User::BLACK_LIST_YES];
            $query = $query->where($where)->orderBy(['id' => SORT_DESC]);
		}
		if($data['is_lock']){
			$query = $query->where(['status'=>-10]);
		}
		if($data['is_admin']){
			$query= $query->joinWith('assignment')
                    ->where([
                        'status' => User::STATUS_ACTIVE,
                        'auth_assignment.item_name' => 'admin',
                    ])
                    ->with(['assignment'])
                    ->orderBy(['id' => SORT_DESC]);
		}
		if($data['is_apply']){
			$userAppeal = YellowCard::find()
                ->select('user_id,appeal_time')
                ->where(['appeal_status' => YellowCard::APPEAL_STATUS_YES])
                ->orderBy([
                    'appeal_time' => SORT_DESC
                ])
                ->asArray()
                ->all();
            $userArr = [];
            foreach ($userAppeal as $key => $value) {
                $userArr[$key] = $value['user_id'];
            }
            $sortUserArr = implode(',', $userArr);
            $query = $query
                ->where(['id' => $userArr]);
		}
		$count = $query->count();
		$page = new Pagination(['totalCount' => $count,'pageSize'=>'30']);
		$list['data'] = $query->asArray()->offset($page->offset)->limit($page->limit)->all();
		$list['count'] = $count;
		foreach ($list['data'] as $key=>$row) {
			$profile = Profile::find()->select(['sex'])->where(['user_id'=>$row['id']])->asArray()->one();
			if($profile){
				if($profile['sex'] == 1){
					$list['data'][$key]['sex'] = '男';
				}elseif($profile['sex'] == 2){
					$list['data'][$key]['sex'] = '女';
				}else{
					$list['data'][$key]['sex'] = '未知';
				}
			}else{
				$list['data'][$key]['sex'] = '未知';
			}
		}
		return $list;
	}
	/**
	 * 更新用户的状态
	 */
	public static function updateStatus($data){
		switch ($data['type']) {
			// 拉黑
			case 'black':
				User::updateAll(['black_label'=>User::BLACK_LIST_YES],['id'=>$data['id']]);
				$user = User::find()->select(['black_label'])->where(['id'=>$data['id']])->one();
				return $user && $user->black_label == User::BLACK_LIST_YES ?true:false;
				break;
			// 封禁
			case 'lock':
				User::updateAll(['status'=>User::STATUS_LOCK],['id'=>$data['id']]);
				$user = User::find()->select(['status'])->where(['id'=>$data['id']])->one();
				return $user && $user->status == User::STATUS_LOCK ?true:false;
				break;
			// 解锁
			case 'unlock':
				User::updateAll(['status'=>User::STATUS_ACTIVE],['id'=>$data['id']]);
				$user = User::find()->select(['status'])->where(['id'=>$data['id']])->one();
				return $user && $user->status == User::STATUS_ACTIVE ?true:false;
				break;
			// 解除拉黑
			case 'unblack':
				User::updateAll(['black_label'=>User::BLACK_LIST_NO],['id'=>$data['id']]);
				$user = User::find()->select(['black_label'])->where(['id'=>$data['id']])->one();
				return $user && $user->black_label == User::BLACK_LIST_NO ?true:false;
				break;
		}
	}
	/**
	 * 获取用户详情
	 */
	public static function getInfo($id,$fields=[]){
		$auth = Yii::$app->authManager;
		$user['answers'] =[];
		$user['activity'] =[];
		$user['tags'] =[];
		$user['yellowCard']=[];
		$user['profile']=[];
		$user = User::find()->select(['id','username','wechat_id','mobile','created_at','last_login_at','founder_desc'])->where(['id'=>$id])->asArray()->one();
		if(in_array('profile', $fields)){
			$profile = Profile::find()->select(['headimgurl','sex','birth_year','birth_month','birth_day'])->where(['user_id'=>$id])->asArray()->one();
			$user['profile'] = $profile;
		}
		if(in_array('tags', $fields)){
			$tags = self::getTags($id);
			$user['tags'] = $tags;
		}
		if(in_array('is_admin', $fields) || in_array('is_founder', $fields)){
			$auth = Yii::$app->authManager;
        	$role = $auth->getAssignments($user_id);
        	if($role){
        		if(array_key_exists('admin', $role)) $user['is_admin'] = 1;
        		if(array_key_exists('founder', $role)) $user['is_founder'] = 1;
        	}
		}
		if(in_array('answers', $fields)){
			$aid = [];
			$answes = Answer::find()->select(['activity_id'])->where(['user_id'=>$id])->asArray()->all();
			foreach ($answes as $row) {
				array_push($aid,$row['activity_id']);
			}
			if(!empty($aid)){
				$user['answers'] = Activity::find()->select(['title','start_time'])->where(['in','id',$aid])->asArray()->orderBy("id desc")->limit(5)->all();
			}
		}
		if(in_array('activity', $fields)){
			$user['activity'] = Activity::find()->select(['title','start_time'])->where(['created_by'=>$id])->asArray()->orderBy("id desc")->limit(5)->all();
		}
		if(in_array('yellowCard', $fields)){
			$yid=[];
			$yellow = YellowCard::find()->where(['activity_id'])->where(['user_id'=>$id])->asArray()->all();
			if(!empty($yellow)){
				foreach ($yellow as $row) {
					array_push($yid, $row['activity_id']);
				}
				$user['yellowCard'] = Activity::find()->select(['title','start_time'])->where(['in','id',$yid])->asArray()->all();
			}
		}
		$user['realname'] ='未设置';
		if(in_array('realname', $fields)){
			$idcard = UserIdcardCheck::find()->select(['realname'])->where(['user_id'=>$id])->asArray()->one();
			if($idcard && isset($user['realname'])){
				$user['realname'] = $idcard['realname'];
			}
		}
		$user['is_admin'] = !isset($user['is_admin'])?0:$user['is_admin'];
		$user['is_founder'] = !isset($user['is_founder'])?0:$user['is_founder'];
		return $user;
	}
	 /**
     * 获取用户标签
     *
     * @param string $unionid UNIONID
     * @return array
     */
    public static function getTags($user_id)
    {
        $tags = UserSelectTags::find()
                    ->select(['tag_title','type_pid'])
                    ->where(['user_id' => $user_id])
                    ->orderBy("id desc")
                    ->asArray()
                    ->all();
        if(!empty($tags)){
            $userTagsData = [
            	'zy'=>[],
            	'tsjn'=>[],
            	'tsjl'=>[],
            	'grsx'=>[],
            	'rstd'=>[],
            	'ph'=>[],
            ];
            $tsjn = $grsx = $tsjl = $rstd = 0;
            foreach ($tags as $row) {
            	switch ($row['type_pid']) {
            		case 1:
            			array_push($userTagsData['zy'],$row);
            			break;
            		case 2:
            			array_push($userTagsData['tsjn'],$row);
            			break;
            		case 3:
            			array_push($userTagsData['grsx'],$row);
            			break;
            		case 4:
            			array_push($userTagsData['tsjl'],$row);
            			break;
            		case 5:
            			array_push($userTagsData['rstd'],$row);
            			break;
            		case 6:
            			array_push($userTagsData['ph'],$row);
            			break;
            	}
            }
            $tags = $userTagsData;
        }
        return $tags;
    }
    /**
     * 根据unionid获取用户编号和access token
     *
     * @param string $unionid UNIONID
     * @return array
     */
    public static function getUserinfoByUnionId($unionid)
    {
        $user = User::find()
            ->where(['unionid' => $unionid])
            ->one();
        if (!$user) {
            $this->setError('用户不存在');
            return false;
        }

        if ($user->access_token) {
            return $user;
        }

        //生成access_token
        $time = time();
        $access_token = md5($user->id . md5($time . 'Someet'));

        $user->access_token = $access_token;
        if (!$user->save()) {
            $this->setError('更新用户Token失败');
            return false;
        }

        return $user;
    }

    public static function checkRegist($mobile){
        $user = User::find()
                    ->select(['unionid','username','id','mobile','access_token'])
                    ->where(['mobile'=>$mobile])
                    ->one();
        return $user;
    }

    /**
     * 获取所有小海豹的信息
     */
    public static function getServiceMan(){
    	$user_id = [2961,45388,50575,71887,71904];
    	$list = User::find()->select(['username','id'])->where(['in','id',$user_id])->asArray()->all();
    	return $list;
    }

    /**
     * 获取所有发起人的信息
     */
    public function getFounders($id){
    	$redis = Yii::$app->redis;
    	$data = $redis->get('founder-'.$id);
    	if(!$data){
    		$user = User::find()->select(['wechat_id','mobile','id','founder_desc','username'])->where(['id'=>$id])->asArray()->one();
    		$profile = Profile::find()->select(['headimgurl','sex','birth_year','birth_month','birth_day','bio','occupation'])->where(['user_id'=>$id])->asArray()->one();
    		$user['profile'] = $user;
    		$redis->set('founder-'.$id,serialize($user));
    		$data = $redis->get('founder-'.$id);
    	}
    	return unserialize($data);
    }
    /**
     * 搜索指定用户
     */
    public function getUserBySearch($data){
    	$type = $data['type'];
    	$val = $data['val'];
    	$user = User::find()->select(['username','id']);
    	if(is_numeric($val)){
    		$user->where(['id'=>$val])->orWhere(['mobile'=>$val])->orWhere(['wechat_id'=>$val]);
    	}else{
    		$user->where([
    			'like','username',$val
    		]);
    	}
    	return $user->asArray()->all();
    	
    }
    /**
     * 判断是否为发起人或者管理员
     */
    public static function checkRole($user_id){
    	$redis = Yii::$app->redis;
    	$is_admin = $redis->exists('admin-'.$user_id);
    	$is_founder = $redis->exists('founder-'.$user_id);
    	if(!$is_admin && !$is_founder){
    		self::pushUserInRedis($user_id);
    		$is_admin = $redis->exists('admin-'.$user_id);
    		$is_founder = $redis->exists('founder-'.$user_id);
    	}
    	return ['is_admin'=>intval($is_admin),'is_founder'=>$is_founder];
    }


    /**
     * 把发起人和管理员信息塞入redis
     */

    protected static function pushUserInRedis($user_id){
    	$redis = Yii::$app->redis;
    	$founder = AuthAssignment::find()->select(['user_id'])->where(['user_id'=>$user_id])->asArray()->all(); 
    	if($founder){
    		foreach ($founder as $row) {
    			if($row['item_name'] == 'founder' && !$redis->exists('founder-'.$user_id)){
    				$redis->set('founder-'.$user_id);
    			}
    			if($row['item_name'] == 'admin' && !$redis->exists('admin-'.$user_id)){
    				$redis->set('admin-'.$user_id);
    			}
    		}
    	}
    }










}