<div class="site-demo-title" style="width: 60%;">
	<form class="layui-form" lay-filter='activity' action="/">
		<input type="hidden" value="<?php echo $data['id'];?>" id='aid' name="aid">
		<div>
			<!-- 开始上传活动图片 -->
			<div>
				<label class="layui-form-label"></label>
				<div class="uploadButton" data-width='400' data-height='277' data-type='poster' id='posterUpload'>
					<img src="<?php echo isset($data['detail']['poster']) && $data['detail']['poster']?$data['detail']['poster']:'http://img.someet.cc/Fh8n2ij-_xq4D7HUPyHIFfy629F7'; ?>" width="100%">
				</div>
				<input type="hidden" name="poster" id='poster' value="">
				<!-- <div class="layui-btn demoMore uploadButton" data-type='group_code'  id='groupCodeUpload'>上传群二维码</div>
				<input type="hidden" name="group_code" id='group_code' value=""> -->
			</div>
			<br>
			<!-- 开始上传活动图片结束 -->
			<!-- dts开始 -->
			<div class="layui-form-item">
			    <div class="layui-inline">
			      <label class="layui-form-label">DTS:</label>
			      <div class="layui-input-inline">
			        <select name="updated_by" lay-filter='dtsSelect' lay-verify="required" lay-search="">
			          <option value="">选择DTS</option>
			          <?php if($data['xhb']){foreach($data['xhb'] as $row){?>
				          <option value="<?php echo $row['id'];?>"><?php echo $row['username'];?></option>
				      <?php }}?>
			        </select>
			      </div>
			    </div>
			    <div class="layui-inline">
			      <label class="layui-form-label">PMA类型:</label>
			      <div class="layui-input-inline">
			        <select name="pma_type" lay-verify="required" lay-search="">
			          <option value="1">线上</option>
			          <option value="2">线下</option>
			        </select>
			      </div>
			    </div>
			</div>
			<!-- dts结束 -->
		</div>
		<!-- 发起人开始 -->
		<div>
			<div class="layui-form-item">
			    <div class="layui-inline">
			      <label class="layui-form-label">发起人:</label>
			      <div class="layui-input-inline">
			        <select name="created_by" lay-verify="required" lay-filter='founder' id="founder" lay-search="">
			          <option value="">选择发起人</option>
			        </select>
			      </div>
			    </div>
			    <div class="layui-inline">
			      <label class="layui-form-label">搜索发起人:</label>
			      <div class="layui-input-block">
				      <input type="text" id='searchFounderInput' autocomplete="off" placeholder="昵称,ID,手机号,微信ID" class="layui-input" style='max-width: 10rem;'>
				  </div>
			    </div>
			    <div class="layui-inline">
			    	<div class="layui-btn" id='searchFounder'>搜索</div>
			    </div>
			</div>
		</div>
		<!-- 发起人结束 -->
		<!-- 联合发起人开始 -->
		<div>
			<div class="layui-form-item">
			    <div class="layui-inline">
			      <label class="layui-form-label">联合发起人:</label>
			      <div class="layui-input-inline">
			        <select name="co_founder1" lay-filter='co_founder' id="co_founder" lay-search="">
			          <option value="">选择发起人</option>
			        </select>
			      </div>
			    </div>
			    <div class="layui-inline">
			      <label class="layui-form-label">搜索联合发起人:</label>
			      <div class="layui-input-block">
				      <input type="text" id='searchCoFounderInput' autocomplete="off" placeholder="昵称,ID,手机号,微信ID" class="layui-input" style='max-width: 10rem;'>
				  </div>
			    </div>
			    <div class="layui-inline">
			    	<div class="layui-btn" id='searchFounderForCo'>搜索</div>
			    </div>
			</div>
		</div>
		<!-- 发起人主动填写 -->
		<!-- <div>
			<div class="layui-form-item">
			    <div class="layui-inline">
			      <label class="layui-form-label">联合发起人:</label>
			      <div class="layui-input-block">
				      <input type="text" name="field8"  lay-verify="title" autocomplete="off" placeholder="请输入联合发起人" class="layui-input" style='max-width: 10rem;'>
				  </div>
			    </div>
			</div>
		</div> -->
		<!-- 发起人主动填写 -->
		<!-- 联合发起人结束 -->
		<!-- 添加活动嘉宾开始 -->
		<div class="layui-form-item">
		    <div class="layui-form-item" pane="">
			    <label class="layui-form-label"></label>
			    <div class="layui-input-block">
			      <input type="checkbox" <?php echo isset($data['detail']['field7'][0])?"checked='checked'":'';?> name="haveGuest" id='haveGuestCheck' lay-filter='haveGuest' lay-skin="primary" title="添加活动嘉宾">
			    </div>
			    <div id="haveGuest" style="<?php echo isset($data['detail']['field7'][0])?'':'display:none;';?>">
			    	<div class="layui-form-item">
					    <label class="layui-form-label">嘉宾昵称:</label>
					    <div class="layui-input-block">
					      <input type="text" name="field7[]" id='jname' autocomplete="off" placeholder="请输入嘉宾昵称"
					      value="<?php echo isset($data['detail']['field7'][0])?$data['detail']['field7'][0]:'';?>" class="layui-input" style='max-width: 10rem;'>
					    </div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">嘉宾头像:</label>
						 <div class="layui-form-item">
	                        <label class="layui-form-label"></label>
	                        <div class="layui-input-inline">
	                            <div class="layui-upload-list" style="margin:0;">
	                                <img src="<?php echo isset($data['detail']['field7'][1])?$data['detail']['field7'][1]:'';?>" id="headimgurl" width="100%" class="layui-upload-img">
	                            </div>
	                            <!-- 上传头像后需要给此隐藏输入框赋值----上传头像值 -->
	                            <input id='jheadimgurl' type="hidden" name="field7[]"  value="<?php echo isset($data['detail']['field7'][1])?$data['detail']['field7'][1]:'';?>">
	                            <br>
	                            <div class="layui-input-inline layui-btn-container">
		                            <div class="layui-btn layui-btn-primary uploadButton" data-width='150' data-height='150' data-type='jiabin' id="editimg">上传头像</div>
		                        </div>
	                        </div>
	                        <div class="layui-form-item layui-form-text">
							    <label class="layui-form-label">嘉宾介绍:</label>
							    <div class="layui-input-block">
							      <textarea id='jdesc' name="field7[]" placeholder="请输入内容" class="layui-textarea" name="desc"><?php echo isset($data['detail']['field7'][2])?trim($data['detail']['field7'][2]):'';?></textarea>
							    </div>
							</div>
	                        
	                    </div>
					</div>
			    </div>
			</div>
		</div>
		<!-- 添加活动嘉宾结束 -->
		<!-- 开始选择分类 -->
		<div>
			<div class="layui-form-item">
			    <div class="layui-inline">
			      <label class="layui-form-label">一级分类:</label>
			      <div class="layui-input-inline">
			        <select name="type_id" lay-verify="required" lay-filter='parentType' lay-search="">
			          <option value="">选择一级分类</option>
			          <?php if($data['typelist']){foreach($data['typelist'] as $row){?>
				          <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
				      <?php }}?>
			        </select>
			      </div>
			    </div>
			    <div class="layui-inline">
			      <label class="layui-form-label">二级分类:</label>
			      <div class="layui-input-inline">
			        <select name="tag_id" lay-verify="required" id='childType' lay-filter='childType' lay-search="">
			          <option value="">选择二级分类</option>
			          <?php if($data['tagName']){?>
				          <option value="<?php echo $data['tagName']['id'];?>"><?php echo $data['tagName']['name'];?></option>
				      <?php }?>
			        </select>
			      </div>
			    </div>
			</div>
		</div>
		<!-- 开始选择分类结束 -->
		
		<!-- 选择系列开始 -->
		<div>
			<div class="layui-form-item">
				<label class="layui-form-label">活动系列:</label>
				<div class="layui-input-block">
					<select name="sequence_id" id='sequence' lay-filter='sequence' lay-filter="aihao">
						<option value="0">选择活动系列</option>
					</select>
				</div>
			</div>
		</div>
		<!-- 选择系列结束 -->
		<!-- 活动标题开始 -->
		<div>			  
		  	<div class="layui-form-item">
			    <div class="layui-inline">
			      <label class="layui-form-label">标题:</label>
			      <div class="layui-input-inline">
			        <input type="text" name="title" lay-verify="required" class="layui-input">
			      </div>
			    </div>
			    <div class="layui-inline">
			      <label class="layui-form-label">副标题:</label>
			      <div class="layui-input-inline">
			        <input type="text" name="desc" lay-verify="required" class="layui-input">
			      </div>
			    </div>
			</div>
		</div>
		<!-- 活动标题结束 -->
		<!-- 文案开始 -->
		<div>
			<div class="layui-form-item">
			    <label class="layui-form-label">文案:</label>
			    <div class="layui-input-block">
			      <input type="text" name="content" placeholder="输入活动文案" autocomplete="off" lay-verify="required" class="layui-input">
			    </div>
			</div>
		</div>
		<!-- 文案结束 -->
		<!-- 报名人数开始 -->
		<div>
			<div class="layui-form-item">
			    <div class="layui-inline">
			      <label class="layui-form-label">报名名额:</label>
			      <div class="layui-input-inline">
			        <input type="number" name="peoples" value="0" lay-verify="required" class="layui-input">
			      </div>
			    </div>
			    <div class="layui-inline">
			      <label class="layui-form-label">理想人数:</label>
			      <div class="layui-input-inline">
			        <input type="number" name="ideal_number" value="0" lay-verify="required" class="layui-input">
			      </div>
			    </div>
			    <div class="layui-inline">
			      <label class="layui-form-label">人数上限:</label>
			      <div class="layui-input-inline">
			        <input type="number" name="ideal_number_limit" value="0" lay-verify="required" class="layui-input">
			      </div>
			    </div>
			</div>
		</div>
		<!-- 报名人数结束 -->
		<!-- 活动时间设置 -->
		<div>
			<div class="layui-inline">
		      <label class="layui-form-label">开始时间</label>
		      <div class="layui-input-inline">
		        <input type="text" lay-verify="required" class="layui-input" name='start_time' id="start_time" placeholder="yyyy-MM-dd HH:mm:ss">
		      </div>
		    </div>
		    <div class="layui-inline">
		      <label class="layui-form-label">结束时间</label>
		      <div class="layui-input-inline">
		        <input type="text" lay-verify="required" class="layui-input" name='end_time' id="end_time" placeholder="yyyy-MM-dd HH:mm:ss">
		      </div>
		    </div>
		</div>
		<!-- 活动时间设置结束 -->
		<!-- 活动场地开始 -->
		<div>
			<div class="haveAddress">
				<div class="layui-form-item">
				<label class="layui-form-label">选择场地</label>
				<div class="layui-input-block">
					<select name="space_spot_id" id='space_spot_id' lay-filter="address">
						<option value="">选择活动场地</option>
					</select>
				</div>
			</div>
			</div>
		</div>
		<!-- 活动场地结束 -->
		<!-- 收费金额 -->
		<div>
			<div class="layui-inline">
		      <label class="layui-form-label">活动费用:</label>
		      <div class="layui-input-inline">
		        <input type="number" name="cost" value="0" required class="layui-input">
		      </div>
		    </div>
		</div>
		<!-- 收费金额结束 -->
		<!-- 收费明细 -->
		<div>
			<div class="layui-form-item">
			    <label class="layui-form-label">收费明细:</label>
			    <div class="layui-input-block">
			      <input type="text" name="cost_list" placeholder="" autocomplete="off" class="layui-input">
			    </div>
			</div>
		</div>
		<!-- 收费明细结束 -->
		<!-- 活动详情开头 -->
		<div>
			<div class="layui-form-item">
				<label class="layui-form-label">开头详情:</label>
				<div class="layui-input-block">
					<br>
			    这是Someet活动发起人，发起的#       <input style="max-width: 15rem;" type="text" name="header_title" placeholder="" autocomplete="off" class="layui-input">        #活动
			    我期待遇见       <input style="max-width: 15rem;" type="text" name="header_people" placeholder="" autocomplete="off" class="layui-input">        的小伙伴！
			    </div>
			</div>
		</div>
		<!-- 活动性详情结束 -->
		<!-- 活动详情 -->
		<div>
			<label class="layui-form-label">活动详情:</label>
			<div class="layui-input-block">
				<textarea name="details" id="details" style="display: none;"><?php echo isset($data['detail']['details'])?$data['detail']['details']:'';?></textarea>
			</div>
		</div>
		<!-- 活动详情 -->
		<!-- 设置问题 -->
		<div class="layui-form-item">
		    <label class="layui-form-label">筛选问题</label>
		    <?php if($data['detail']['question']){?>
		    	<div class="layui-input-block" id='question'>
		    	<?php foreach ($data['detail']['question'] as $row) {?>
		    		
				      <input type="text" name="question[<?php echo $row['id'];?>]" autocomplete="off" placeholder="请输入活动流程" value="<?php echo $row['label'];?>" class="layui-input">
		    	<?php }?>
		    	</div>
		    <?php }else{?>
		    	<div class="layui-input-block" id='question'>
			      <input type="text" name="question[]" autocomplete="off" placeholder="请输入活动流程" class="layui-input">
			    </div>
		    <?php }?>
		    <br>
		    <div class="layui-inline">
		    	<label class="layui-form-label"> </label>
		    	<div  data-ele='question'  class="layui-btn addInput">增加筛选问题</div>
		    </div>
		</div>
		<!-- 设置问题 -->
		<!-- 活动流程 -->
		<div class="layui-form-item">
		    <label class="layui-form-label">活动流程</label>
		    <!-- <div class="layui-input-block" id='review'>
		      <input type="text" name="review[]" autocomplete="off" placeholder="请输入活动流程" class="layui-input">
		    </div> -->
		    <?php if($data['detail']['review']){?>
		    	<div class="layui-input-block" id='review'>
		    	<?php foreach ($data['detail']['review'] as $row) {?>
				      <input type="text" name="review[]" autocomplete="off" placeholder="请输入活动流程" value="<?php echo $row;?>" class="layui-input">
		    	<?php }?>
		    	</div>
		    <?php }else{?>
		    	<div class="layui-input-block" id='review'>
			      <input type="text" name="review[]" autocomplete="off" placeholder="请输入活动流程" class="layui-input">
			    </div>
		    <?php }?>
		    <br>
		    <div class="layui-inline">
		    	<label class="layui-form-label"> </label>
		    	<div  data-ele='review'  class="layui-btn addInput">增加活动流程</div>
		    </div>
		</div>
		<!-- 活动流程 -->
		<!-- 注意事项 -->
		<div class="layui-form-item">
		    <label class="layui-form-label">注意事项</label>
		    <!-- <div class="layui-input-block" id='field6'>
		      <input type="text" name="field6[]" autocomplete="off" placeholder="请输入注意事项" class="layui-input">
		    </div> -->
		    <?php if($data['detail']['field6']){?>
		    	<div class="layui-input-block" id='field6'>
		    	<?php foreach ($data['detail']['field6'] as $row) {?>
				      <input type="text" name="field6[]" autocomplete="off" placeholder="请输入注意事项" value="<?php echo $row;?>" class="layui-input">
		    	<?php }?>
		    	</div>
		    <?php }else{?>
		    	<div class="layui-input-block" id='review'>
			      <input type="text" name="field6[]" autocomplete="off" placeholder="请输入活动流程" class="layui-input">
			    </div>
		    <?php }?>
		    <br>
		    <div class="layui-inline">
		    	<label class="layui-form-label"> </label>
		    	<div data-ele='field6' class="layui-btn addInput">增加注意事项</div>
		    </div>
		</div>
		<!-- 注意事项 -->
		<!-- Tips -->
		<div class="layui-form-item">
		    <label class="layui-form-label">Tips</label>
<!-- 		    <div class="layui-input-block" id='field2'>
		      <input type="text" name="field2[]" autocomplete="off" placeholder="请输入活动提示" class="layui-input">
		    </div> -->
		    <?php if($data['detail']['field2']){?>
		    	<div class="layui-input-block" id='field2'>
		    	<?php foreach ($data['detail']['field2'] as $row) {?>
		    		
				      <input type="text" name="field2[]" autocomplete="off" placeholder="请输入注意事项" value="<?php echo $row;?>" class="layui-input">
		    	<?php }?>
		    	</div>
		    <?php }else{?>
		    	<div class="layui-input-block" id='review'>
			      <input type="text" name="field2[]" autocomplete="off" placeholder="请输入活动流程" class="layui-input">
			    </div>
		    <?php }?>
		    <br>
		    <div class="layui-inline">
		    	<label class="layui-form-label"> </label>
		    	<div  data-ele='field2' class="layui-btn addInput">增加活动Tips</div>
		    </div>
		</div>
		<!-- tips -->
		<br>
		<br>
		<div>
			<div class="layui-form-item">
				<label class="layui-form-label"> </label>
				<div class="layui-inline">
					<button lay-filter='activityForm' lay-submit class="layui-btn-warm layui-btn-lg" >提交审核</button>
				</div>
			</div>
		</div>
	</form>
</div>
<script type="text/javascript" src='/layui/js/modules/cropper.js'></script>
<script type="text/javascript">
var form = layui.form; 
var layedit = layui.layedit;
var editIndex = layedit.build('details',{
	height:600,
	tool: ['strong','left', 'center', 'right','image'],
	uploadImage:{url: '/back/upload/upload-image?type=text', type: 'post'}
}); //建立编辑器
var dateHtml=layui.laydate;
//日期时间选择器
dateHtml.render({
	elem: '#start_time'
	,type: 'datetime'
});
dateHtml.render({
	elem: '#end_time'
	,type: 'datetime'
});
var $ = layui.$
//活动的ID用于编辑活动 
var id = $('#aid').val();
var token = $('#access_token').val();
$.ajaxSettings.beforeSend = function(xhr,request){
    xhr.setRequestHeader('Authorization','Bearer '+token);
}
var _csrf = $('#_csrf').val();
//设置一个控制提交的变量
var isSub = 0;
//图片上传
layui.config({
    base: '/layui/js/' //layui自定义layui组件目录
}).use(['form','croppers'], function () {
    var $ = layui.jquery
        ,form = layui.form
        ,croppers = layui.croppers
        ,layer= layui.layer;
    //创建一个头像上传组件
    croppers.render({
         elem: '.uploadButton'
       
        ,area:'900px'  //弹窗宽度
        ,url: "/back/upload/upload-image"  //图片上传接口返回和（layui 的upload 模块）返回的JOSN一样
        ,done: function(url,type){ //上传完毕回调
        	if(type=='jiabin'){
        		$('#jheadimgurl').val(url)
            	$("#headimgurl").attr('src',url);
        	}else if(type == 'poster'){
        		$("#poster").val(url);
        		$('#posterUpload').children('img').attr('src',url)
        	}else if(type == 'group_code'){
        		$('#group_code').val(url);
        	}
        	layer.closeAll();
            
        },
        extEle:''
    });
});
form.render();
//是否有活动嘉宾
form.on('checkbox(haveGuest)', function(data){
  if(data.elem.checked){
  	 $('#haveGuest').slideDown();
  }else{
  	$('#haveGuest').slideUp();
  }
});        

//分类选择框
form.on('select(parentType)', function(data){
  var pid = data.value;
  var data ={
  	data:{
  		id:pid
  	},
  	obj:'#childType',
  	type:'get',
  	url:'/back/activity/get-tag',
  	act:'typeAndTag'
  }
  httpRequest(data);
});
//监听发起人选择
form.on('select(founder)', function(data){
	var id = data.value;
	console.log(id)
	//请求该发起人的系列活动
	var data ={
		data:{
			user_id:id
	  	},
	  	obj:'#sequence',
	  	type:'get',
	  	url:'/back/activity/get-sequence',
  		act:'sequence'
	}
	httpRequest(data);  
});
//监听搜索发起人信息
$('#searchFounder').click(function(){
	var val = $('#searchFounderInput').val();
	var data ={
		  	data:{
		  		type:'founder',
				val:val
		  	},
		  	obj:'#founder',
		  	type:'get',
		  	url:'/back/member/get-user-search',
		  	act:'founder'
		  }
	httpRequest(data);  
})
//搜索联合发起人
$('#searchFounderForCo').click(function(){
	var val = $('#searchCoFounderInput').val();
	var data ={
		  	data:{
		  		type:'co_founder',
				val:val
		  	},
		  	obj:'#co_founder',
		  	type:'get',
		  	url:'/back/member/get-user-search',
		  	act:'founder'
		  }
	httpRequest(data);  
})
//监听提交
form.on('submit(activityForm)', function(data){
	data.field.details = layedit.getContent(editIndex);
	// console.log(data.field.details)
	// return false;
	if(isSub == 0){
		isSub = 1;
		if($('#haveGuestCheck').val()){
			var jname = $('#jname').val()
			var jheadimgurl = $('#jheadimgurl').val();
			var jdesc = $('#jdesc').val()
			if(!jname || !jheadimgurl || !jdesc){
				isSub = 0;
				layer.msg('选择了嘉宾就得填信息啊');
				return false;
			}
		}
		$.ajax({
			url:'/back/activity/create-act',
			type:'post',
			data:data.field,
			success:function(res){
				console.log(res)
				isSub = 0;
				if(res.data.status == 1){
					layer.msg('操作成功');
					window.location.href = '/activity/index'
				}else{
					layer.msg('操作失败');
				}
				
			},
			error:function(){
				isSub = 0;
				console.log('error')
			}
		})
	}
	
	return false;
});
//监听增加注意事项的事件
$('.addInput').click(function(){
	var ele = $(this).data('ele');
	var index = $('#'+ele).children('input').length;
	var str = '<input type="text" name="'+ele+'['+index+']" autocomplete="off" class="layui-input" placeholder="请输入文本内容">';
	$('#'+ele).append(str)
})
function httpRequest(data){
	$.ajax({
		url:data.url,
		type:data.type,
		data:data.data,
		success:function(res){
			// if(data.act == 'sequence'){
			// 	var str ='<option value="0">未找到系列</option>';
			// }else{
			// 	var str ='<option value="0">选择确认的选项</option>';
			// }
			var str = '';
			$(data.obj).html(str)
			str = '';
			$.each(res.data,function(index,val){
				if(data.act == 'typeAndTag'){
					str+='<option value="'+val.id+'">'+val.name+'</option>'
				}else if(data.act == 'sequence'){
					str+='<option value="0">选择活动系列</option><option value="'+val.sequence_id+'">'+val.title+'</option>'
				}else if(data.act == 'founder'){

					if(index == 0){
						str+='<option selected="selected" value="'+val.id+'">'+val.username+'</option>'
						
					}else{
						str+='<option value="'+val.id+'">'+val.username+'</option>'
					}
					getFounderSpaceAndXl(val.id)
					
				}else if(data.act == 'space'){
					str+='<option value="0">选择活动场地</option><option value="'+val.id+'">'+val.name+'</option>'
				}else if(data.act == 'co_founder'){
					if(index == 0){
						str+='<option selected="selected" value="'+val.id+'">'+val.username+'</option>'
					}else{
						str+='<option value="'+val.id+'">'+val.username+'</option>'
					}
				}
				
			})
			
			$(data.obj).append(str)
			form.render('select');
			// form.render();
		},
		error:function(){
			layer.msg('抱歉，出错了', {icon: 2}); 
		}
	})
} 
//获取一选区的发起人场地和系列
function getFounderSpaceAndXl(id){
	var dataForXl ={
			data:{
				user_id:id
		  	},
		  	obj:'#sequence',
		  	type:'get',
		  	url:'/back/activity/get-sequence',
			act:'sequence'
	}
	var dataForSpace ={
			data:{
				user_id:id,
				type:'founder'
		  	},
		  	obj:'#space_spot_id',
		  	type:'get',
		  	url:'/back/space/get-space-list',
			act:'space'
	}
	//获取该发起人的系列名称
	httpRequest(dataForXl);
	//获取发起人的场地名称
	httpRequest(dataForSpace);
}
//预设赋值‘
if(id>0){
	$("select[name='updated_by']").val("<?php echo $data['detail']['updated_by'];?>")
	$("select[name='address']").val("<?php echo $data['detail']['space_spot_id'];?>")
	$("select[name='created_by']").append('<option selected="selected" value="'+"<?php echo $data['detail']['created_by'];?>"+'">'+"<?php echo $data['detail']['username'];?>"+'</option>');
	getFounderSpaceAndXl("<?php echo $data['detail']['created_by'];?>")
	$("select[name='co_founder1']").append('<option selected="selected" value="'+"<?php echo $data['detail']['co_founder1'];?>"+'">'+"<?php echo $data['detail']['co_username'];?>"+'</option>');
	$("select[name='type_id']").val("<?php echo $data['detail']['type_id'];?>")
	$("select[name='tag_id']").val("<?php echo $data['detail']['tag_id'];?>")
	$("select[name='space_spot_id']").append('<option selected="selected" value="'+"<?php echo $data['detail']['space_spot_id'];?>"+'">'+"<?php echo $data['detail']['spacename'];?>"+'</option>');
	//默认分类
	$("select[name='created_by']").val("<?php echo $data['detail']['created_by'];?>")
	form.val("activity", {
		'title':"<?php echo $data['detail']['title'];?>",
		'poster':"<?php echo $data['detail']['poster'];?>",
		'desc':"<?php echo $data['detail']['desc'];?>",
		'content':"<?php echo $data['detail']['content'];?>",
		'peoples':"<?php echo $data['detail']['peoples'];?>",
		'ideal_number':"<?php echo $data['detail']['ideal_number'];?>",
		'ideal_number_limit':"<?php echo $data['detail']['ideal_number_limit'];?>",
		'start_time':"<?php echo date('Y-m-d H:i:s',$data['detail']['start_time']);?>",
		'end_time':"<?php echo date('Y-m-d H:i:s',$data['detail']['end_time']);?>",
		'cost_list':"<?php echo $data['detail']['cost_list'];?>",
		'cost':"<?php echo $data['detail']['cost'];?>",
		'header_title':"<?php echo $data['detail']['header_title'];?>",
		'header_people':"<?php echo $data['detail']['header_people'];?>",
		'co_founder1':'<?php echo $data['detail']['co_founder1'];?>'
	})
	form.render();
}    
</script>