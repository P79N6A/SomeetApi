<?php
namespace app\common\service;
use app\common\service\BaseService;
use app\models\Activity;
use app\models\User;
use app\models\Answer;
use app\models\profile;
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
		$user['is_admin'] = 0;
		$user['is_founder'] = 0;
		$user = User::find()->select(['id','username','wechat_id','mobile','created_at','last_login_at','founder_desc'])->where(['id'=>$id])->asArray()->one();
		if(in_array('profile', $fields)){
			$profile = Profile::find()->select(['headimgurl','sex','birth_year','birth_month','birth_day'])->where(['user_id'=>$id])->asArray()->one();
			$user['profile'] = $profile;
		}
		if(in_array('tags', $fields)){
			$tags = UserSelectTags::find()->select(['id','tag_title'])->where(['user_id'=>$id])->asArray()->all();
			$user['tags'] = $tags;
		}
		if(in_array('is_admin', $fields) || in_array('is_founder', $fields)){
			$role = AuthAssignment::find()->where(['user_id'=>$id])->asArray()->all();
			if($role){
				foreach($role as $row){
					if($row['item_name'] == 'admin'){
						$user['is_admin']=1;
					}
					if($row['item_name'] == 'founder'){
						$user['is_founder']=1;
					}
				}
			}
		}
		if(in_array('answers', $fields)){
			$aid = [];
			$answes = Answer::find()->select(['activity_id'])->where(['user_id'=>$id])->asArray()->all();
			foreach ($answes as $row) {
				array_push($aid,$row['activity_id']);
			}
			if(!empty($aid)){
				$user['answes'] = Activity::find()->select(['title','start_time'])->where(['in','id',$aid])->asArray()->all();
			}
		}
		if(in_array('activity', $fields)){
			$user['activity'] = Activity::find()->select(['title','start_time'])->where(['created_by'=>$id])->asArray()->all();
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
		return $user;
	}
}