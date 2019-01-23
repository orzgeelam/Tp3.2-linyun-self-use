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
		
	<section class="wrap">

	<div class="foot_fixed">
		<footer class="table bt bgf tc fs13 footer">
			<a href="#" class="table-cell active"><i class="fi-1"></i>首页</a>
			<a href="#" class="table-cell"><i class="fi-2"></i>优惠活动</a>
			<a href="#" class="table-cell"><i class="fi-3"></i>团装小区</a>
			<a href="#" class="table-cell"><i class="fi-4"></i>主材品牌</a>
			<a href="#" class="table-cell"><i class="fi-5"></i>80后</a>
		</footer>
	</div>
	<!-- 底部悬浮 end -->

	<section class="main">

		<div class="swiper-container banner">
			<div class="swiper-wrapper">
				<div class="swiper-slide">
					<img src="/cyw/80hou/html/images/banner.jpg" alt="" class="imgm">
				</div>
				<div class="swiper-slide">
					<img src="/cyw/80hou/html/images/banner.jpg" alt="" class="imgm">
				</div>
				<div class="swiper-slide">
					<img src="/cyw/80hou/html/images/banner.jpg" alt="" class="imgm">
				</div>
			</div>
			<div class="swiper-pagination"></div>
		</div>
		<!-- banner end -->
		<!-- 轮播插件 -->
		<script src="weui/js/swiper.js"></script>
		<script>
		$(function(){
			var swiperWidth = $(".banner").width();
				swiperHeight = swiperWidth * 0.5;
				$(".banner").css("height",swiperHeight);
			$(".banner").swiper({
				pagination: '.swiper-pagination',
				loop: true,
				autoplay: 3000,
				autoplayDisableOnInteraction : false,
			});
		});
		</script>

		<nav class="bgf pt10 btb clearfix tc fs14 nav_quick">
			<a href="" class="mb10 col6">
				<img src="/cyw/80hou/html/images/icon_nav_1.png" alt="" class="imgm">
				<p class="mt5">装修预约</p>
			</a>
			<a href="" class="mb10 col6">
				<img src="/cyw/80hou/html/images/icon_nav_2.png" alt="" class="imgm">
				<p class="mt5">优惠活动</p>
			</a>
			<a href="<?php echo U('case/index');?>" class="mb10 col6">
				<img src="/cyw/80hou/html/images/icon_nav_3.png" alt="" class="imgm">
				<p class="mt5">实景案例</p>
			</a>
			<a href="" class="mb10 col6">
				<img src="/cyw/80hou/html/images/icon_nav_4.png" alt="" class="imgm">
				<p class="mt5">设计团队</p>
			</a>
			<a href="" class="mb10 col6">
				<img src="/cyw/80hou/html/images/icon_nav_5.png" alt="" class="imgm">
				<p class="mt5">施工团队</p>
			</a>
			<a href="" class="mb10 col6">
				<img src="/cyw/80hou/html/images/icon_nav_6.png" alt="" class="imgm">
				<p class="mt5">品牌简介</p>
			</a>
			<a href="" class="mb10 col6">
				<img src="/cyw/80hou/html/images/icon_nav_7.png" alt="" class="imgm">
				<p class="mt5">品牌动态</p>
			</a>
			<a href="javascript:;" class="mb10 col6" id="show-call">
				<img src="/cyw/80hou/html/images/icon_nav_8.png" alt="" class="imgm">
				<p class="mt5">客服热线</p>
			</a>
		</nav>


		<div class="mt10 mb10 p10 btb bgf offer_wrap">
			<div class="pb10">
				<img src="/cyw/80hou/html/images/img_indextitle.jpg" alt="" class="imgm">
			</div>
			<div class="p15 bt tc item-hd">
				<span class="fs14 col_own">简单填写您的房屋信息<br>一分钟给你信提供装修报价清单</span>
			</div>
			<div class="table box-b ba tc fs14 col_own nav_tab">
				<a href="" class="table-cell vm active">全包按面积报价</a>
				<a href="" class="table-cell vm">半包按面积报价</a>
			</div>
			<div class="p5 offer_mian">
				<ul class="fs13 col3">
					<li class="table mt10">
						<div class="table-cell vm item-tit">户型</div>
						<div class="table-cell vm">
							<div class="m-dropdown">
								<select name="one" class="m-dropdown-select">
									<option value="">请选择户型</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
								</select>
							</div>
						</div>
						<div class="table-cell vm plr10 tr" style="width: 60px;">卫生间</div>
						<div class="table-cell vm">
							<div class="m-dropdown">
								<select name="one" class="m-dropdown-select">
									<option value="">请选择户型</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
								</select>
							</div>
						</div>
					</li>
					<li class="table mt10">
						<div class="table-cell vm item-tit">阳台</div>
						<div class="table-cell vm">
							<div class="m-dropdown">
								<select name="one" class="m-dropdown-select">
									<option value="">请选择数量</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
								</select>
							</div>
						</div>
						<div class="table-cell vm plr10 tr" style="width: 60px;">装修档次</div>
						<div class="table-cell vm">
							<div class="m-dropdown">
								<select name="one" class="m-dropdown-select">
									<option value="">请选择档次</option>
									<option value="1">经济实惠</option>
									<option value="2">2</option>
									<option value="3">3</option>
								</select>
							</div>
						</div>
					</li>
					<li class="table">
						<div class="table-cell vt item-tit" style="padding-top: 15px;">面积</div>
						<div class="table-cell vt m-specs">
							<label class="specs_label" for="spec1">
								<input type="radio" class="specs_check" name="spec_radio" id="spec1">
								<span class="br3 specs_checked">客厅</span>
							</label>
							<label class="specs_label" for="spec2">
								<input type="radio" class="specs_check" name="spec_radio" id="spec2">
								<span class="br3 specs_checked">餐厅</span>
							</label>
							<label class="specs_label" for="spec3">
								<input type="radio" class="specs_check" name="spec_radio" id="spec3">
								<span class="br3 specs_checked">卧房</span>
							</label>
							<label class="specs_label" for="spec4">
								<input type="radio" class="specs_check" name="spec_radio" id="spec4">
								<span class="br3 specs_checked">厨房</span>
							</label>
							<label class="specs_label" for="spec5">
								<input type="radio" class="specs_check" name="spec_radio" id="spec5">
								<span class="br3 specs_checked">卫生间</span>
							</label>
							<label class="specs_label" for="spec6">
								<input type="radio" class="specs_check" name="spec_radio" id="spec6">
								<span class="br3 specs_checked">阳台</span>
							</label>
						</div>
					</li>
					<li class="table mt10">
						<div class="table-cell vm item-tit">称呼</div>
						<div class="table-cell vm">
							<input type="text" class="m-input" placeholder="请输入您的称呼">
						</div>
					</li>
					<li class="table mt10">
						<div class="table-cell vm item-tit">号码</div>
						<div class="table-cell vm">
							<input type="text" class="m-input" placeholder="请输入您的联系方式">
						</div>
					</li>
				</ul>
			</div>
			<button type="button" class="mt10 xilu_btn bg_own">立即报价</button>
		</div>


		<script>
		$(function() {
			$(document).on("click", "#show-call", function() {
				$.modal({
					title: "",
					text: '<div class="fs13 col3"><i class="ico_call"></i>拨打客服热线<p class="fs18">820-822-8820</p></div>',
					buttons: [
						{ text: "取消", className: "default"},
						{ text: "立即拨打", onClick: function(){ $.alert("立即拨打"); } },
					]
				});
			});
		});
		</script>


	</section>

	</section>
<script type="text/javascript">



</script>
	


</body>
</html>