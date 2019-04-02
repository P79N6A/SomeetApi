<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use Yii;
use app\common\service\LarkService;
use app\models\AppPush;
/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class CommandController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     * ou_9862e218c5d9b706dbc376da8b8b5d38---李迪   ou_e1e40c24b73f9be06be9d2b379908d8b--小白
     * Someet 群ID --  oc_99674dcbea3fa8714a1ea498d3376d50  
     * 测试群id --  oc_7dd10d706d248ffed6445f981e6429d7
     * 我的ID --  ou_facf44bac1b1ee63bc6106f88de35130
     */
    public function actionIndex()
    {

        $redis = Yii::$app->redis;
        $list = $redis->lpop('fileList');
        if(!$list){
            echo '没有啦';
            return false;
        }
        $resData = unserialize($list);
        if(!$redis->get('send-'.$resData['obj_token']) && $resData){
            $data=[
                'open_chat_id'=>'oc_7dd10d706d248ffed6445f981e6429d7',
                'msg_type'=>'text',
                'content'=>["text"=>'<at open_id="ou_9862e218c5d9b706dbc376da8b8b5d38">@李迪</at><at open_id="ou_e1e40c24b73f9be06be9d2b379908d8b">@白惠泽</at> 小伙伴发布啦，去看看吧！！！'],
                // 'root_id'=>$message_id
            ];
            $res = LarkService::sendToGroup($data);
            $data1=[
                'open_chat_id'=>'oc_7dd10d706d248ffed6445f981e6429d7',
                'msg_type'=>'text',
                'content'=>["text"=>$resData['url']],
                // 'root_id'=>$message_id
            ];
            $res1 = LarkService::sendToGroup($data1);
            $res = json_decode($res,true);
            $res1 = json_decode($res1,true);
            if($res1['code'] == 0){
                AppPush::updateAll(['status'=>20],['from_type'=>$resData['obj_token']]);
                $redis->set('send-'.$resData['obj_token'],$resData['obj_token']);
            }
        }
    }

    public function actionGetLogList(){
        LarkService::getLogList();
    }
}
