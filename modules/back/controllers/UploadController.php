<?php
namespace app\modules\back\controllers;
use Yii;
use app\component\BaseController;
use yii\web\Response;
use app\models\Activity;
use app\models\User;
use yii\filters\AccessControl;
use yii\base\ActionFilter;

class UploadController extends BaseController{
	
	public function behaviors(){
        return [
            'access' => [
                'class' => 'app\component\AccessControl',
                'allowActions' => [
                    'upload-image',
                    'upload-file'
                ],
            ],
        ];

    }

    /**
     * {@inheritdoc}
     */
    public function beforeAction($action)
    {
        Yii::$app->controller->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
    public function actionUploadFile(){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $file = $_FILES["file"];
        $qiniu = Yii::$app->qiniu;
        // $res = $qiniu->uploadFile($file['tmp_name']);
        // return $res;
        if(isset($res['hash'])){
            return [
                'url'=>'http://img.someet.cc/FpyzpZ09e26yoFnwIy3LlYqwmVCk',
                'status'=>200,
                'data'=>$res['hash']
            ];
        }
        return [
            'url'=>'http://img.someet.cc/FpyzpZ09e26yoFnwIy3LlYqwmVCk',
            'status'=>200,
            'data'=>'1234'
        ];
    }
    /**
     * 上传图片
     */
    public function actionUploadImage(){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'url'=>'http://img.someet.cc/FpyzpZ09e26yoFnwIy3LlYqwmVCk',
            'status'=>200,
        ];
        $request = Yii::$app->request;
        //获取七牛上传token
        $token = self::GetUploadToken();
        $upToken = $token['token'];
        //获取上传过来的图片数据
        $fetch =$request->post('imgData');
        if(!$fetch){
            return [
                'url'=>'',
                'status'=>0
            ];
        }
        //转换上传所需的图片数据
        $fetchData = explode('data:image/jpeg;base64,', $fetch);
        $fetch = $fetchData[1];
        $uploadResult = $this->request_by_curl('http://upload.qiniu.com/putb64/-1',$fetch,$upToken);
        $uploadResultJson = json_decode(trim($uploadResult),true);
        $imgHash = $uploadResultJson['hash'];
        $imgUrl = 'http://img.someet.cc/'.$imgHash;
        return [
            'url'=>$imgUrl,
            'status'=>200
        ];
    }

    /**
     * 获取七牛的token
     * @return array
     */
    public static function GetUploadToken()
    {

        $bucket = Yii::$app->params['qiniu.bucket'];
        $expires = Yii::$app->params['qiniu.upload_token_expires'];
        $qiniu = Yii::$app->qiniu;
        $token = $qiniu->getUploadToken($bucket, null, $expires);
        // print_r($token);
        return [
            'token' => $token,
            'bucket' => $bucket,
            'expires' => $expires,
        ];
    }
    /**
     * 网络请求
     */
    public function request_by_curl($remote_server,$post_string,$upToken) {

        $headers = array();
        $headers[] = 'Content-Type:image/png';
        $headers[] = 'Authorization:UpToken '.$upToken;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$remote_server);
        //curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER ,$headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }
}