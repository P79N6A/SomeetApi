<?php
function random($length = 6, $numeric = 0)
{
    PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
    if ($numeric) {
        $hash = sprintf('%0'.$length.'d', mt_rand(0, pow(10, $length) - 1));
    } else {
        $hash = '';
        $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789abcdefghjkmnpqrstuvwxyz';
        $max = strlen($chars) - 1;

        for ($i = 0; $i < $length; $i++) {
            $hash .= $chars[mt_rand(0, 6)];
        }
    }
    return $hash;
}

/**
 * 获取本周到前一个月的时间
 * @param $time integer 当前活动的时间
 * @return bool true:本周活动 | false:上周活动
 */
function getRecenMtonths()
{
    $date = date('Y-m-d');  //当前日期
    $first = 1; //$first =1 表示每周星期一为开始日期 0表示每周日为开始日期
    $w = date('w', strtotime($date));  //获取当前周的第几天 周日是 0 周一到周六是 1 - 6
    $now_start = date('Y-m-d', strtotime("$date -".($w ? $w - $first : 6).' days')); //获取本周开始日期，如果$w是0，则表示周日，减去 6 天
    $last_end_time = strtotime($now_start." 00:00:00");
    return $last_end_time - 30*86400;
}

/**
 * 判断是否是本周活动
 * @param $time integer 当前活动的时间
 * @return bool true:本周活动 | false:上周活动
 */
function getLastEndTime()
{
    $date = date('Y-m-d');  //当前日期
    $first = 1; //$first =1 表示每周星期一为开始日期 0表示每周日为开始日期
    $w = date('w', strtotime($date));  //获取当前周的第几天 周日是 0 周一到周六是 1 - 6
    $now_start = date('Y-m-d', strtotime("$date -".($w ? $w - $first : 6).' days')); //获取本周开始日期，如果$w是0，则表示周日，减去 6 天
    $last_end_time = strtotime($now_start." 00:00:00");
    return $last_end_time;
}

/**
 * 判断是否为上周活动
 * @param $time integer 当前活动的时间
 * @return bool true:本周活动 | false:上周活动
 */
function getWeekBefore()
{
    $date = date('Y-m-d');  //当前日期
    $first = 1; //$first =1 表示每周星期一为开始日期 0表示每周日为开始日期
    $w = date('w', strtotime($date));  //获取当前周的第几天 周日是 0 周一到周六是 1 - 6
    $now_start = date('Y-m-d', strtotime("$date -".($w ? $w - $first : 6).' days')); //获取本周开始日期，如果$w是0，则表示周日，减去 6 天
    $last_end_time = strtotime($now_start." 00:00:00");
    $get_week_before = $last_end_time - 604800;
    return $get_week_before;
}
/**
 * 获取 对应的城市名
 * @return mixed
 */
function getIpCity()
{
        $session = Yii::$app->session;
        $city = $session->get('city')?$session->get('city'):'';
        if($city){
            return $city;
        }
        $ip = $_SERVER['REMOTE_ADDR'];
        if($ip == '222.128.161.156'){
            $session->set('city','北京');
            return '北京';
        }
        // http://ip.taobao.com/service/getIpInfo.php?ip=123.54.23.56
        $ipContent = @file_get_contents('http://ip.taobao.com/service/getIpInfo.php?ip='.$ip);
        if(!$ipContent){
            $session->set('city','北京');
            return '北京';
        }
        $data = json_decode($ipContent,true);
        $city = isset($data['data']['region'])?$data['data']['region']:'北京';
        $city = $city!='北京'?'北京':$city;
        $session->set('city',$city);
}

/**
 * 获取城市编号
 * @return mixed
 */
function getCityId()
{
    $session = Yii::$app->session;
    $city_id = $session->get('city_id');
    return $city_id?$city_id:2;
}

/**
 * 设置城市编号
 * @param int $city_id
 */
function setCityId($city_id=2)
{
    $session = Yii::$app->session;
    $session->set('city_id', $city_id);
}
/**
 * 设置周数
 * @param int $city_id
 */
function setWeek($week='')
{   
    $session = Yii::$app->session;
    $user_id = Yii::$app->user->id;
    $week = is_numeric($week)?$week:date('W');
    $session->set($user_id.'week', $week);
}
/**
 * 获取周数
 * @return int $city_id
 */
function getWeek()
{
    $session = Yii::$app->session;
    $user_id = Yii::$app->user->id;
    $week = $session->get($user_id.'week') > 0?$session->get($user_id.'week'):0;
    return $week; 
}
/**
 * 获取城市名称
 * @return mixed
 */
function getCity()
{
    $session = Yii::$app->session;
    return $session->get('city', '北京');
}

/**
 * 设置城市
 * @param string $city
 */
function setCity($city = '北京')
{
    $session = Yii::$app->session;
    $session->set('city', $city);
}

function hasCityId()
{
    $session = Yii::$app->session;
    return $session->has('city_id');
}

/**
 * 前台获取用户选择的城市
 * @return int
 */
function getUserCityId()
{
    $user_id = Yii::$app->user->id;
    if (!$user_id) {
        return 2;
    }

    $user = \someet\common\models\User::findOne($user_id);
    if (!$user) {
        return 2;
    }
    return $user->city_id;
}

/**
 * 前台设置用户选择的城市
 * @param int $city_id
 */
function setUserCityId($city_id = 2)
{
    $user_id = Yii::$app->user->id;
    if ($user_id > 0 && $city_id!=getUserCityId()) {
        \someet\common\models\User::updateAll(['city_id' => $city_id], ['id' => $user_id]);
    }
}

// 判断数据是否为序列化数据
function is_serialized( $data ) {
         $data = trim( $data );
         if ( 'N;' == $data )
             return true;
         if ( !preg_match( '/^([adObis]):/', $data, $badions ) )
             return false;
         switch ( $badions[1] ) {
             case 'a' :
             case 'O' :
             case 's' :
                 if ( preg_match( "/^{$badions[1]}:[0-9]+:.*[;}]\$/s", $data ) )
                     return true;
                 break;
             case 'b' :
             case 'i' :
             case 'd' :
                 if ( preg_match( "/^{$badions[1]}:[0-9.E-]+;\$/", $data ) )
                     return true;
                 break;
         }
         return false;
}