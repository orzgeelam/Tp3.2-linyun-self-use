/**
 * Created by Administrator on 2017/8/23.
 */
/*
* bMap
*/
//初始化百度地图引擎，本接口仅支持 iOS 平台，android平台不需要初始化
function bMap_initMapSDK(){
    var map = api.require('bMap');
    map.initMapSDK(function(ret, err) {
        if (ret.status) {
            alert('地图初始化成功，可以从百度地图服务器检索信息了！');
        }else{
            var errMsg = {
                '-300':'链接服务器错误',
                '-200':'服务返回数据异常',
                '0':'授权验证通过',
                '101':'ak不存在',
                '102':'mcode签名值不正确',
                '200':'APP不存在，AK有误请检查再重试',
                '201':'APP被用户自己禁用，请在控制台解禁'
                //更多错误码参考：http://lbsyun.baidu.com/index.php?title=lbscloud/api/appendix
            };
            alert(errMsg.err);
        }
    });
}

//开始定位，若要支持后台定位需配置 config.xml 文件 location 字段，无需调用 open 接口即可定位。在 android 平台上，离线定位功能需要手动打开GPS，并在无遮挡物的室外
/*
 ret：
 status: true,               //布尔型；true||false
 lon: 116.213,               //数字类型；经度
 lat: 39.213,                //数字类型；纬度
 accuracy: 65,               //数字类型；本次定位的精度，仅支持 iOS 平台
 timestamp: 1396068155591,    //数字类型；时间戳
 locationType:netWork        //字符串；定位类型；GPS||NetWork||OffLine(仅限Android)
 err：
 code: 0,         //数字类型；错误码
 msg: ''          //字符串类型；错误信息说明
 */
function bMap_getLocation(accuracy){
    var bMap = api.require('bMap');
    accuracy = typeof accuracy == 'undefined' ? '10m':accuracy;
    bMap.getLocation({
        accuracy: accuracy, //（可选项）定位精度：10m、100m、1km、3km
        autoStop: true,    //（可选项）获取到位置信息后是否自动停止定位:true|false
        filter: 1           //（可选项）位置更新所需的最小距离（单位米），autoStop 为 true 时，此参数有效
    }, function(ret, err) {
        if (ret.status) {
            alert(JSON.stringify(ret));
        } else {
            alert(err.code);
        }
    });
}

//app微信
function openWXPay(wxconfig,url){
    var wxPay = api.require('wxPay');
    wxPay.payOrder({
        apiKey: wxconfig.appid,
        orderId: wxconfig.prepayid,
        mchId: wxconfig.partnerid,
        nonceStr: wxconfig.noncestr,
        timeStamp: wxconfig.timestamp,
        sign: wxconfig.sign
    }, function(ret, err) {
        if (ret.status) {
            //支付成功
            window.location.href = url;
        } else {
            if (err.code == -2) {
                $.toptip('已取消支付');
            } else {
                $.toptip('未知错误');
            }
        }
    });
}

//支付宝
function openAliPay(tradeNO , amount, url) {
    var obj = api.require('aliPay');
    var subject = "美乐";
    var body = subject + tradeNO;
    obj.pay({
        subject: subject,
        body: body,
        amount: amount,
        tradeNO: tradeNO
    }, function(ret, err) {
        if(ret.code == '9000'){
            window.location.href = url;
        } else {
            $.toptip('支付失败');
        }
    });
}

//FNScanner
//打开二维码/条码扫描器
function FNscanner_openScanner(){
    var FNScanner = api.require('FNScanner');
    FNScanner.openView({
        autorotation: true
    }, function(ret, err) {
        if (ret) {
            alert(JSON.stringify(ret));
        } else {
            alert(JSON.stringify(err));
        }
    });
}

//打开可自定义的二维码/条形码扫描器
function FNscanner_openView(){
    var FNScanner = api.require('FNScanner');
    FNScanner.openView({
        autorotation: true
    }, function(ret, err) {
        if (ret) {
            alert(JSON.stringify(ret));
        } else {
            alert(JSON.stringify(err));
        }
    });
}