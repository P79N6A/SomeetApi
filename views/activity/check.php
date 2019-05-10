<div class="layui-tab layui-tab-brief" lay-filter="demoTitle">
    <div class="site-demo-title">
    	<div class="layui-container" style="width:100%;">  
		<div class="layui-row">
		<div class="layui-col-md10 active-index-menu-button">
			<button id='week-act-button' class="layui-btn layui-btn-normal activity-index-button-active">未审核活动</button>
			<button id='pass-act-button' class="layui-btn layui-btn-warm">已通过</button>
			<button id='reject-act-button' class="layui-btn layui-btn-primary">已拒绝</button>
			<button style='display:none;' id='uploadImage'>上传</button>
		</div>
    </div>
    <hr>
    <table class="layui-hide" id="actList" lay-filter="actList"></table>
    <!-- 设置一个上传二维码的活动id 值 -->
    <input type="hidden" name="number" value="0" id='groupCodeId'>
    <input type="" name="">
	<script type="text/html" id="barDemo">
		<a class="layui-btn layui-btn-xs" lay-event="edit">编辑查看</a>
		<a class="layui-btn layui-btn-xs" lay-event="reject">取消通过</a>
		<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
		<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event='release'>
			发布
		</a>
		<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event='group_code'>
			群二维码
		</a>
	</script>
	<script type="text/html" id="barDemoForReject">
		<a class="layui-btn layui-btn-xs" lay-event="edit">编辑查看</a>
		<a class="layui-btn layui-btn-xs" lay-event="reject">通过</a>
	</script>
	<script type='text/html' id='barDemoForCheck'>
		<a class="layui-btn layui-btn-xs" lay-event="edit">编辑查看</a>
		<a class="layui-btn layui-btn-xs" lay-event="pass">通过</a>
		<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="reject">拒绝</a>
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
		is_history:1,
		status:8
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
	  ,{field:'title', title:'标题', width:120 }
	  ,{field:'desc', title:'描述', width:180}
	  ,{field:'reject_reason', title:'拒绝理由', width:180}
	  ,{fixed: 'right', title:'操作', toolbar: '#barDemoForCheck',width:200}
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
			layer.prompt({
				formType: 2
				,value: data.email
			}, function(value, index){
					obj.update({
					email: value
				});
				layer.close(index);
			});
		break;
		case 'release':
		layer.confirm('大兄弟你可想好了', {icon: 6, title:'提示'}, function(index){
			layer.close(index);
		});
		break;
		case 'pass':
		if(data.status == 12){
			layer.msg('已经是通过状态了')
			return false;
		}
		layer.confirm('通过再改得收费了啊', {icon: 6, title:'提示'}, function(index){
				$.ajax({
					url:'/back/activity/update-status',
					type:'put',
					data:{
						status:12,
						id:data.id,
						reject:''
					},
					success:function(res){
						layer.msg('好的,如你所愿', {icon: 6}); 
						obj.del();
						layer.close(index);
					},error:function(){
						layer.msg('刚才出了个小差，建议再试一次啦', {icon: 2}); 
					}
				})
		});
		break;
		case 'reject':
		if(data.status == 3){
			layer.msg('已经是拒绝状态了')
			return false;
		}
		layer.confirm('真的要拒绝人家嘛？', {icon: 6, title:'提示'}, function(index){
			layer.prompt({
			  formType: 2,
			  title: '拒绝人家总得有个理由吧',
			  area: ['800px', '350px'] //自定义文本域宽高
			}, function(value, index, elem){
			  $.ajax({
					url:'/back/activity/update-status',
					type:'put',
					data:{
						status:3,
						id:data.id,
						reject:value
					},
					success:function(res){
						layer.msg('好啦，拒绝啦', {icon: 6}); 
						obj.del();
						layer.close(index);
					},error:function(){
						layer.msg('没拒绝成功，再试一次吧', {icon: 2}); 
					}
				})
			  
			});
		});
		break;
		case 'group_code':
			$('#groupCodeId').val(obj.data.id);
			if(!$('#groupCodeId').val()){
				layer.msg('抱歉我反应慢了,没设置上数据', {icon: 6}); 
				return false;
			}else{
				var code = $('#groupCodeId').val();
				layer.msg(code, {icon: 6}); 
				if($('#groupCodeId').val()){
					$('#uploadImage').click()
				}
			}
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
//切换未审核活动
$('#week-act-button').click(function(){
	var index4 = layer.load(4);
	table.reload('actList',{
		where:{
			is_history:1,
			status:8
		},
		page: {
		    curr: 1 //重新从第 1 页开始
		},
		done:function(res, curr, count){
			layer.close(index4)
		}
	})
	
})
//切换已审核活动
$('#pass-act-button').click(function(){
	var index4 = layer.load(4);
	table.reload('actList',{
		where:{
			is_history:1,
			status:12
		},
		page: {
		    curr: 1 //重新从第 1 页开始
		},
		done:function(res, curr, count){
			layer.close(index4)
		}
	})
	
})
//拒绝的活动
$('#reject-act-button').click(function(){
	var index4 = layer.load(4);
	table.reload('actList',{
		where:{
			is_history:1,
			status:3
		},
		page: {
		    curr: 1 //重新从第 1 页开始
		},
		done:function(res, curr, count){
			layer.close(index4)
		}
	})
	
})
//点击单行数据
table.on('rowDouble(actList)', function(obj){
  console.log(obj.data) //得到当前行数据
  window.location.href='/activity/add?id='+obj.data.id
});
</script>