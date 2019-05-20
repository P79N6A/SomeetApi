layui.config({
    base: '/layui/js/modules/' //layui自定义layui组件目录
}).define(
	['answer'],function(exports){
		var $ = layui.$
		var element = layui.element
		var layer = layui.layer
		var html = '';
		var obj = {
			render:function(e){
				var data = e.data.data
				for (var i = 0; i < data.length; i++) {
					var question = '';
					// console.log(data[i].questionItem.length)
					for (var k = 0; k < data[i].questionItem.length; k++) {
						question+='<p>\
				          	Q:'+data[i].questionItem[k].question_label+'<br>\
				          <main class="answer-box-main">A:'+data[i].questionItem[k].question_value+'</main>\
				          </p>\
				          <hr class="layui-bg-red">';
					}
					html+='<div class="layui-col-md6 answerCard">\
							<input type="hidden" value="'+data[i].id+'" class="answer_id">\
						  <div class="layui-card answer-box">\
						    <div class="layui-card-header answer-box-flex" style="height: 52px;">\
						    	<div class="answer-box-head">\
						    		<img src="'+data[i].profile.headimgurl+'">\
						    	</div>\
						    	<div class="answer-box-right">\
						    		<span>'+data[i].user.username+'</span>\
						    		<span>'+data[i].user.mobile+'</span>\
						    		<span>'+data[i].user.wechat_id+'</span>\
						    	</div>\
						    </div>\
						    <div class="answer-button-box">\
						    	<div class="layui-btn layui-btn-primary watch-question">查看问题</div>\
						    </div>\
						    <div class="layui-card-body">'+question+'\
						    </div>\
						    <div class="answer-box-buttom">\
						      	<div class="layui-btn button-pass '+(data[i].status == 20?"layui-btn-danger":"layui-btn-primary")+'">通过</div>\
						      	<div class="layui-btn  '+(data[i].status == 30?"layui-btn-danger":"layui-btn-primary")+' button-reject">拒绝</div>\
						      	<div class="layui-collapse answer-more-box-div">\
						      		<div class="layui-colla-item">\
									    <h2 class="layui-colla-title answer-more-box">更多功能</h2>\
									    <div class="layui-colla-content">\
									    	<div class="layui-form-item">\
											    <label class="layui-form-label answer-arrive-label">请假状态</label>\
											    <div class="layui-input-block">\
											      	<div class="layui-btn '+(data[i].leave_status == 1?"layui-btn-danger":"layui-btn-primary")+' button-cancel">请假</div>\
						      						<div class="layui-btn '+(data[i].leave_status == 0?"layui-btn-danger":"layui-btn-primary")+' button-normal">正常</div>\
											    </div>\
											</div>\
									    	<div class="layui-form-item">\
											    <label class="layui-form-label answer-arrive-label">到场状态</label>\
											    <div class="layui-input-block answer-arrive-box">\
											      	<div class="layui-btn '+(data[i].arrive_status == 2?"layui-btn-danger":"layui-btn-primary")+' button-order">准时</div>\
						      						<div class="layui-btn '+(data[i].arrive_status == 1?"layui-btn-danger":"layui-btn-primary")+' button-later">迟到</div>\
						      						<div class="layui-btn '+(data[i].arrive_status == 0?"layui-btn-danger":"layui-btn-primary")+' button-away">爽约</div>\
											    </div>\
											</div>\
									    </div>\
									  </div>\
						      	</div>\
						    </div>\
						  </div>\
						</div>';
				}
				$('#answer-box-top').append(html);
				element.init();
				$('.watch-question').click(function(){
					$(this).parent().next('.layui-card-body').toggle(500);
				})
				//通过操作
				$('.button-pass').click(function(){
					if($(this).hasClass('layui-btn-danger')){
						layer.msg('已经是请假状态了，或者刷新重新查看')
						return false
					}
					var that = $(this);
					var id = $(this).parents('.answerCard').children('.answer_id').val();
					layer.confirm('确认通过?', {icon: 3, title:'提示'}, function(index){
					  	if(!that.hasClass('layui-btn-danger')){
							that.removeClass('layui-btn-primary').addClass('layui-btn-danger')
							that.siblings().hasClass('layui-btn-danger')?that.siblings().removeClass('layui-btn-danger').addClass('layui-btn-primary'):'';
						}else{
							layer.msg('已经是通过状态了，或者刷新重新查看')
							return false;
						}
					  updateStatus('passType','pass',id);
					  layer.close(index);
					});
				})
				//拒绝操作
				$('.button-reject').click(function(){
					if($(this).hasClass('layui-btn-danger')){
						layer.msg('已经是请假状态了，或者刷新重新查看')
						return false
					}
					var that = $(this);
					var id = $(this).parents('.answerCard').children('.answer_id').val();
					layer.prompt({
						  formType: 2,
						  value: '',
						  title: '请输入拒绝理由',
						  area: ['400px', '250px'] //自定义文本域宽高
						}, function(value, index, elem){
							if(!that.hasClass('layui-btn-danger')){
								that.removeClass('layui-btn-primary').addClass('layui-btn-danger')
								that.siblings().hasClass('layui-btn-danger')?that.siblings().removeClass('layui-btn-danger').addClass('layui-btn-primary'):'';
							}else{
								layer.msg('已经是拒绝状态了，或者刷新重新查看')
								return false;
							}
						  	updateStatus('rejectType','reject',id,value);
						  	layer.close(index);
					});
				})
				//请假
				$('.button-cancel').click(function(){
					if($(this).hasClass('layui-btn-danger')){
						layer.msg('已经是请假状态了，或者刷新重新查看')
						return false
					}
					var that = $(this);
					var id = $(this).parents('.answerCard').children('.answer_id').val();
					layer.confirm('确认请假?', {icon: 3, title:'提示'}, function(index){
					  	if(!that.hasClass('layui-btn-danger')){
							that.removeClass('layui-btn-primary').addClass('layui-btn-danger')
							that.siblings().hasClass('layui-btn-danger')?that.siblings().removeClass('layui-btn-danger').addClass('layui-btn-primary'):'';
						}else{
							layer.msg('已经是请假状态了，或者刷新重新查看')
							return false;
						}
					  updateStatus('cancelType','cancel',id);
					  layer.close(index);
					});
				})
				//修改请假状态
				$('.button-normal').click(function(){
					if($(this).hasClass('layui-btn-danger')){
						layer.msg('已经是请假状态了，或者刷新重新查看')
						return false
					}
					var that = $(this);
					var id = $(this).parents('.answerCard').children('.answer_id').val();
					layer.confirm('确认修改?', {icon: 3, title:'提示'}, function(index){
					  	if(!that.hasClass('layui-btn-danger')){
							that.removeClass('layui-btn-primary').addClass('layui-btn-danger')
							that.siblings().hasClass('layui-btn-danger')?that.siblings().removeClass('layui-btn-danger').addClass('layui-btn-primary'):'';
						}else{
							layer.msg('已经是正常状态了，或者刷新重新查看')
							return false;
						}
					  updateStatus('normalType','normal',id);
					  layer.close(index);
					});
				})
				//准时
				$('.button-order').click(function(){
					if($(this).hasClass('layui-btn-danger')){
						layer.msg('已经是请假状态了，或者刷新重新查看')
						return false
					}
					var that = $(this);
					var id = $(this).parents('.answerCard').children('.answer_id').val();
					layer.confirm('确认准时?', {icon: 3, title:'提示'}, function(index){
					  	if(!that.hasClass('layui-btn-danger')){
							that.removeClass('layui-btn-primary').addClass('layui-btn-danger')
							that.siblings().hasClass('layui-btn-danger')?that.siblings().removeClass('layui-btn-danger').addClass('layui-btn-primary'):'';
						}else{
							layer.msg('已经是正常状态了，或者刷新重新查看')
							return false;
						}
					  updateStatus('orderType','order',id);
					  layer.close(index);
					});
				})
				//吃到
				$('.button-later').click(function(){
					if($(this).hasClass('layui-btn-danger')){
						layer.msg('已经是请假状态了，或者刷新重新查看')
						return false
					}
					var that = $(this);
					var id = $(this).parents('.answerCard').children('.answer_id').val();
					layer.confirm('确认迟到?', {icon: 3, title:'提示'}, function(index){
					  	if(!that.hasClass('layui-btn-danger')){
							that.removeClass('layui-btn-primary').addClass('layui-btn-danger')
							that.siblings().hasClass('layui-btn-danger')?that.siblings().removeClass('layui-btn-danger').addClass('layui-btn-primary'):'';
						}else{
							layer.msg('已经是正常状态了，或者刷新重新查看')
							return false;
						}
					  updateStatus('laterType','later',id);
					  layer.close(index);
					});
				})
				//爽约
				$('.button-away').click(function(){
					if($(this).hasClass('layui-btn-danger')){
						layer.msg('已经是请假状态了，或者刷新重新查看')
						return false
					}
					var that = $(this);
					var id = $(this).parents('.answerCard').children('.answer_id').val();
					layer.confirm('确认爽约?', {icon: 3, title:'提示'}, function(index){
					  	if(!that.hasClass('layui-btn-danger')){
							that.removeClass('layui-btn-primary').addClass('layui-btn-danger')
							that.siblings().hasClass('layui-btn-danger')?that.siblings().removeClass('layui-btn-danger').addClass('layui-btn-primary'):'';
						}else{
							layer.msg('已经是正常状态了，或者刷新重新查看')
							return false;
						}
					  updateStatus('awayType','away',id);
					  layer.close(index);
					});
				})
				function updateStatus(type,status,id,reject){
					reject = reject ||false
					var token = $('#access_token').val();
					$.ajaxSettings.beforeSend = function(xhr,request){
					    xhr.setRequestHeader('Authorization','Bearer '+token);
					}
					$.ajax({
						url:'/back/activity/update-answer',
						type:'put',
						data:{
							type:type,
							status:status,
							id:id,
							reject:reject
						},
						success:function(res){
							console.log(res)
						},
						error:function(){
							layer.msg('操作错误')
						}
					})
				}
			}
		}
		exports('answer', obj);
	}

);