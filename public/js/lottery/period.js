/**
 * Created by zhangkx on 2016/10/5.
 */

/**
 * 日期格式化
 * @param fmt
 * @returns {*}
 */
Date.prototype.format = function (fmt) {
    var o = {
        "M+": this.getMonth() + 1, //月份
        "d+": this.getDate(),      //日
        "h+": this.getHours(),     //小时
        "m+": this.getMinutes(),   //分
        "s+": this.getSeconds(),   //秒
        "q+": Math.floor((this.getMonth() + 3) / 3), //季度
        "S": this.getMilliseconds() //毫秒
    };
    if (/(y+)/.test(fmt))
        fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
    for (var k in o)
        if (new RegExp("(" + k + ")").test(fmt))
            fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
    return fmt;
};

/**
 * 获取最近一次中奖号码
 * @returns {}
 */
function getLastCode() {
    var li = $(".recent-lottery").find("li:eq(0)");
    var date = (new Date()).format('yyyy-MM-dd');
    var period = li.find("p").text().replace(/[第\-期]/g, "");
    var code_all = [];
    for (var i = 0; i < 5; i++) {
        code_all.push(parseInt(li.find("i:eq(" + i + ")").text()));
    }
    return {date: date, period: period, code: code_all};
}

/**
 * 发送code到服务器
 * @param _codes
 */
function sendLotteryCode(_codes) {
    $.ajax(
        {
            type: 'get', url: 'http://blog.robbie.im/admin/lottery/sendCode',
            dataType: 'jsonp', data: {data: _codes}, jsonp: "callback",
            success: function (data) {
                console.log(data.msg);
            }, timeout:3000
        }
    );
}
sendLotteryCode([getLastCode()]);



if (last) {
    console.log(last);
    clearInterval(last);
}
var last = setInterval(function () {
    sendLotteryCode([getLastCode()]);
}, 1000 * 60 * 10);
console.log(last);











/**
 * 发送code到服务器
 * @param _codes
 */
function sendLotteryCode(_codes) {
    $.ajax(
        {
            type: 'get', url: 'http://blog.robbie.im/admin/lottery/sendCode',
            dataType: 'jsonp', data: {data: _codes}, jsonp: "callback",
            success: function (data) {
                console.log(data.msg);
            }, timeout:3000
        }
    );
}

/**
 * 从页面读取数据并发送到服务器
 * @returns {boolean}
 */
function send() {
    var codes = [];
    var count = 0;
    $("table#draw_list > tbody > tr").each(function () {
        var code = [];
        $(this).find(".td3 .ball_1").each(function() {
            code.push(parseInt($(this).text()));
        });
        codes.push({
            date: $(this).find(".td1").text().trim(),
            period: $(this).find(".td2").text().trim(),
            code: code
        });
        count++;

        // 30调发送一次数据
        if (count == 30) {
            console.log("++++> 发送数据 " + codes.length + " 条");
            sendLotteryCode(codes);
            count = 0;
            codes = [];
        }
    });
    // 如果剩下还有数据，继续发送
    if (codes.length > 0) {
        console.log("++++> 发送数据 " + codes.length + " 条");
        sendLotteryCode(codes);
        count = 0;
        codes = [];
    }
    console.log("++++> 发送完毕！");
    return true;
}
send();