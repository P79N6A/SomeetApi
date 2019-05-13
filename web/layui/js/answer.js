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
					html+='<div class="layui-col-md6">\
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
						      	<div class="layui-btn layui-btn-primary">通过</div>\
						      	<div class="layui-btn layui-btn-danger">拒绝</div>\
						      	<div class="layui-collapse answer-more-box-div">\
						      		<div class="layui-colla-item">\
									    <h2 class="layui-colla-title answer-more-box">更多功能</h2>\
									    <div class="layui-colla-content">\
									    	<div class="layui-form-item">\
											    <label class="layui-form-label">请假状态</label>\
											    <div class="layui-input-block">\
											      	<div class="layui-btn layui-btn-primary">取消</div>\
						      						<div class="layui-btn layui-btn-danger">正常</div>\
											    </div>\
											</div>\
									    	<div class="layui-form-item">\
											    <label class="layui-form-label">到场状态</label>\
											    <div class="layui-input-block">\
											      	<div class="layui-btn layui-btn-primary">准时</div>\
						      						<div class="layui-btn layui-btn-danger">迟到</div>\
											    </div>\
											</div>\
									    </div>\
									  </div>\
						      	</div>\
						      <!-- 	<div class="layui-btn layui-btn-primary">\
						      		已通过\
						      	</div> -->\
						    </div>\
						  </div>\
						</div>';
				}
				console.log(html)
				$('#answer-box-top').append(html);
				element.init();
				$('.watch-question').click(function(){
					$(this).parent().next('.layui-card-body').toggle(500);
				})
			}
		}
		exports('answer', obj);
	}

);