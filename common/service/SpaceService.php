<?php
namespace app\common\service;
use app\common\service\BaseService;
use app\models\Activity;
use app\models\SpaceSpot;
use app\models\FounderSpaceSpot;
use yii\web\Response;
use Yii;
use yii\db\ActiveQuery;
use app\component\CommonFunction;
use yii\data\Pagination;
class SpaceService extends BaseService{

	//获取发起人的活动场地列表
	public static function getList($user_id,$type='founder'){
		if($type=='founder'){
			$list = FounderSpaceSpot::find()->select(['id','name','area','address','detail','longitude','latitude'])->where(['user_id'=>$user_id])->asArray()->all();
		}else{
			$list = SpaceSpot::find()->select(['id','name','area','address','detail','longitude','latitude'])->limit(30)->orderBy('id desc')->asArray()->all();
		}
		return $list;
	}
	/**
	 * 分页获取场地地址
	 */
	public static function getListByPage($data){
		if($data['type']=='founder'){
			$query = FounderSpaceSpot::find()->select(['id','name','area','address','detail','longitude','latitude']);
		}else{
			$query = SpaceSpot::find()->select(['id','name','area','address','detail','longitude','latitude'])->limit(30)->orderBy('id desc');
		}

		$count = $query->count();
		$list['count'] = $count;
		$page = new Pagination(['totalCount' => $count,'pageSize'=>$data['limit']]);
		$list['data'] = $query->asArray()->offset($page->offset)->limit($page->limit)->all();
		return $list;
	}
	/**
	 * 获取单个场地
	 */
	public static function getSpace($id,$type='founder'){
		if($type=='founder'){
			$list = FounderSpaceSpot::find()->select(['id','name','area','address','detail','longitude','latitude'])->where(['id'=>$id])->asArray()->one();
		}else{
			$list = SpaceSpot::find()->select(['id','name','area','address','detail','longitude','latitude'])->where(['id'=>$id])->asArray()->one();
		}
		return $list;
	}
	/**
	 * 获取经纬度
	 */
	public static function getLng($address, $type='json')
    {
        $url=Yii::$app->params['amap_url'];
        $key=Yii::$app->params['amap_key'];

        $url = $url."?address={$address}&output={$type}&key={$key}";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        if (isset(json_decode($result)->geocodes[0])) {
            $location = json_decode($result)->geocodes[0]->location;
            if ($location) {
                $location = explode(',', $location);
                return $location;
            }
        }

        return array('longitude'=>0,'latitude'=>0);
    }
}