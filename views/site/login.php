<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>登录</title>
  <link rel="stylesheet" href="/layui/css/layui.css">
  <link rel="stylesheet" type="text/css" href="/css/login.css">
</head>
<body>
<div class="loginPage-background">
    <div class="layui-anim layui-anim-up loginPage">
        <form class="layui-form" action="/">
            <div class="layui-form-item loginPage-username">
                <label class="layui-form-label"><i class="layui-icon layui-icon-username"></i></label>
                <div class="layui-input-block">
                  <input type="text" value="admin" name="username" required  lay-verify="required" placeholder="请输入用户名" autocomplete="off" class="layui-input limitWidth">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><i class="layui-icon layui-icon-password"></i></label>
                <div class="layui-input-block">
                  <input value="adminadmin" type="password" name="password" required lay-verify="required" placeholder="请输入密码" autocomplete="off" class="layui-input limitWidth">
                </div>
                <!-- <div class="layui-form-mid layui-word-aux">辅助文字</div> -->
            </div>

            <div class="layui-form-item">
                <div class="layui-input-block">
                  <button class="layui-btn" lay-submit lay-filter="login">登录</button>
                  <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                  <button type="button" class="layui-btn" style="background-color: none;"><i class="layui-icon layui-icon-login-wechat"></i></button>
                </div>
            </div>
        </form>
    </div> 
</div>
<script src="/layui/layui.js"></script>
<script>
// layui.config({
//   base: '/layui/js/modules/' //你存放新模块的目录，注意，不是layui的模块目录
// }).use('index'); //加载入口

layui.use('form', function(){
  var form = layui.form;
  
  //监听提交
  form.on('submit(login)', function(data){
    layer.msg(JSON.stringify(data.field));
    login(data.field);
    return false;
  });
});
function login(data){
    var $ = layui.$
    var csrf = $('#_csrf').val();
    console.log(csrf)
    $.ajax({
        url:'/site/login',
        type:'post',
        data:data,
        success:function(res){
            console.log(res)
        },
        error:function(){
            layer.msg('网络错误，请稍后再试');
        }
    });
}
</script> 
</body>
</html>