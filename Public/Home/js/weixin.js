/**
 * WX js函数
 */

wx.ready(function (){
    //分享给朋友
    wx.onMenuShareAppMessage({
        title: share_conf.title,
        desc: share_conf.desc,
        link: share_conf.link,
        imgUrl: share_conf.imgUrl,
        success: function () {
            // alert('分享成功');
        },
        cancel: function () {
            console.log('已取消');
        }
    });
    //分享到朋友圈
    wx.onMenuShareTimeline({
        title: share_conf.title,
        link: share_conf.link,
        imgUrl: share_conf.imgUrl,
        success: function () {
            // alert('分享成功');
        },
        cancel: function () {
            console.log('已取消');
        }
    });

    //录音自动停止
    /*wx.onVoiceRecordEnd({
     // 录音时间超过一分钟没有停止的时候会执行 complete 回调
     complete: function (res) {
     var localId = res.localId;
     uploadAudio(localId);
     }
     });*/

    //播放结束
    /*wx.onVoicePlayEnd({
     success: function (res) {
     var localId = res.localId; // 返回音频的本地ID
     }
     });*/
});

var $audio;
var $audioIco;
var is_playFinish;
var web_url;
$(function() {
    //图片预览
    $(document).on('click', '.preview_list img', function () {
        var imgArray = [];
        var curImageSrc = $(this).attr('src');
        //closest 从自身开始匹配，不成功则向上寻找
        $(this).closest('.preview_list').find('img').each(function (index, el) {
            var itemSrc = $(this).attr('src');
            imgArray.push(web_url + itemSrc);
        });
        wx.previewImage({
            current: web_url + curImageSrc,
            urls: imgArray
        });
    });

    //语音
    //录制语音
    /*
     <div class="detail_dialog">
     <div class="item-mask"></div>
     <a href="javascript:;" class="m-tape"></a>
     <p class="fs13 colf tc time-bar">0:00</p>
     </div>

     .detail_dialog{ display: none; width: 100%; height: 100%; position: fixed; top: 0; left: 0; z-index: 100; }
     .detail_dialog .item-mask{ width: 100%; height: 100%; background-color: rgba(0,0,0,0.8); }
     .detail_dialog .time-bar{width: 100%;bottom: 18px;position: absolute;}
     .m-tape{ display: block; width: 60px; height: 60px; background-color: #e94182; background-image: url(../images/icon_tape.png); background-size: 50% auto; background-position: 50% 50%; background-repeat: no-repeat; -webkit-border-radius: 50%; border-radius: 50%; position: absolute; left: 50%; margin-left: -30px; bottom: 40px; z-index: 9; }
     .m-tape.no{ background-color: #12bb08;background-image: url(../images/icon_tape1.png); }
    */
    $(document).on('touchend', '#audio_upload', function () {
        //显示弹窗
        $('.detail_dialog').show();
    });

    //录音切换
    $(document).on('click','.detail_dialog .m-tape',function(){
        var $this = $(this);
        if($this.hasClass('no')){
            status_of_record(2);
            wx.stopRecord({
                success: function (res) {
                    var localId = res.localId;
                    $.confirm('录音结束，是否立即上传',function(){
                        uploadAudio(localId);
                        $('.detail_dialog').hide();
                    });
                }
            });
        }else{
            //$.toast('开始录音~~~', 'text');
            status_of_record(1);
            wx.startRecord();
            wx.onVoiceRecordEnd({
                // 录音时间超过一分钟没有停止的时候会执行 complete 回调
                complete: function (res) {
                    var localId = res.localId;
                    status_of_record(2);
                    $.confirm('录音结束，是否立即上传',function(){
                        uploadAudio(localId);
                        $('.detail_dialog').hide();
                    });
                }
            });
        }
    });

    //取消录音
    $(document).on('touchend','.detail_dialog .item-mask',function(){
        status_of_record(2);
        wx.stopRecord();
        $('.detail_dialog').hide();
        $(".detail_dialog .time-bar").html('<em class="record_timimg">0:00</em>');
    });

    //播放
    $(document).on('click', "#audio_play", function () {
        wx.playVoice({
            localId: localIds // 需要播放的音频的本地ID，由stopRecord接口获得
        });
    });
    //暂停
    $(document).on('click', "#audio_pause", function () {
        wx.pauseVoice({
            localId: '' // 需要暂停的音频的本地ID，由stopRecord接口获得
        });
    });
    //停止
    $(document).on('click', "#audio_stop", function () {
        wx.stopVoice({
            localId: localIds // 需要播放的音频的本地ID，由stopRecord接口获得
        });
    });

    //播放音频
    /*
     <div>
     <a href="javascript:;" class="voice audio_play">
     <i class="Icon-voice"></i>
     <audio src="{:get_cover($vo['audio'])}"></audio>
     </a>
     </div>

     [class*="Icon-"]{position: relative;width:22px;height:22px;display: inline-block; vertical-align: middle; background-image: url(../images/icon.png); background-size:22px auto; background-repeat: no-repeat; }
     .Icon-voice{background-position: 0 -237px;position: absolute;top:calc(50% - 1px);top:-webkit-calc(50% - 1px);transform: translate(0,-50%);-webkit-transform: translate(0,-50%);left:4px;}
     .Icon-voice.on{background-position: 0 0;background-image: url(../images/audio.gif);width:16px;height:18px;background-size:16px auto; background-repeat: no-repeat;margin-left: 4px}
    */
    $(document).on('click', ".audio_play", function () {
        var $this = $(this).children('.Icon-voice');
        var audioEle = $this.next()[0];
        if($this.hasClass('on')){
            audioEle.pause();    //暂停
            $this.removeClass('on');
            window.clearInterval(is_playFinish);
        }else{
            if(typeof($audio) !== 'undefined'){
                $audio.pause();
                $audioIco.removeClass('on');
                window.clearInterval(is_playFinish);
            }
            audioEle.currentTime = 0;
            audioEle.play();    //播放
            $this.addClass('on');
            is_playFinish = setInterval(function(){
                if($audio.ended){
                    $audioIco.removeClass('on');
                    window.clearInterval(is_playFinish);
                }
            }, 1000);
            $audio = audioEle;
            $audioIco = $this;
        }
    });
});

//调用扫码
function usescan(){
    wx.scanQRCode({
        needResult: 0, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
        scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
        success: function (res) {
            // var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
        }
    });
}

//上传图片
function chooseImg(num){
    num = num || 9;
    wx.chooseImage({
        count: num, // 默认9
        sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
        sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
        success: function (res) {
            localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
            uploadImg(localIds);
        }
    });
}
function uploadImg(localIds) {
    var localId = localIds.shift(); //把数组的第一个元素从其中删除，并返回第一个元素的值
    wx.uploadImage({
        localId: localId, // 需要上传的图片的本地ID，由chooseImage接口获得
        isShowProgressTips: 1, // 默认为1，显示进度提示
        success: function (res) {
            var serverId = res.serverId; // 返回图片的服务器端ID
            afterUploadImg(serverId);
        },
        fail: function (res) {
            alert(JSON.stringify(res));
        }
    });
}
function afterUploadImg(serverId) {
    var url = "index.php?s=Home/Weixin/download_img";
    $.post(url, {media_id: serverId}, function (data, textStatus, xhr) {
        if (data.status) {
            afterdownload(data); //图片上传成功后置操作
            if (localIds.length > 0) {
                uploadImg(localIds);
            }
        } else {
            $.alert('上传失败，请重新上传资料');
        }
    }, 'json').error(function () {
        $.alert('错误的数据')
    });
}

//录音状态
//status 1开始 2结束
var is_recordStart;
function status_of_record(status){
    var $this = $(".detail_dialog .m-tape");
    if(status == 1){
        audiotouch = true;
        $(".detail_dialog .time-bar").html('<em class="record_timimg">0:00</em>');
        $this.addClass('no');
        is_recordStart = setInterval(function(){
            timing_to_record();
        }, 1000);
    }else{
        audiotouch = false;
        record_timimg = 0;
        window.clearInterval(is_recordStart);
        $this.removeClass('no');
    }
}
//录音计时
function timing_to_record(){
    if('undefined' === typeof(record_timimg)){
        record_timimg = 0;
    }
    record_timimg++;
    switch (record_timimg){
        case record_timimg < 60:
            var minute = 0;
            var secord = record_timimg;
            break;
        default :
            var minute = parseInt(record_timimg/60);
            var secord = record_timimg%60;
    }
    var len = (''+secord).length;
    if(len == 1){
        secord = "0"+secord;
    }
    var all_time = minute+':'+secord;
    $(".record_timimg").html(all_time);
}
//上传音频
function uploadAudio(localIds){
    wx.uploadVoice({
        localId: localIds, // 需要上传的音频的本地ID，由stopRecord接口获得
        isShowProgressTips: 1, // 默认为1，显示进度提示
        success: function (res) {
            var serverId = res.serverId; // 返回音频的服务器端ID
            afterUploadAudio(serverId);
        }
    });
}
function afterUploadAudio(serverId){
    var url = "index.php?s=Home/Weixin/download_audio";
    $.post(url, {media_id: serverId}, function (data, textStatus, xhr) {
        if (data.status) {
            afterdownloadAudio(data); //音频上传成功后置操作
        } else {
            $.alert('上传失败，请重新上传资料');
        }
    }, 'json').error(function () {
        $.alert('错误的数据')
    });
}

//获取经纬度
var lat='',lng='',is_getLocation;
var wxlocation = 0;
var locationTime = 0;
function WXgetLocation(){
    if(lat == '' || lng == ''){
        wx.ready(function (){
            //获取用户经纬度坐标
            wx.getLocation({
                type: 'gcj02', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
                success: function (res) {
                    /*var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
                     var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
                     var speed = res.speed; // 速度，以米/每秒计
                     var accuracy = res.accuracy; // 位置精度*/
                    lat = res.latitude;
                    lng = res.longitude;
                    /*var prefix = "{:C('COOKIE_PREFIX')}";
                    Cookies.set(prefix+'lng', res.longitude);
                    Cookies.set(prefix+'lat', res.latitude);
                    location.href = "{$current_url}";*/
                    wxlocation = 1;
                },
                cancel: function () {
                    wxlocation = 2;
                    $.alert('用户拒绝授权获取地理位置');
                }
            })
        })
    }
}
//加载页面后先获取位置信息
function getLocationFirst(){
    $.showLoading('定位中...');
    WXgetLocation();
    //wxlocation = 1;lat='32.13188';lng='119.43396'; //测试数据
    //wxlocation = 1;lat='26.089793';lng='119.32191'; //测试数据,
    is_getLocation = setInterval(function(){
        if(locationTime == 5){
            $.hideLoading();
            window.clearInterval(is_getLocation);
            $.alert('定位失败');
        }
        locationTime ++;
        switch(wxlocation){
            case 1:
                afterGetLocation();
                $.hideLoading();
                window.clearInterval(is_getLocation);
                break;
            case 2:
                $.hideLoading();
                window.clearInterval(is_getLocation);
                break;
            default:
        }
    }, 1000);
}