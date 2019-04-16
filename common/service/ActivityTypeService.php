<?php
namespace app\common\service;
use app\common\service\BaseService;
use app\models\Activity;
use app\models\ActivityType;
use yii\web\Response;
use Yii;
use yii\db\ActiveQuery;
use app\component\CommonFunction;
use yii\data\Pagination;
class ActivityTypeService extends BaseService{

	/**
	 * 获取所有可用的活动新类型
	 */
	public static function GetList(){
		$city_id = getCityId();
        $types = ActivityType::find()
            ->where(['city_id' => $city_id])
            ->select(['id','name','img'])
            ->orderBy([
                'display_order' => SORT_ASC,
                'id' => SORT_DESC,
            ])
            ->asArray()
            ->all();
        $weekWhere = ['>', 'start_time', getLastEndTime()];
        for ($i = 0; $i < count($types); ++$i) {
            $types[$i]['type_number'] = Activity::find()
                    ->where(
                            ['and',
                                ['in', 'status', [
                                    Activity::STATUS_DRAFT,
                                    Activity::STATUS_RELEASE,
                                    Activity::STATUS_PREVENT,
                                    Activity::STATUS_SHUT,
                                    Activity::STATUS_CANCEL,
                                    Activity::STATUS_PASS,

                                ]],
                                ['=', 'type_id', $types[$i]['id']],
                                $weekWhere,
                            ]
                        )
                    ->count();
        }

        return $types;
	}
}