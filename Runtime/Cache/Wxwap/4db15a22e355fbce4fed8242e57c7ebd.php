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
		
   <?php if(($address_num) == "0"): ?><div class="tc nothing">
            <i><img src="/cyw/80hou/html/images/icon_none-site.png" alt="" class="imgm"></i>
            <span class="mt10 fs14 col9">您还没有地址<br>赶快去添加吧！</span>
        </div>
        <?php else: ?>
    <div class="p10 item-info item-default address_li" data-id="<?php echo ($default["id"]); ?>">
        <a href="javascript:;" class="fs14 col3 item-hd arrowR">
            <span class="mr10"><i class="mr5 ico-user"></i><?php echo ($default["realname"]); ?></span>
            <span class="mr10"><i class="mr5 ico-tel"></i><?php echo ($default["phone"]); ?></span>
            <p class="pt10"><?php echo ($default["prov"]); echo ($default["city"]); echo ((isset($default["country"]) && ($default["country"] !== ""))?($default["country"]):''); echo ($default["detail"]); ?></p>
            <em class="br5 fs12 colf status">默认地址</em>
        </a>
        <div class="clearfix mt10 pt10 bt fs12 item-ft">
            <span class="fr link">
                <a href="<?php echo U('Center/address_edit', ['id'=>$default['id']]);?>" class="col6"><i class="mr5 ico-edit"></i>编辑</a>
                <a href="<?php echo U('Center/address_del', ['id'=>$default['id']]);?>" class="ml10 col6"><i class="mr5 ico-del"></i>删除</a>
            </span>
        </div>
    </div><?php endif; ?>
    <!-- 默认地址 end -->
    <?php if(!empty($list)): ?><ul class="address_admin">
            <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$address): $mod = ($i % 2 );++$i;?><li class="mb10 p10 btb bgf item-info address_li"  data-id="<?php echo ($address["id"]); ?>">
                    <div class="fs14 col3 item-hd">
                        <span><i class="mr5 ico-user"></i><?php echo ($address["realname"]); ?></span>
                        <span class="ml10"><i class="mr5 ico-tel"></i><?php echo ($address["phone"]); ?></span>
                        <p class="pt10"><?php echo ($address["prov"]); echo ($address["city"]); echo ((isset($address["country"]) && ($address["country"] !== ""))?($address["country"]):''); echo ($address["detail"]); ?></p>
                    </div>
                    <div class="clearfix mt10 pt10 bt fs12 item-ft">
                        <a href="<?php echo U('Center/address_set_default', ['id'=>$address['id']]);?>" class="fl br5 set">设为默认地址</a>
                <span class="fr link">
                    <a href="<?php echo U('Center/address_edit', ['id'=>$address['id']]);?>" class="col6"><i class="mr5 ico-edit"></i>编辑</a>
                    <a href="<?php echo U('Center/address_del', ['id'=>$address['id']]);?>" class="ml10 col6"><i class="mr5 ico-del"></i>删除</a>
                </span>
                    </div>
                </li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul><?php endif; ?>


    <!-- 地址列表 end -->
<!--
    <div class="tc nothing">
        <i><img src="/cyw/80hou/html/images/icon_none-site.png" alt="" class="imgm"></i>
        <span class="mt10 fs14 col9">您还没有地址<br>赶快去添加吧！</span>
    </div> -->
    <!-- 暂无收货地址 end -->

    <div class="p10 btn_submit">
        <button type="button" class="bg_own br5 xilu_btn"><i class="Ico-add"></i>新增地址</button>
    </div>
    <!-- 新增收货地址 end -->

	</section>
<script type="text/javascript">



</script>
	
<block name="js">
<script>
    $(function(){
        //删除
        $('.del').on('click', function(){
         var $that = $(this);
         $.confirm("确定删除吗？", function() {
             $.showLoading();
             $.get($that.attr('href'), function(data){
                 $.hideLoading();
                 if(data.status){
                     setTimeout(function(){
                         $.toast("操作成功", function(){
                             location.reload(true);
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

        $(':button').on('click',function(){
            var add_url ="<?php echo U('Center/address_add');?>";
            location.href= add_url;
        })

        // // 地址跳转
         $('.address_li').on('click', function(){
            if("<?php echo ($from); ?>" != ''){
                Cookies.set('fy_home_default_address_id', $(this).data('id'));
                location.href = "<?php echo ($from); ?>";
            }
         });

        //设为默认
        $('.set').on('click', function(){
         $('[name=default]').eq(0).prop({ checked: true });
         var $that = $(this);
         var address_id =<?=$default['id']?>;
         // alert(address_id);
         $.confirm("确定设为默认地址？", function() {
             $.showLoading();
             // alert(<?=$default['id']?>);
             var set_url   ="<?php echo U('Center/address_set_default');?>";
              // var set_url   ="<?php echo U('Center/address_set_default',array('cid' => "+$(this).data('id')+"));?>";
             $.ajax({
                 url:set_url,
                 type:'post',
                 dataType:'json',
                 data:{'id':address_id},
                 success:function(data){
                     if(data.status){
                         $.hideLoading();
                         setTimeout(function(){
                             $.toast("设为默认成功", function(){
                                 if(data.url){
                                     location.href = data.url;
                                 }else{
                                     location.reload(true);
                                 }
                             });
                         }, 0);
                     }else{
                         $.hideLoading();
                         $.alert(data.info);
                     }
                 }
             });
         });
         return false
        });
    })
</script>

</body>
</html>