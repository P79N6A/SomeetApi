<div class="layui-tab layui-tab-brief" lay-filter="demoTitle">
    <div class="site-demo-title">
    <hr>
    <table class="layui-hide" id="test" lay-filter="test"></table>
	<script type="text/html" id="barDemo">
		<a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
	</script>
	
</div>
<script>
var $ = layui.jquery
var token = $('#access_token').val();
$.ajaxSettings.beforeSend = function(xhr,request){
    xhr.setRequestHeader('Authorization','Bearer '+token);
}
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
,url:'/back/space/get-list'
,title: '发起人场地数据表'
,where:{
	type:'founder'
}
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
  ,{field:'name', title:'名称',width:100 ,edit: 'text'}
  ,{field:'area', title:'商圈',width:100 ,edit: 'text'}
  ,{field:'address', title:'地址名称', width:120 }
  ,{field:'detail', title:'详细地址', width:380,edit: 'text'}
  ,{fixed: 'right', title:'操作', toolbar: '#barDemo',width:100}
]]
,page: {'limit':20}
});
//监听行工具事件
table.on('tool(test)', function(obj){
	var data = obj.data;
	if(obj.event === 'edit'){
	  window.location.href= '/space/edit?id='+data.id
	}
});
//新增活动按钮
$('#addNew').click(function(){
	window.open('/activity/add');
})
</script>