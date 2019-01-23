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
		
    <form action="<?php echo U('address_add');?>">
        <ul class="bgf fs14 col3 item-form address_add">
            <li class="table box-b plr10 bb">
                <div class="table-cell vm col6 item-hd">收 货 人 :</div>
                <div class="table-cell vm">
                    <input name="realname" type="text" class="form_inp" placeholder="请输入收货人姓名">
                </div>
            </li>
            <li class="table box-b plr10 bb">
                <div class="table-cell vm col6 item-hd">联系方式：</div>
                <div class="table-cell vm">
                    <input name="phone" type="text" class="form_inp" placeholder="请输入联系方式">
                </div>
            </li>
            <li class="table box-b plr10 bb">
                <div class="table-cell vm col6 item-hd">所在地区：</div>
                <div class="table-cell vm arrow-icon">
                    <input type="text" id="city-picker" name="area" class="form_inp" placeholder="请输入收货地区">
                </div>
            </li>
            <li class="table box-b plr10 bb">
                <div class="table-cell vt pt10 col6 item-hd">详细地址：</div>
                <div class="table-cell vt ptb10">
                    <textarea name="detail" cols="" rows="" class="form_text" placeholder="输入详细地址"></textarea>
                </div>
            </li>
        </ul>
        <!-- 收货地址资料填写 end -->

        <div class="p10 weui_cells_checkbox set_default">
            <label class="weui_check_label table-cell vm" for="buy1">
                <input type="checkbox" class="weui_check" name="default" value="1" id="buy1">
                <i class="weui_icon_checked">设为默认地址</i>
            </label>
        </div>
        <!-- 设为默认地址 end -->

        <div class="p10 btn_submit">
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
        // $(window).resize(function() {
        //  if($(window).height() < main_h){
        //      $("#submit_btn").parent().removeClass("footer");
        //  }else{
        //      $("#submit_btn").parent().addClass("footer");
        //  }
        // });

        $("#city-picker").on("click",function () {
            $("input").blur();
        });
        // 选择城市
        $("#city-picker").cityPicker({
            title: "请选择收货地址"
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
                var url  ="<?php echo U('Center/address_add');?>";
                var $form = $('form').serialize();
                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    data: $form,
                })
                .done(function(data) {
                    if(data.status){
                        setTimeout(function(){
                            $.toast("新增成功", function(){
                                location.href = data.url;
                            });
                        }, 0);
                    }else{
                       $.alert('新增失败');
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
    })
</script>

</body>
</html>