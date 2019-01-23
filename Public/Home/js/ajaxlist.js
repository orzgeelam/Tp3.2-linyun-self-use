/**
 * Created by Administrator on 2016/12/1.
 */
//增加无数据提示
function addnothing(text, type, dom, show){
    //提示文字
    var msg = '抱歉，没有找到<em class="keyword">相关信息</em>';
    if(typeof text !== 'undefined'){
        msg = text;
    }
    //图标
    var img = 'default-none-order.png';
    if(typeof type !== 'undefined'){
        switch (type){
            case 1: break;
            case 2: img = 'default-none-goods.png';break;
            case 3: img = 'default-none-head.png';break;
            case 4: img = 'default-none-site.png';break;
            default:img = '';
        }
    }
    var picture = '';
    if(img != ''){
        picture =  '<i style="display: block; padding: 0 39%;"><img src="Public/Home/images/'+img+'" alt="" class="imgm" style="max-width:100%;"></i>';
    }
    var html = '<div class="nothing" style="padding: 40px 0;display: none;text-align: center;">'+ picture +
        '<span style="display: block;margin-top: 10px;font-size: 12px;color: #999;">'+msg+'</span>'+
        '</div>'+
        '<div class="loading" style="display: none;margin: 10px 0;text-align: center;">' +
        '<img src="Public/Home/images/loading2.gif" class="imgm" alt="" style="max-width:100%;" />' +
        '</div>';

    if(typeof dom === 'undefined'){
        $(".loadlist").after(html);
    }else{
        $(dom).after(html);
    }
    if(typeof show != 'undefined' && show == true){
        $(".nothing").show();
    }
}

//加载效果
function addloading(text, type, dom, hide){
    //文字
    var msg = '';
    if(typeof text !== 'undefined' && text != ''){
        msg = "<div style='margin: 10px 0;font-size: 12px;color: #999;'>"+text+"</div>";
    }
    //图标
    var img = 'loading2.gif';
    if(typeof type !== 'undefined'){
        switch (type){
            case 1: break;
            default:img = '';
        }
    }
    var picture = '';
    if(img != ''){
        picture =  '<img src="Public/Home/images/'+img+'" class="imgm" alt="" style="max-width:100%;" />';
    }
    var html = '<div class="loading" style="margin: 10px 0;text-align: center;">'+msg+picture+'</div>';

    if(typeof dom === 'undefined'){
        $(".loadlist").append(html);
    }else{
        $(dom).append(html);
    }
    if(typeof hide != 'undefined' && hide == true){
        $(".nothing").hide();
    }
}

//判断页面是否到达底部
function checkload(ajaxdata) {
    if ($(window).scrollTop() + $(window).height() + 50 >= $(document).height()) {
        LoadList(ajaxurl, ajaxdata);
    }
}

//重新查询(切换Tab、筛选等)
function ajaxagain(ajaxdata){
    ispost = true;
    page = 1;
    var ajax_loadlist = $(".loadlist");
    ajax_loadlist.html('');
    ajax_loadlist.nextAll(".loading").first().html('<img src="Public/Home/images/loading2.gif" class="imgm" alt="" style="max-width:100%;" /></div>');
    ajax_loadlist.nextAll(".nothing").first().hide();
    LoadList(ajaxurl, ajaxdata);
}

ispost = true;  //是否还有数据
temp = true;    //ajax是否执行完毕
page = 1;       //页数
keyword = '';
//AJAX加载
function LoadList(ajaxurl, ajaxdata) {
    var url  = ajaxurl  || "index.php?s=/Home/Index/index";
    ajaxdata['page'] = page;
    if(isEmptyObject(ajaxdata)){
        $.alert('传入的数据为空');
        return;
    }
    if (ispost && temp) {
        var ajax_loadlist = $(".loadlist");
        var ajax_nothing  = ajax_loadlist.nextAll(".nothing").first();
        var ajax_loading  = ajax_loadlist.nextAll(".loading").first();
        //$.showLoading();          //加载标志1
        ajax_loading.show();   //加载标志2
        temp = false;
        $.ajax({
            url: url,
            type: 'POST',
            data: ajaxdata,
            dataType: 'json',
            timeout: 9999,
            success: function(result) {
                if(!result.state){ //判断本次数据是否有 $limit 条
                    ispost = false;

                    if(page == 1 && result.msg == ''){ //无信息
                        ajax_nothing.show();
                        ajax_loading.hide();
                    }else{ //已显示所有数据
                        ajax_loading.html("<div style='margin: 10px 0;font-size: 12px;color: #999;'>已显示所有<em class='keyword'></em>！</div>");
                    }
                    var nothingtext=(result.nothingtext!=undefined && result.nothingtext!='')?result.nothingtext:'信息';
                    goodsnone(nothingtext, ajax_loading);
                }else{
                    ajax_loading.hide();
                }

                if (result.msg != '') {
                    ajax_loadlist.append(result.msg);
                    imglazyload();
                    imgHeight();
                    if(typeof afterAjax == 'function'){
                        afterAjax();
                    }
                    $(".new_ajax_list").removeClass('new_ajax_list');
                }
                page++;
            },
            error: function() {
                ajax_loading.hide();
            }
        }).always(function(){
            //$.hideLoading();
            temp = true;
        });
    }
}

//判断对象是否为空
function isEmptyObject(obj){
    var res;
    for(res in obj){
        return false;
    }
    return true;
}

//修改无商品提示
function goodsnone(nothingtext, dom){
    var keywordtext = keyword == '' ? '' : '与“<em class="colred">'+keyword+'</em>”相关的';
    dom.find(".keyword").html(keywordtext+nothingtext);
}