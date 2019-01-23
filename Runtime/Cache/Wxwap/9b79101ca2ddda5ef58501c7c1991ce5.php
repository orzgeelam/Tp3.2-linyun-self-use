<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no"/>
	<meta content="yes" name="apple-mobile-web-app-capable" />
	<meta content="telephone=no" name="format-detection" />
	<meta name="renderer" content="webkit">
	
		<title><?php echo ($meta_title); ?></title>
	
	<meta name="keywords" content="<?php echo ($meta_keywords); ?>"/>
	<meta name="description" content="<?php echo ($meta_description); ?>"/>
	<link rel="stylesheet" href="/cyw/80hou/html/weui/lib/weui.min.css" />
	<link rel="stylesheet" href="/cyw/80hou/html/weui/css/jquery-weui.min.css" />
	<link rel="stylesheet" href="/cyw/80hou/html/css/reset.css" />
	<link rel="stylesheet" href="/cyw/80hou/html/css/flex.css" />
	<link rel="stylesheet" href="/cyw/80hou/html/css/style.css" />
	<script src="/cyw/80hou/html/weui/lib/jquery-2.1.4.js"></script>
	<script src="/cyw/80hou/html/weui/js/jquery-weui.min.js"></script>
	<script src="/cyw/80hou/html/js/functions.js"></script>
	<!-- <script src="/cyw/80hou/html/js/js.cookie.js"></script> -->
	<script src="/cyw/80hou/html/js/jweixin-1.0.0.js"></script>
	
	<!--[if lt IE 9 ]>
	<script src="/cyw/80hou/html/js/html5.js"></script>
	<![endif]-->
</head>
<body>
	<section class="wrap">
		
        <form action="">
            <ul class="bgf fs14 col3 item-form address_add">
                <li class="table box-b plr10 bb">
                    <div class="table-cell vm col6 item-hd">收 货 人 :</div>
                    <div class="table-cell vm">
                        <input name="realname" type="text" class="form_inp" value="<?php echo ($address["realname"]); ?>" placeholder="请输入收货人姓名">
                    </div>
                </li>
                <li class="table box-b plr10 bb">
                    <div class="table-cell vm col6 item-hd">联系方式：</div>
                    <div class="table-cell vm">
                        <input name="phone" type="text" class="form_inp" value="<?php echo ($address["phone"]); ?>" placeholder="请输入联系方式">
                    </div>
                </li>
                <li class="table box-b plr10 bb">
                    <div class="table-cell vm col6 item-hd">所在地区：</div>
                    <div class="table-cell vm arrow-icon">
                        <input type="text" id="city-picker" name="area" class="form_inp" value="<?php echo ($address["prov"]); ?> <?php echo ($address["city"]); ?> <?php echo ((isset($address["country"]) && ($address["country"] !== ""))?($address["country"]):''); ?>" placeholder="请输入收货地区">
                    </div>
                </li>
                <li class="table box-b plr10 bb">
                    <div class="table-cell vt pt10 col6 item-hd">详细地址：</div>
                    <div class="table-cell vt ptb10">
                        <textarea name="detail" cols="" rows="" class="form_text" placeholder="输入详细地址"><?php echo ($address["detail"]); ?></textarea>
                    </div>
                </li>
            </ul>
            <!-- 收货地址资料填写 end -->

            <!-- 设为默认地址 end -->

            <div class="p10 btn_submit">
                <input type="hidden" name="id" value="<?php echo ($address["id"]); ?>">
                <button type="button" id="submit_btn" class="bg_own br5 xilu_btn">保存并使用</button>
            </div>
            <!-- 表单提交 end -->

        </form>
    
	</section>
<script type="text/javascript">



</script>
	
     <block name="js">
        <script type="text/javascript" src="/cyw/80hou/html/weui/js/city-picker.js" charset="utf-8"></script>
        <script>
        $(function(){
            var main_h = $(".main").outerHeight() + 50;
            $(window).resize(function() {
                if($(window).height() < main_h){
                    $("#submit_btn").parent().removeClass("footer");
                }else{
                    $("#submit_btn").parent().addClass("footer");
                }
            });
            $("#city-picker").on("click",function () {
                $("input").blur();
            });
            // 地区选择器
            $("#city-picker").cityPicker({
                title: "请选择收货地区"
            });
            $('#submit_btn').on('click', function(){
                if($('[name="realname"]').val()==''){
                    $.alert('请填写收货人');
                    return false;
                }
                if($('[name="phone"]').val()==''){
                    $.alert('请填写联系方式');
                    return false;
                }
                var mobile =$('[name="phone"]').val();
                if (!checkTel(mobile)) {
                    $.alert('请输入正确的手机号！');
                    return false;
                }
                if($('[name="detail"]').val()==''){
                    $.alert('请填写详细地址');
                    return false;
                }
                if($.trim($('[name="area"]').val()) == ''){
                    $.alert('请选择收货地区');
                }else{
                    $.showLoading();
                    var $form = $('form');
                    $.ajax({
                        url: $form.attr('action'),
                        type: 'POST',
                        dataType: 'json',
                        data: $form.serialize(),
                    })
                    .done(function(data) {
                        if(data.status){
                            setTimeout(function(){
                                $.toast("更新成功", function(){
                                    location.href = data.url;
                                });
                            }, 0);
                        }else{
                           $.alert('更新失败');
                        }
                        console.log("success");
                    })
                    .fail(function() {
                        $.alert('网络超时，请再次尝试失败后联系管理员');
                        console.log("error");
                    })
                    .always(function() {
                        $.hideLoading();
                        console.log("complete");
                    });
                }
                return false;
            });
            // 删除
            $('.del').on('click', function(){
                var $that = $(this);
                var url ="<?php echo U('Member/address');?>";
                $.confirm("确定删除吗？", function() {
                    $.showLoading();
                    $.get($that.attr('href'), function(data){
                        $.hideLoading();
                        if(data.status){
                            setTimeout(function(){
                                $.toast("操作成功", function(){
                                    location.href =url;
                                });
                            }, 0);
                        }else{
                            $.alert('删除失败');
                        }
                    }, 'json');
                }, function() {
                    //点击取消后的回调函数
                });
                return false;
            });
        })
    </script>
    
</body>
</html>