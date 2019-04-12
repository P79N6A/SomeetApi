<?php
namespace app\common\service;
use app\common\service\BaseService;
use app\models\Activity;
use app\models\User;
use app\models\profile;
use app\models\YellowCard;
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
			case 'black':
				User::updateAll(['black_label'=>User::BLACK_LIST_YES],['id'=>$data['id']]);
				$user = User::find()->select(['black_label'])->where(['id'=>$data['id']])->one();
				return $user && $user->black_label == User::BLACK_LIST_YES ?true:false;
				break;
			case 'lock':
				User::updateAll(['status'=>User::STATUS_LOCK],['id'=>$data['id']]);
				$user = User::find()->select(['status'])->where(['id'=>$data['id']])->one();
				return $user && $user->status == User::STATUS_LOCK ?true:false;
				break;
			case 'unlock':
				User::updateAll(['status'=>User::STATUS_ACTIVE],['id'=>$data['id']]);
				$user = User::find()->select(['status'])->where(['id'=>$data['id']])->one();
				return $user && $user->status == User::STATUS_ACTIVE ?true:false;
				break;
			case 'unblack':
				User::updateAll(['black_label'=>User::BLACK_LIST_NO],['id'=>$data['id']]);
				$user = User::find()->select(['black_label'])->where(['id'=>$data['id']])->one();
				return $user && $user->black_label == User::BLACK_LIST_NO ?true:false;
				break;
		}
	}
}