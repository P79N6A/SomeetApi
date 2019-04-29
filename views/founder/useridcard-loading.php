<div class="view-detail">
	<fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
	  <legend>审核状态（<b style='color:red;'><?php echo $data['idcard_info']['status'] == 2?'未通过':'正在审核请稍后';?></b>）</legend>
	</fieldset>
	<ul class="layui-timeline">
		<li class="layui-timeline-item">
			<i class="layui-icon layui-timeline-axis"></i>
			<div class="layui-timeline-content layui-text">
				<h3 class="layui-timeline-title">真实姓名</h3>
				<div style="margin-left: 1.5rem;">
			      <input disabled="disabled" type="text" name="real_name"  autocomplete="off" placeholder="请输入真实姓名" value="<?php echo $data['idcard_info']['realname'];?>" class="layui-input">
			    </div>
			</div>
		</li>
		<li class="layui-timeline-item">
			<i class="layui-icon layui-timeline-axis"></i>
			<div class="layui-timeline-content layui-text">
				<h3 class="layui-timeline-title">身份证号码</h3>
				<div style="margin-left: 1.5rem;">
			      <input disabled="disabled" type="text" name="idcard" autocomplete="off" placeholder="请输入身份证号码" value="<?php echo $data['idcard_info']['idcard'];?>" class="layui-input">
			    </div>
			</div>
		</li>
		<li class="layui-timeline-item">
			<i class="layui-icon layui-timeline-axis"></i>
			<div class="layui-timeline-content layui-text">
				<h3 class="layui-timeline-title">上传身份证正反面照</h3>
				<div class="useridcard-upload">
					<div>
						<img class="startUpload" src="<?php echo $data['idcard_info']['idcards_A'];?>" width="100%">
					</div>
					<div>
						<img class="startUpload" src="<?php echo $data['idcard_info']['idcards_B'];?>" width="100%">
					</div>
				</div>
			</div>
		</li>
	</ul>
</div>
<script>
var element = layui.element;
</script>
