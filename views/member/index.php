<div class="layui-tab layui-tab-brief" lay-filter="demoTitle">
    <div class="site-demo-title">
    	<div class="layui-container" style="width:100%;">  
		<div class="layui-tab" lay-filter="userType">
		  <ul class="layui-tab-title">
		    <li class="layui-this" data-status='all'>全部</li>
		    <li data-status='admin'>管理员</li>
		    <li data-status='founder'>发起人</li>
		    <li data-status='black'>黑名单</li>
		    <li data-status='block'>封禁人员</li>
		    <li data-status='apply'>申诉用户</li>
		  </ul>
			<div class="layui-tab-content">
			    <div class="layui-tab-item layui-show">
			    	<table class="layui-hide" id="all" lay-filter="all"></table>
			    </div>
			</div>
			<script type="text/html" id="switchTplForBlack">
			  <input type="checkbox" name="status" value="{{d.id}}" lay-skin="switch" lay-text="拉黑|解除" lay-filter="switchTplForBlack" {{ d.black_label == 1 ? 'checked' : '' }} {{ d.id == 1 ? 'disabled' : '' }}>
			</script>
			 
			<script type="text/html" id="switchTplForLock">
			  <input type="checkbox" name="status" value="{{d.id}}" lay-skin="switch" lay-text="封禁|解除" lay-filter="switchTplForLock" {{ d.status == -10 ? 'checked' : '' }} {{ d.id == 1 ? 'disabled' : '' }}>
			</script>
		</div>
    </div>
</div>
<script>
var $ = layui.jquery
var token = $('#access_token').val();
$.ajaxSettings.beforeSend = function(xhr,request){
    xhr.setRequestHeader('Authorization','Bearer '+token);
}
var form = layui.form 
var _csrf = $('#csrf').val();
// 设置一个记录操作状态的值
var action = 'all';
//表格事件
var table = layui.table; 
var tableData = initObj();
// tableData.cols[0].push({fixed: 'right', title:'操作', toolbar: '#barDemo',width:400})
// //注意：导航 依赖 element 模块，否则无法进行功能性操作
var element = layui.element;
table.render(tableData);
//一些事件监听
element.on('tab(userType)', function(res){
	var status = res.elem.context.dataset.status
	console.log(status)
	action = status
	switch(status){
		case 'all':
			var obj = {};
			obj.where ={
				is_all:1
			}
		break;
		case 'admin':
			var obj = {};
				obj.title='管理员数据表'
				obj.where = {
					is_admin:1
				}
		break;
		case 'founder':
			var obj = {};
			obj.title='发起人数据表'
			obj.where = {
				is_founder:1
			}
		break;
		case 'black':
			var obj = {};
			obj.title='拉黑用户数据表'
			obj.where = {
				is_black:1
			}
		break;
		case 'block':
			var obj = {};
			obj.title='封禁用户数据表'
			obj.where = {
				is_lock:1
			}
		break;
		case 'apply':
			var obj = {};
			obj.title='申诉用户数据表'
			obj.where = {
				is_apply:1
			}
		break;
	}
	table.reload('all',obj);
});

//监听行工具事件
table.on('tool(all)', function(obj){
	options(obj)
});
//监听按钮事件
form.on('switch(switchTplForBlack)', function(data){
  var type ='';
  if(data.elem.checked){
  		type='black'
  }else{
  		type='unblack'
  }
  var obj = {
  	data:{
  		id:data.value
  	},
  	event:type
  }
  options(obj);
}); 
form.on('switch(switchTplForLock)', function(data){
  var type ='';
  if(data.elem.checked){
  		type='lock'
  }else{
  		type='unlock'
  }
  var obj = {
  	data:{
  		id:data.value
  	},
  	event:type
  }
  options(obj);
}); 
//初始化表格数据
function initObj(){
	return {
		elem: '#all',
		id:'all'
		,url:'/back/member/get-list'
		,title: '用户数据表'
		,parseData: function(res){ //res 即为原始返回的数据
		    return {
		      "code": 0, //解析接口状态
		      "msg": res.status_code, //解析提示文本
		      "count": res.data.count, //解析数据长度
		      "data": res.data.data //解析数据列表
		    };
		}
		,cols: [[
		  {field:'id', title:'ID编号', width:100,sort: true}
		  ,{field:'username', title:'用户名',width:100 ,edit: 'text'}
		  ,{field:'sex', title:'性别', width:120 }
		  ,{field:'wechat_id', title:'微信号', width:120 }
		  ,{field:'mobile', title:'手机号', width:120 }
		  ,{field:'created_at', title:'加入时间', width:120 },
		  ,{field:'black_label', title:'是否拉黑', width:100,templet:'#switchTplForBlack'}
		  ,{field:'status', title:'是否封禁', width:100,templet:'#switchTplForLock'}
		  
		]]
		,page: true
	} 
}
function options(obj){
	var data = obj.data;
	switch(obj.event){
		case 'lock':
			lock(data.id,'lock')
		break;
		case 'black':
			black(data.id,'black');
		break;
		case 'unblack':
			black(data.id,'unblack')
		break;
		case 'unlock':
			lock(data.id,'unblock')
		break;
	}
}
//拉黑用户操作
function black(user_id,type){
	if(type=='black'){
		if(user_id == 1){
			layer.msg('管理员你都敢禁,你疯了啊', {icon: 6});
			return false;
		}
		var data = {
				_csrf:_csrf,
				type:'black',
				status:1,
				id:user_id
			}
		httpRequest(data)
	}else{
		var data = {
				_csrf:_csrf,
				type:'unblack',
				status:0,
				id:user_id
			}
		httpRequest(data)
	}
}
//通知服务器更新状态
function httpRequest(data){
	$.ajax({
		url:'/back/member/update-status',
		type:'post',
		data:data,
		success:function(res){
			if(res.data.status == 1){
				layer.msg('好了,操作完成', {icon: 6}); 
			}else{
				layer.msg('抱歉，出错了', {icon: 2}); 
			}
		},
		error:function(){
			layer.msg('抱歉，出错了', {icon: 2}); 
		}
	})
}
//封禁用户操作
function lock(user_id,type){
	if(type=='lock'){
		if(user_id == 1){
			layer.msg('管理员你都敢封,你疯了啊', {icon: 6});
			return false;
		}
		var data = {
				_csrf:_csrf,
				type:'lock',
				status:-10,
				id:user_id
			}
		httpRequest(data)
	}else{
		var data = {
				_csrf:_csrf,
				type:'unlock',
				status:10,
				id:user_id
			}
		httpRequest(data)
	}
}
//查看用户操作
function edit(user_id){
	layer.msg('稍等,马上传送过去', {icon: 6}); 
}
//新增活动按钮
$('#addNew').click(function(){
	window.open('/activity/add');
})
//点击单行数据
table.on('row(all)', function(obj){
  console.log(obj.data) //得到当前行数据
  window.location.href='/member/'+obj.data.id
});
</script>