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

	<div class="top_fixed">
		<div class="plr10 bb bgf box search_header">
			<div class="ba br5 flex-1 sH_main">
				<a href="javascript:;" class="block col9 sH_search"><i class="ico_search"></i>输入搜索的关键词</a>
			</div>
			<a href="javascript:;" class="tc col_own sH_filter">筛选</a>
		</div>
	</div>
	<!-- 顶部悬浮栏目 end -->

	<section class="main">

		<div class="filter-main">
			<div class="item-bg"></div>
			<div class="box-b item-main">
				<div class="p10 bb fs14 col_own">装修风格</div>
				<div class="clearfix plr10 pb10 bb tc fs13 col3 m-filter">
					<label class="specs_label" for="filter11">
						<input type="radio" class="specs_check" name="filter1" id="filter11" checked>
						<span class="box-b br3 single-line specs_checked">全部</span>
					</label>
					<label class="specs_label" for="filter12">
						<input type="radio" class="specs_check" name="filter1" id="filter12">
						<span class="box-b br3 single-line specs_checked">现代简约</span>
					</label>
					<label class="specs_label" for="filter13">
						<input type="radio" class="specs_check" name="filter1" id="filter13">
						<span class="box-b br3 single-line specs_checked">简欧风格</span>
					</label>
					<label class="specs_label" for="filter14">
						<input type="radio" class="specs_check" name="filter1" id="filter14">
						<span class="box-b br3 single-line specs_checked">田园风格</span>
					</label>
					<label class="specs_label" for="filter15">
						<input type="radio" class="specs_check" name="filter1" id="filter15">
						<span class="box-b br3 single-line specs_checked">地中海风格</span>
					</label>
				</div>
				<div class="p10 bb fs14 col_own">装修面积</div>
				<div class="clearfix plr10 pb10 bb tc fs13 col3 m-filter">
					<label class="specs_label" for="filter21">
						<input type="radio" class="specs_check" name="filter2" id="filter21" checked>
						<span class="box-b br3 single-line specs_checked">全部</span>
					</label>
					<label class="specs_label" for="filter22">
						<input type="radio" class="specs_check" name="filter2" id="filter22">
						<span class="box-b br3 single-line specs_checked">一居室</span>
					</label>
					<label class="specs_label" for="filter23">
						<input type="radio" class="specs_check" name="filter2" id="filter23">
						<span class="box-b br3 single-line specs_checked">二居室</span>
					</label>
					<label class="specs_label" for="filter24">
						<input type="radio" class="specs_check" name="filter2" id="filter24">
						<span class="box-b br3 single-line specs_checked">三居室</span>
					</label>
					<label class="specs_label" for="filter25">
						<input type="radio" class="specs_check" name="filter2" id="filter25">
						<span class="box-b br3 single-line specs_checked">四居室</span>
					</label>
				</div>
				<div class="bt item-btn">
					<div class="table bgf tc fs15">
						<a href="javascript:;" class="table-cell col3 reset">重置</a>
						<a href="javascript:;" class="table-cell bg_own colf">确定</a>
					</div>
				</div>
			</div>

		</div>
		
		

		<ul class="">
			<?php if(is_array($category_list)): foreach($category_list as $key=>$list): ?><li class="mt10 btb">
					<a href="<?php echo U('casedetails',array('cid'=>$list['id']));?>" class="m-headline">
					<!-- <img src="<?php echo getpics($list['cover']);?>" alt="" class="imgm"> -->
						<img src="html/images/img_list.jpg" alt="" class="imgm">
						<p class="plr10 tc fs14 colf single-line"><?php echo ($list["title"]); ?></p>
					</a>
				</li><?php endforeach; endif; ?>
			
		</ul>

		<div class="mt10 p10 bgf tc m-nextpage">
			<a href="" class="br5 mini_btn"><<上一页</a>
			<span class=""><em class="colred">1</em>/5</span>
			<a href="" class="br5 mini_btn">下一页>></a>
		</div>

	</section>


</section>
<!-- 主体 end -->


<section class="search_wrap">

	<dl class="table bgf header">
		<dd class="table-cell vm">
			<a href="javascript:;" class="back"></a>
		</dd>
		<dt class="table-cell vm">
			<p class="tc">搜索</p>
		</dt>
		<dd class="table-cell vm"></dd>
	</dl>

	<form action="" class="p10 search_main">
		<div class="br5 sM_inner">
			<i class="ico_search"></i>
			<input type="search" class="form_inp" placeholder="搜索" required="">
		</div>
		<input type="submit" class="fs12 col_own form_inp sM_submit" value="确认">
	</form>

</section>

	</section>
<script type="text/javascript">



</script>
	
	<script>
		$(function() {
			$(document).on('click','.sH_filter',function () {
				if(!$(this).hasClass("on")){
					$(this).addClass("on");
					$(".filter-main").addClass("filter-mainShow");
					$("html,body").addClass("body_hide");
				}else{
					$(this).removeClass("on");
					$(".filter-main").removeClass("filter-mainShow");
					$("html,body").removeClass("body_hide");
				}
			});
			$(document).on('click','.filter-main .item-bg',function() {
				$(".sH_filter").removeClass("on");
				$(".filter-main").removeClass("filter-mainShow");
				$("html,body").removeClass("body_hide");
			});
			$(document).on('click','.filter-main .reset',function() {
				$(".m-filter").find("input").prop({"checked":false});
			});
			//搜索
			$(document).on('click','.search_header .sH_search',function() {
			$(".wrap").hide();
			$(".search_wrap").show();
		});
		$(document).on('click','.header .back',function() {
			$(".wrap").show();
			$(".search_wrap").hide();
	});
		});

	</script>

</body>
</html>