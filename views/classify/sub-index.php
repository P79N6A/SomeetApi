<div class="site-demo-title">
	<div class="layui-container" style="width:100%;">  
		<div class="layui-tab" lay-filter="type">
			<form class="layui-form">
				<div class="layui-form-item">
				    <label class="layui-form-label">选择一级</label>
				    <div class="layui-input-block">
				      <select name="pid" lay-filter='parentClassify' id='parentTop' lay-verify="required">
				        <option value="0">全部</option>
				      </select>
				    </div>
			  	</div>
			</form>
			<div class="layui-tab-content">
			    <div class="layui-tab-item layui-show">
			    	<table class="layui-hide" id="all" lay-filter="all"></table>
			    </div>
			</div>
			<script type="text/html" id="barDemo">
				<a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
			</script>
			<script type="text/html" id="switchTplForLock">
			  <input type="checkbox" name="status" value="{{d.id}}" lay-skin="switch" lay-text="显示|隐藏" lay-filter="switchTplForLock" {{ d.status == 10 ? 'checked' : '' }}>
			</script>
		</div>
</div>
<script type="text/javascript">
	var $ = layui.jquery

	var token = $('#access_token').val();
	$.ajaxSettings.beforeSend = function(xhr,request){
	    xhr.setRequestHeader('Authorization','Bearer '+token);
	}
	var form = layui.form; 
	form.render();
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
	//监听行工具事件
	table.on('tool(all)', function(obj){
		var data = obj.data;
		console.log(data)
		switch(obj.event){
			case 'edit':
				window.open('/classify/sub?id='+data.id)
			break;
		}
	});
	//获取父类id
	$.ajax({
		url:'/back/classify/get-top',
		type:'get',
		success:function(res){
			var str ='';
			if(res.data == 'error') return false;
			$.each(res.data,function(index,val){
				str+='<option value="'+val.id+'">'+val.name+'</option>'
			})
			$('#parentTop').append(str)
			form.render('select');
		},
		error:function(){
			console.log('error')
		}
	})
	form.on('select(parentClassify)', function(data){
		var pid = data.value;
		console.log(pid)
		var obj = {};
		obj.title=pid
		obj.where = {
			pid:pid
		}
		table.reload('all',obj);
	}); 
	form.on('switch(switchTplForLock)', function(data){
	  var type ='';
	  if(data.elem.checked){
	  		type='show'
	  }else{
	  		type='hide'
	  }
	  var obj = {
	  	data:{
	  		id:data.value
	  	},
	  	event:type
	  }
	  options(obj);
	}); 
	function options(obj){
		var data = obj.data;
		switch(obj.event){
			case 'show':
				lock(data.id,'show')
			break;
			case 'hide':
				lock(data.id,'hide')
			break;
		}
	}
	//封禁用户操作
	function lock(id,type){
		if(type=='hide'){
			var data = {
					_csrf:_csrf,
					type:'hide',
					status:20,
					id:id
				}
			httpRequest(data)
		}else{
			var data = {
					_csrf:_csrf,
					type:'show',
					status:10,
					id:id
				}
			httpRequest(data)
		}
	}
	//初始化表格数据
	function initObj(){
		return {
			elem: '#all',
			id:'all'
			,url:'/back/classify/get-top-list'
			,where:{
				pid:0
			}
			,title: '分类数据表'
			,parseData: function(res){ //res 即为原始返回的数据
			    return {
			      "code": 0, //解析接口状态
			      "msg": res.status_code, //解析提示文本
			      "count": res.data.count, //解析数据长度
			      "data": res.data.data //解析数据列表
			    };
			}
			,cols: [[
			  {field:'id', title:'ID编号', width:60,sort: true}
			  ,{field:'pid', title:'ID编号', width:100,sort: true}
			  ,{field:'name', title:'类型名称',width:100 ,edit: 'text'}
			  ,{field:'english_name', title:'分享文案', width:200 }
			  ,{field:'subscribe_num', title:'所属', width:120,templet: function(d){
		        return d.is_app == 0?'web':'app';
		      }}
		      ,{field:'status', title:'是否显示', width:100,templet:'#switchTplForLock'}
		      ,{fixed: 'right', title:'操作', toolbar: '#barDemo',width:100}
			  
			]]
			,page: {'limit':20}
		} 
	}
	//通知服务器更新状态
	function httpRequest(data){
		$.ajax({
			url:'/back/classify/update-sub-status',
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
</script>