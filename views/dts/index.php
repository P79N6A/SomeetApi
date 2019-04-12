<div class="layui-tab layui-tab-brief" lay-filter="demoTitle">
    <div class="site-demo-title">
    	<div class="layui-container" style="width:100%;">  
		<div class="layui-row">
		<div class="layui-col-md10">
			<button class="layui-btn" id="addNew">新建活动</button>
			<button class="layui-btn layui-btn-normal">本周活动</button>
			<button class="layui-btn layui-btn-normal">历史活动</button>
			<button class="layui-btn layui-btn-normal">预发布活动</button>
			<button class="layui-btn layui-btn-danger">一键预发布活动</button>
		</div>
    </div>
    <hr>
    <table class="layui-hide" id="test" lay-filter="test"></table>
	<script type="text/html" id="barDemo">
		<a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
		<a class="layui-btn layui-btn-xs" lay-event="edit">报名管理</a>
		<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
		<a class="layui-btn layui-btn-danger layui-btn-xs">
			发布
		</a>
		<a class="layui-btn layui-btn-danger layui-btn-xs">
			群二维码
		</a>
	</script>
	
</div>
<script>
var $ = layui.jquery
// //注意：导航 依赖 element 模块，否则无法进行功能性操作
var element = layui.element;
//一些事件监听
element.on('tab(demoTitle)', function(data){
console.log(data);
});
//表格事件
var table = layui.table;  
table.render({
elem: '#test'
,url:'/demo.json'
,title: '用户数据表'
,cols: [[
  {field:'id', title:'ID编号', width:100,sort: true}
  ,{field:'username', title:'用户名',width:100 ,edit: 'text'}
  ,{field:'title', title:'标题', width:120 }
  ,{field:'desc', title:'描述', width:180,edit: 'text'}
  ,{fixed: 'right', title:'操作', toolbar: '#barDemo',width:400}
]]
,page: true
});
//监听行工具事件
table.on('tool(test)', function(obj){
	var data = obj.data;
	//console.log(obj)
	if(obj.event === 'del'){
	  layer.confirm('真的删除行么', function(index){
	    obj.del();
	    layer.close(index);
	  });
	} else if(obj.event === 'edit'){
	  layer.prompt({
	    formType: 2
	    ,value: data.email
	  }, function(value, index){
	    obj.update({
	      email: value
	    });
	    layer.close(index);
	  });
	}
});
//新增活动按钮
$('#addNew').click(function(){
	window.open('/activity/add');
})
</script>