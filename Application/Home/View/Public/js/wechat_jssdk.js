//PC扫描，开发代用
function wxsdk_scanpc()
    {
        var result = 'EAN_13,6924262730885';
        // var result = 'EAN_13,';
        // var result = 'www.baidu.com';
        $('#code').val(result);
        wxsdk_scanreturn(result,'in');
    }

function wxsdk_scan()//扫码
{
    wx.scanQRCode(
    {
        needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
        scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
        success: function (res)
        {
            var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
            wxsdk_scanreturn(result);//去处理
            return false;

        }
    });
}

function wxsdk_scanreturn(barcode,scantype='in')
{
    var type = scantype;//in 入库，out 出库
    var arrbarcode = barcode.split(',');//分割数组
    // console.log(arrbarcode);
    // console.log(arrbarcode.length);
    if (arrbarcode.length==2)//条形码，去处理
    {
        if (arrbarcode[1] == "" || arrbarcode[1] == null)//未扫描出结果，则去重新扫描
        {
            $.alert('没有扫描到');
            wxsdk_scan(scantype);//重新发起扫描
        }
        else
        {
            var $form = $('#scanbarcode_submit');
            $('#barcode').val(arrbarcode[1]);
            // $.alert($form.serialize());
            $.post($form.attr('action'), $form.serialize());
        }
        
    }
    else
    {

        $.alert('二维码暂不支持扫描');//二维码不处理
        exit;
    }
}

