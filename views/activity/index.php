<div class="layui-tab layui-tab-brief" lay-filter="demoTitle">
    <div class="site-demo-title">
    	<div class="layui-container" style="width:100%;">  
		<div class="layui-row">
		<div class="layui-col-md10 active-index-menu-button">
			<button class="layui-btn" id="addNew">新建活动</button>
			<button id='week-act-button' class="layui-btn layui-btn-normal activity-index-button-active">本周活动</button>
			<button id='history-act-button' class="layui-btn layui-btn-primary">历史活动</button>
			<button id='release-act-button' class="layui-btn layui-btn-warm">预发布活动</button>
			<button style='display:none;' id='uploadImage'>上传</button>
		</div>
    </div>
    <hr>
    <table class="layui-hide" id="actList" lay-filter="actList"></table>
    <!-- 设置一个上传二维码的活动id 值 -->
    <input type="hidden" name="number" value="0" id='groupCodeId'>
    <input type="" name="">
	<script type="text/html" id="barDemo">
		<a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
		<a class="layui-btn layui-btn-xs" lay-event="answer">报名管理</a>
		<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
		<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event='release'>
			发布
		</a>
	</script>
	
</div>
<script type="text/javascript" src='/layui/js/croppers.js'></script>
<script type="text/javascript" src='/layui/js/modules/cropper.js'></script>
<script>
var $ = layui.jquery
var token = $('#access_token').val();
$.ajaxSettings.beforeSend = function(xhr,request){
    xhr.setRequestHeader('Authorization','Bearer '+token);
}
//设置一个变量判断是否切换到历史活动
var is_history = 0;
// //注意：导航 依赖 element 模块，否则无法进行功能性操作
var element = layui.element;
var cropper = layui.croppers;
var obj = {
		elem: '#uploadImage',
        saveW: '150',
        saveH: '150',
        mark: '1',
        area: '60rem',
        url: '/upload/upload-image',
        done: function(path){
        	console.log(path);
        },
        extEle:'#groupCodeId'
	}
cropper.render(obj);
//表格事件
var table = layui.table;
var currentWeekUrl='/back/activity/index'
//设置当前的状态
var actButtonStatus = 'week';
var index = layer.load(4);
var options = {
	elem: '#actList',
	where:{
		is_history:0
	},
	text: {
	    none: '暂无相关数据'
	}
	,url:currentWeekUrl
	,parseData: function(res){ //res 即为原始返回的数据
	    return {
	      "code": 0, //解析接口状态
	      "msg": res.status_code, //解析提示文本
	      "count": res.data.count, //解析数据长度
	      "data": res.data.data //解析数据列表
	    };
	}
	,title: '用户数据表'
	,cols: [[
	  {field:'id', title:'ID编号', width:100,sort: true}
	  ,{field:'username', title:'用户名',width:100}
	  ,{field:'title', title:'标题', width:160 }
	  ,{field:'desc', title:'描述', width:200}
	  ,{fixed: 'right', title:'操作', toolbar: '#barDemo',width:300}
	]]
	,page: {'limit':20},
	done:function(res, curr, count){
		layer.close(index);
	}
}
table.render(options);
//监听行工具事件
table.on('tool(actList)', function(obj){
	var data = obj.data;
	switch(obj.event){
		case 'del':
		layer.confirm('真的删除行么', function(index){
			obj.del();
			layer.close(index);
		});
		break;
		case 'edit':
			window.open('/activity/add?id='+data.id);
		break;
		case 'release':
		if(is_history == 1){
			layer.msg('历史活动无法发布')
			return false;
		}
		layer.confirm('大兄弟你可想好了', {icon: 6, title:'提示'}, function(index){
			layer.close(index);
		});
		break;
	}
});
//新增活动按钮
$('#addNew').click(function(){
	window.open('/activity/add');
})
//切换活动
$('.active-index-menu-button button').click(function(){
	$('.active-index-menu-button button').removeClass('activity-index-button-active')
	$(this).addClass('activity-index-button-active');
})
//切换本周活动
$('#week-act-button').click(function(){
	is_history = 0;
	var index4 = layer.load(4);
	table.reload('actList',{
		where:{
			is_history:0,
			status:0
		},
		page: {
		    curr: 1 //重新从第 1 页开始
		},
		done:function(res, curr, count){
			layer.close(index4)
		}
	})
	
})
//切换历史活动
$('#history-act-button').click(function(){
	is_history = 1;
	var index4 = layer.load(4);
	table.reload('actList',{
		where:{
			is_history:1,
			status:0
		},
		page: {
		    curr: 1 //重新从第 1 页开始
		},
		done:function(res, curr, count){
			layer.close(index4)
		}
	})
	
})
//预发布活动
$('#release-act-button').click(function(){
	is_history = 0;
	var index4 = layer.load(4);
	table.reload('actList',{
		where:{
			status:15
		},
		page: {
		    curr: 1 //重新从第 1 页开始
		},
		done:function(res, curr, count){
			layer.close(index4)
		}
	})
	
})
</script>