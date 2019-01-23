/*
* 自定义JS函数
*/
$(function(){
    // 切换图形验证码
    $(document).on('click', '.code_img', function(){
        var verifyimg = $(this).find('img').attr('src');
        if (verifyimg.indexOf('?') > 0) {
            $(".verifyimg").attr("src", verifyimg + '&random=' + Math.random());
        } else {
            $(".verifyimg").attr("src", verifyimg.replace(/\?.*$/, '') + '?' + Math.random());
        }
    });

    //获取短信验证码
    $(document).on('click', ".smscode",function () {
        //是否已发送、读秒中
        if ($(this).hasClass('on')) {
            return false;
        }
        //验证手机唯一性
        var unique = $(this).data('unique');
        unique = typeof unique == 'undefined'? 0 : unique;

        var mobile = $('[name=mobile]').val();
        // 手机号码验证
        if (!checkmoile(mobile)) {
            return false;
        }
        var code = $('[name=verify_code]').val();
        if(typeof code !== 'undefined'){
            // 图形验证码判断
            if(code == ''){
                layer.msg('请输入图形验证码');
                return false;
            }
        }else{
            code = '';
        }

        var url = "index.php?s=/Home/Base/send";
        $.ajax({
            url: url,
            type: "POST",
            async: false, //ajax同步
            dataType: "json",
            data: {mobile: mobile,code:code,unique: unique},
            timeout: 10000,
            error: function () {
                layer.alert('发送失败，请重新获取验证码！');
            },
            success: function (data) {
                if (data.status) {
                    $(".smscode").addClass('on');
                    now_time(59);
                } else {
                    layer.alert(data.info);
                    //重置图形验证码
                    $('.code_img').click();
                }
            }
        });
    });

    //WEUI预览图片
    $(document).on('click','.preview_list',function(event){
        var items = [];
        $(this).find('img').each(function(){
            var src = $(this).attr("src");
            items.push(src);
        });
        var pb1 = $.photoBrowser({
            items: items,
            onClose: function(){items = [];}
        });
        pb1.open();
        $(".weui-photo-browser-modal").css({"z-index":"9999"});
    });
});

// 获取购物车中数量
function getnums(){
    $.ajax({
        url: "index.php?s=Shop/Cart/cart_num",
        dataType: 'json',
        cache:false,
        success:function(result){
            if(result['num']>=1){
                $('#shoppingcart_count').html(result['num']);
                $('#shoppingcart_count').closest('span').show();
            }else{
                $('#shoppingcart_count').html('');
                $('#shoppingcart_count').closest('span').hide();
            }
        }
    });
}

//验证手机
function checkmoile(mobile){
    if(!mobile){
        layer.msg('请输入手机号码');
        return false;
    }
    if (!checkTel(mobile)) {
        layer.msg('请输入正确的手机号码');
        return false;
    }
    return true;
}

//检测手机号正确性
function checkTel(tel){
    if(/^(0|86|17951)?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/.test(tel)){
        return true;
    }
    return false;
}

//检测邮箱
function checkEmail(email){
    var patt1 = new RegExp("^[\\w\\d]+([._\\-]*[\\w\\d])*@([\\w\\d]{2,6})\.[\\w\\d]{2,5}$",'i');
    if(patt1.test(email)){
        return true;
    }
    return false;
}

//倒计时
function now_time(time) {
    var $this = $(".smscode");
    if (time == 'undefined') {
        time = 59;
    }
    $this.html(time + "s后重新获取");
    if (time > 0) {
        time = time - 1;
        setTimeout("now_time(" + time + ")", 1000)
    } else {
        $this.removeClass("on");
        $this.html('重新获取');
    }
}

//表单提交
function formToSumbit(dom, data){
    var $form = typeof dom == 'undefined' ? $("form") : dom;
    var $data = $form.serialize();
    if(data){
        $data += data;
    }
    $.ajax({
        url: $form.attr('action'),
        type: 'POST',
        dataType: 'json',
        data: $data
    }).done(function(data) {
        if(data.status){
            if(data.info){
                layer.msg(data.info,{time:3000},function(){
                    location.href = data.url;
                });
            }else{
                location.href = data.url;
            }
        }else{
            $.alert(data.info);
        }
    }).fail(function() {
        $.hideLoading();
        $.alert('网络超时，请再次尝试失败后联系管理员');
        console.log("error");
    }).always(function() {
    });
    return false;
}

//WebUploader上传图片
function uploadImage(dom, url){
    url = typeof url == 'undefined' ? 'index.php?s=/Home/Upload/upload' : url;
    //上传头像
    var uploader_avatar = WebUploader.create({
        auto: true, // 选完文件后，是否自动上传
        server: url, // 文件接收服务端
        pick: {
            id:"#avatar_picker"+dom,
            label:' ',
            innerHTML:' ',
            multiple:true
        }, // 选择文件的按钮。可选
        accept: {
            title: 'Images',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/*'
        },
        thumb:{
            width: 60,
            height: 60,
            // 图片质量，只有type为`image/jpeg`的时候才有效。
            quality: 100,
            // 是否允许放大，如果想要生成小图的时候不失真，此选项应该设置为false.
            allowMagnify: false,
            // 是否允许裁剪。
            crop: true,
            // 为空的话则保留原有图片格式。
            // 否则强制转换成指定的类型。
            type: ''
        },
        compress:{
            width: 1600,
            height: 1600,
            // 图片质量，只有type为`image/jpeg`的时候才有效。
            quality: 90,
            // 是否允许放大，如果想要生成小图的时候不失真，此选项应该设置为false.
            allowMagnify: false,
            // 是否允许裁剪。
            crop: false,
            // 是否保留头部meta信息。
            preserveHeaders: true,
            // 如果发现压缩后文件大小比原来还大，则使用原来图片
            // 此属性可能会影响图片自动纠正功能
            noCompressIfLarger: false,
            // 单位字节，如果图片大小小于此值，不会采用压缩。
            compressSize: 0
        },
        headers:{
            'HTTP_UPLOADTOKEN':'xilu'
        },
        Transport:{
            server: url,
            method: 'POST',
            // 跨域时，是否允许携带cookie, 只有html5 runtime才有效
            withCredentials: false,
            fileVar: 'headimgurl',
            timeout: 2 * 60 * 1000,    // 2分钟
            formData: {
                'session_id': '{:session_id()}',
                'ajax':       1
            },
            sendAsBinary: false
        }
    });

    uploader_avatar.on( 'fileQueued', function( file ) {
        var $container = $("#avatar_picker"+dom);
        $container.toggleClass('weui_uploader_file');
        // $container.addClass('weui_uploader_status');

        // 创建缩略图
        uploader_avatar.makeThumb( file, function( error, src ) {
            if ( error ) {
                $.toast('不能预览', 'text');
                return;
            }
            // var data = [];
            // data['src'] = src;
            // afterdownload(1,data);
            //$('#avatar_picker'+dom).closest('li').before('<li class="mt10 mr10 ba upload-img" style="background-image:url('+src+');"><a href="javascript:;" class="br50 upload-close"></a><input type="hidden" name="comment['+dom+'][pics][]" value=""></li>');
            //$container.css({'background-image': 'url('+src+')'});
            $('#avatar_picker'+dom+' .webuploader-pick').hide();
        }, 100, 100 ); //100x100为缩略图尺寸
    });

    // 文件上传过程中创建进度条实时显示。
    uploader_avatar.on( 'uploadProgress', function( file, percentage ) {
        var $container = $("#avatar_picker"+dom);
        $container.addClass('weui_uploader_status');
        $percent = $container.find('.weui_uploader_status_content');

        // 避免重复创建
        if ( !$percent.length ) {
            $percent = $('<div class="weui_uploader_status_content">' +
            '0%' +
            '</div>').appendTo( $container );
        }
        if(percentage != 1){
            $percent.text( parseFloat(percentage).toFixed(2) * 100 + '%' );
        }
    });

    // 上传结束
    uploader_avatar.on( 'uploadSuccess', function( file ,response) {
        var $container = $("#avatar_picker"+dom);
        // var data = [];
        // data['id'] = response.id;
        // data['path'] = response.path;

        afterdownload(response, dom);
        //$("#avatar_picker"+dom).closest('ul').find('[name="comment['+dom+'][pics][]"]').eq(num[dom]).val(response.id);
        //$container.parent().prev().find("input").val(response.id);
        // console.log(uploader_avatar.getStats());
        $percent = $container.find('.weui_uploader_status_content');
        $percent.fadeOut('400', function(){
            $container.removeClass('weui_uploader_status');
            uploader_avatar.removeFile( file, true );
            $('.webuploader-pick').show();
        });
    });

    uploader_avatar.on( 'uploadError', function( file ) {
        console.log('uplad error');
        var $container = $("#avatar_picker"+dom);
        $error = $container.find('.weui_uploader_status_content .weui_icon_warn');

        // 避免重复创建
        if ( !$error.length ) {
            $container.find('.weui_uploader_status_content').html($('<i class="weui_icon_warn"></i>'));
        }

        $error.text('上传失败');
    });
}

//Layer图片预览
function imgPreviewByLayer(dom,type){
    var a = typeof dom == 'undefined' ? '.preview' : dom;
    var b = typeof type == 'undefined' ? 5 : type;
    layer.photos({
        photos: a,
        anim: b //0-6的选择，指定弹出图片动画类型，默认随机（请注意，3.0之前的版本用shift参数）
    });
}

//退出登录
function logout(url){
    var logoutUrl = typeof url == 'undefined' ? 'index.php?s=Shop/Login/logout' : url;
    $.ajax({
        dataType: "json",
        url: logoutUrl,
        cache:false,
        success: function(data){
            if(data.status){
                layer.msg(data.info,{time:3000}, function () {
                    location.href = data.url;
                    //location.reload(true);
                });
            }
        }
    });
}