/*!
 * Cropper v3.0.0
 */

layui.config({
    base: '/layui/js/modules/' //layui自定义layui组件目录
}).define(['jquery','layer','cropper'],function (exports) {
    var $ = layui.jquery
        ,layer = layui.layer;
    var html = "<div class=\"layui-fluid showImgEdit\" style=\"display: none\">\n" +
        "    <div class=\"layui-form-item\">\n" +
        "        <div class=\"layui-input-inline layui-btn-container\" style=\"width: auto;\">\n" +
        "            <label for=\"cropper_avatarImgUpload\" class=\"layui-btn layui-btn-primary\">\n" +
        "                <i class=\"layui-icon\">&#xe67c;</i>选择图片\n" +
        "            </label>\n" +
        "            <input class=\"layui-upload-file\" id=\"cropper_avatarImgUpload\" type=\"file\" value=\"选择图片\" name=\"file\">\n" +
        "        </div>\n" +
        "        <div class=\"layui-form-mid layui-word-aux\">图片的大小在100kb以内</div>\n" +
        "    </div>\n" +
        "    <div class=\"layui-row layui-col-space15\">\n" +
        "        <div class=\"layui-col-xs9\">\n" +
        "            <div class=\"readyimg\" style=\"height:450px;background-color: rgb(247, 247, 247);\">\n" +
        "                <img src=\"\" >\n" +
        "            </div>\n" +
        "        </div>\n" +
        "        <div class=\"layui-col-xs3\">\n" +
        "            <div class=\"img-preview\" style=\"width:200px;height:200px;overflow:hidden\">\n" +
        "            </div>\n" +
        "        </div>\n" +
        "    </div>\n" +
        "    <div class=\"layui-row layui-col-space15\" style=\"margin:0px;\">\n" +
        "        <div class=\"layui-col-xs9\">\n" +
        "            <div class=\"layui-row\">\n" +
        "                <div class=\"layui-col-xs6\">\n" +
        "                    <button type=\"button\" class=\"layui-btn layui-icon layui-icon-left\" cropper-event=\"rotate\" data-option=\"-15\" title=\"Rotate -90 degrees\"> 向左旋转</button>\n" +
        "                    <button type=\"button\" class=\"layui-btn layui-icon layui-icon-right\" cropper-event=\"rotate\" data-option=\"15\" title=\"Rotate 90 degrees\"> 向右旋转</button>\n" +
        "                </div>\n" +
        "                <div class=\"layui-col-xs5\" style=\"text-align: right;\">\n" +
        "                    <button type=\"button\" class=\"layui-btn layui-icon layui-icon-refresh\" cropper-event=\"reset\" title=\"重置图片\"></button>\n" +
        "                </div>\n" +
        "            </div>\n" +
        "        </div>\n" +
        "        <div class=\"layui-col-xs3\">\n" +
        "            <button class=\"layui-btn layui-btn-fluid\" cropper-event=\"confirmSave\" type=\"button\"> 确定</button>\n" +
        "        </div>\n" +
        "    </div>\n" +
        "\n" +
        "</div>";
    var obj = {
        render: function(e){
            $('body').append(html);
            var self = this,
                elem = e.elem,
                saveW = e.saveW,
                saveH = e.saveH,
                mark = saveW/saveH,
                area = e.area,
                url = e.url,
                done = e.done;
                extEle= e.extEle
            var content = $('.showImgEdit')
                ,image = $(".showImgEdit .readyimg img")
                ,preview = '.showImgEdit .img-preview'
                ,file = $(".showImgEdit input[name='file']");
                var options = {aspectRatio: mark,preview: preview,viewMode:1,width:saveW,height:saveH};
            var index = 0;
            var type='';
            $(elem).on('click',function () {
                type = $(this).data('type');
                saveW = $(this).data('width')
                saveH = $(this).data('height')
                mark = saveW/saveH
                options = {aspectRatio: mark,preview: preview,viewMode:1,width:saveW,height:saveH};
                index = layer.open({
                    type: 1
                    , content: content
                    , area: area
                    , success: function () {
                        image.attr('src','')
                        image.cropper(options);
                        image.cropper('setCropBoxData',{
                            width:150,
                            height:150
                        })
                    }
                    , cancel: function (index) {
                        layer.close(index);
                        image.cropper('setCropBoxData',{
                            width:150,
                            height:150
                        })
                        // image.cropper('destroy');
                    }
                });
            });
            $(".layui-btn").on('click',function () {
                var event = $(this).attr("cropper-event");
                //监听确认保存图像
                if(event === 'confirmSave'){
                    var data = image.cropper('getCroppedCanvas',{
                        width: saveW,
                        height: saveH
                    });
                    var imageSource = data.toDataURL('image/jpeg',0.7);
                    var _csrf = $('#_csrf').val();
                    var extData ={};
                    extData.imgData = imageSource
                    extData._csrf = _csrf
                    if(extEle != ''){
                        extData.id = $(extEle).val();
                        if(!extData.id){
                            layer.msg('获取编辑数据失败', {icon: 6}); 
                            return false;
                        }
                    }
                    $.ajax({
                        method:"post",
                        url: url, //用于文件上传的服务器端请求地址
                        data: extData,
                        success:function(result){
                            var result = result.data
                            if(result.status == 200){
                                layer.msg('上传成功',{icon: 1});
                                layer.close(index);
                                // image.cropper('destroy')
                                return done(result.url,type);
                            }else if(result.status == 0){
                                layer.alert('上传失败',{icon: 2});
                            }

                        }
                    });
                    // image.cropper('destroy');
                    //监听旋转
                }else if(event === 'rotate'){
                    var option = $(this).attr('data-option');
                    image.cropper('rotate', option);
                    //重设图片
                }else if(event === 'reset'){
                    image.cropper('reset');
                }
                //文件选择
                file.change(function () {
                    var r= new FileReader();
                    var f=this.files[0];
                    r.readAsDataURL(f);
                    image.cropper('destroy')
                    r.onload=function (e) {
                        image.attr('src', this.result).cropper(options);
                    };
                });
            });
        }

    };
    exports('croppers', obj);
});