<div class="space-div">
	<fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
		<legend>场地详情</legend>
	</fieldset>

	<fieldset class="layui-elem-field">
		<legend style="color:red;">北京市朝阳区14号线东段望京南(地铁站)</legend>
		<div class="layui-field-box">
			<form id='spaceForm' lay-filter='spaceForm' class="layui-form" action="/">
				<div id='space-info'>
					<div class="layui-form-item">
					    <label class="layui-form-label">场地名称</label>
					    <div class="layui-input-block">
					      <input type="text" name="name" id='name' autocomplete="off" placeholder="请输入名称" class="layui-input">
					    </div>
					</div>
					<div class="layui-form-item">
					    <label class="layui-form-label">场地信息</label>
					    <div class="layui-input-block">
					      <input type="text" id='address' name="address" autocomplete="off" placeholder="请输入信息" class="layui-input">
					    </div>
					</div>
					<div class="layui-form-item">
					    <label class="layui-form-label">商圈</label>
					    <div class="layui-input-block">
					      <input type="text" name="area" id='area' autocomplete="off" placeholder="不填则自动填充" class="layui-input">
					    </div>
					</div>
					<div class="layui-form-item">
					    <label class="layui-form-label">城区</label>
					    <div class="layui-input-block">
					      <input type="text" id='district' name="district"  autocomplete="off" placeholder="不填则自动填充" class="layui-input">
					    </div>
					</div>
					<div class="layui-form-item">
					    <label class="layui-form-label">场地详情</label>
					    <div class="layui-input-block">
					      <input type="text" id='detail' name="detail" autocomplete="off" placeholder="请输入信息" class="layui-input">
					    </div>
					</div>
					<input type="hidden" id='user_id' value="<?php echo $user_id;?>" name="">
					<input type="hidden" id='space_id' value="<?php echo $id;?>" name="id">
					<input type="hidden" value=""  name="longitude" id="longitude">
					<input type="hidden" value=""  name="latitude" id="latitude">
				</div>
				<div class="layui-form-item">
					<div class="space-map" id='space-map'>
						<textarea style="font-size:0.7rem;position: absolute;z-index: 101;width: 14rem;resize: none;left:1rem;top:2rem;height: 2rem;line-height: 2rem;    margin: 0 auto;" placeholder="  输入地址搜索"  id="tipinput"></textarea>
					</div>
				</div>
				
			</form>
		</div>
	</fieldset>
</div>
<script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=00033c85024ea0a8caf745e5d01915f8&plugin=AMap.Autocomplete,AMap.Geocoder"></script>
<script type="text/javascript">
	var $ = layui.jquery
	var id = "<?php echo $id;?>";
	console.log(id)
	var user_id = $('#user_id').val();
	var form = layui.form
	//加载地图
	var map = new AMap.Map("space-map", {
       resizeEnable: true,
       zoom:13
   	});
   	var isSub = 0;
	$(function(){
		//获取单个场地详情
		if(id >0){
			$.ajax({
				url:'/back/space/get-info?id='+id,
				type:'post',
				success:function(res){
					if(res.data.id){
						if(res.data.user_id != user_id){
							layer.msg('请修改自己的场地信息')
						}else{
							var str='<div class="layui-form-item" id="subSpace"><button class="layui-btn" lay-submit lay-filter="subSpace">立即提交</button></div>';
							$('#spaceForm').append(str);
							var obj = {
		                    	newarea:res.data.area,
		                    	name:res.data.name,
		                    	detail:res.data.detail,
		                    	address:res.data.address,
		                    	district:res.data.district,
		                    	longitude:res.data.longitude,
		                    	latitude:res.data.latitude
		                    }
		                    addMarker(18,res.data.longitude,res.data.latitude)
		                    setVal(obj)
							$('#space-info').slideDown(1500);
							form.render();
						}
					}
				},
				error:function(){
					layer.msg('error')
				}
			})
		}else{
			var str='<div class="layui-form-item" id="subSpace"><button class="layui-btn" lay-submit lay-filter="subSpace">立即提交</button></div>';
				$('#spaceForm').append(str);
				form.render();
		}
		form.on('submit(subSpace)',function(data){
			console.log(data.field)
			if(!data.field.name){
				layer.msg('请正确填写信息')
				return false;
			}
			if(!data.field.address){
				layer.msg('请正确填写信息')
				return false;
			}
			if(!data.field.area){
				layer.msg('请正确填写信息')
				return false;
			}
			if(!data.field.detail){
				layer.msg('请正确填写信息')
				return false;
			}
			if(!data.field.longitude){
				layer.msg('未获取到经纬度')
				return false;
			}
			if(!data.field.latitude){
				layer.msg('未获取到经纬度')
				return false;
			}
			if(isSub == 0){
				isSub = 1;
				var type = id >0?'put':'post';
				$.ajax({
					url:'/back/space/add',
					type:type,
					data:data.field,
					success:function(res){
						isSub = 0;
						if(res.data.status == 1){
							layer.msg('操作成功')
							window.location.href = '/space/index'
						}else{
							layer.msg('操作失败')
						}
						
					},
					error:function(){
						isSub = 0;
						layer.msg('error')
					}
				})
			}else{
				layer.msg('不要频繁提交')
			}
			
			return false;
		})
        var markers=[],marker,geolocation;
        var geocoder = new AMap.Geocoder({
	        radius: 1000,
	        extensions: "all"
	    });
	    //为地图注册click事件获取鼠标点击出的经纬度坐标
        map.on('click', function(e) {
            lnglatXY = [e.lnglat.getLng(), e.lnglat.getLat()]; //已知点坐标
            if(marker){
                marker.setMap(null);
            }
            addMarker(18,e.lnglat.getLng(),e.lnglat.getLat());
            geocoder.getAddress(lnglatXY, function(status, result) {

                if (status === 'complete' && result.info === 'OK') {
                	console.log(result)
                    var newarea =result.regeocode.addressComponent.businessAreas[0].name
                    var address = ''
                    var district = result.regeocode.addressComponent.district
                    var detail = result.regeocode.formattedAddress
                    var obj = {
                    	name:'',
                    	detail:detail,
                    	newarea:newarea,
                    	address:address,
                    	district:district,
                    	longitude:e.lnglat.getLng(),
                    	latitude:e.lnglat.getLat()
                    }
                    setVal(obj)
                	$('#space-info').slideDown(1500);
                }

            });
        });
        var auto = new AMap.Autocomplete({
           input: "tipinput"
       	});
       	AMap.event.addListener(auto, "select", select);//注册监听，当选中某条记录时会触发
       	function select(e) {
         if(marker){
                marker.setMap(null);
            }
           if (e.poi && e.poi.location) {
            var t_ad = e.poi.district+e.poi.address+e.poi.name
                geocoder.getAddress([e.poi.location.lng, e.poi.location.lat], function(status, result) {

                if (status === 'complete' && result.info === 'OK') {
                    var newarea =result.regeocode.addressComponent.businessAreas[0].name
                    var address = ''
                    var district = result.regeocode.addressComponent.district
                    var detail = t_ad
                    var obj = {
                    	name:'',
                    	detail:detail,
                    	newarea:newarea,
                    	address:address,
                    	district:district,
                    	longitude:e.poi.location.lng,
                    	latitude:e.poi.location.lat
                    }
                    setVal(obj)
                }

            });
               addMarker(18,e.poi.location.lng, e.poi.location.lat);
           }
       }
        function addMarker(zm,lng,lat){
	        if(!zm) zm = 14;
	        marker = new AMap.Marker({
	           draggable: true,
	           cursor: 'move',
	           raiseOnDrag: true,
	           icon: "http://webapi.amap.com/theme/v1.3/markers/n/mark_b.png",
	           position: [lng, lat]
	          });
	          map.remove(marker);
	          marker.setMap(null)
	          markers.push(marker)
	          map.setZoomAndCenter(zm, [lng, lat]);
	          AMap.event.addListener(marker,'dragend',onDragend);
	          marker.setMap(map);
	          var lnglatXY = [lng, lat]; //已知点坐标
	          var geocoder = new AMap.Geocoder({
	              radius: 1000,
	              extensions: "all"
	      });
        }
        function onDragend(data){
            var t=document.getElementById('tipinput');
            map.setZoomAndCenter(18, [data.lnglat.lng, data.lnglat.lat]);
            if(!t.value){
                if(!isedit){
                    geocoder(data.lnglat.lng, data.lnglat.lat,true)
                }
            }
        }

        function recordMyposition(){
            addMarker(18,lng,lat);
        }
        function setVal(obj){
        	if(!$("#area").val()) $("#area").val(obj.newarea); 
        	if(!$("#name").val()) $("#name").val(obj.name); 
        	if(!$("#address").val()) $("#address").val(obj.address); 
        	if(!$("#detail").val()) $("#detail").val(obj.detail); 
        	if(!$("#district").val()) $('#district').val(obj.district)
        	$('#longitude').val(obj.longitude)
        	$('#latitude').val(obj.latitude)
        }
	})
</script>