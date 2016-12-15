var unit = 1; // 0：元，1：角，2：分
var default_time = 1; // 默认原始倍率
var random_time = 60; // 随机时间 秒
var bet_after_time = 1; // 3分钟
var repeat_interval = 5; // 10分钟开一次

var code_all = []; // 所有历史中奖信息
var current_time = default_time; // 当前倍率
var bet_last = {}; // 上次投注
var is_bet_again = false; // 是否失败后的再投注状态
var again_count = 0; // 复投次数
var again_times = [1, 3, 11, 41, 25, 60, 150]; // 超级概率的倍数
var recommend = ""; // 推荐号码
var is_stop = true;

//var end = new Date("2016-09-30 01:50:00");

/**
 * send dingtalk message
 * @param msgs object
 */
function sendDing(msgs) {
    console.log("++++++>send message...");
    if (msgs == null || msgs == {} || msgs == "") {
        return false;
    }
    var _msg = "";
    if (typeof(msgs) == "string") {
        _msg = msgs;
    } else {
        for (var _k in msgs) {
            _msg += _k + ": " + msgs[_k] + "; \n";
        }
    }
    console.log("msg: " +_msg);
    $.ajax(
        {
            type: 'get', url: 'http://blog.robbie.im/admin/ding/sendMsg',
            dataType: 'jsonp', data: {msg: _msg}, jsonp: "callback",
            success: function (data) {
                console.log(data);
            }
        }
    );
}

/**
 * send bet
 * @param code array
 */
function sendBet(code, current_time, unit, code_all) {
    if (!(code instanceof Array) || code.length < 5) {
        return false;
    }
    // 如果是7位的号码，不翻倍
    // if (code.length == 7)
    // current_time = default_time;
    for (var i in code) {
        $('.button-circle')[40 + parseInt(code[i])].click();
    }
    // select unit 0:yuan 1:jiao 2:fen
    $("select.unit").find("option:eq(" + unit + ")").attr("selected", true);
    // times
    $("input.times").val(current_time);
    // add code to list
    $("button.add-code").click();
    // confirm
    $("button.confirm-submit").click();
    // cost money
    var cost = Number($("div.modal-body tr.success").find("td:eq(3)").text());
    // gift money
    var gift = Number($("div.modal-body tr.success").find("td:eq(6)").text());

    // submit
    $("button.bet-submit").click();
    //$(".modal-footer > .btn-default").click(); // 关闭

    var bet_new = {code: code, cost: cost, gift: gift, time: current_time, unit: unit};
    var msg = {
        "已投注": $("span.current-period:eq(0)").text() + "， 投注金额：" + bet_new.cost + "， 奖金金额：" + bet_new.gift,
        "倍率": current_time,
        "单位": ['元', '角', '分'][unit],
        "号码": bet_new.code.join(", "),
        "历史号码": code_all.join(", "),
        "当前余额": $(".balance-gross").text(),
        "距截止时间": $(".current-period-time-left").text(),
        "投注时间": (new Date()).toLocaleString()
    };

    sendDing(msg); // 发钉钉消息
    return bet_new;
}

function isEvenAll(numArr, count) {
    var _is_even = true;
    for (var i = 0; i < count; i++) {
        _is_even = _is_even && (numArr[i] % 2 == 0);
    }
    return _is_even;
}
function isOddAll(numArr, count) {
    var _is_odd = true;
    for (var i = 0; i < count; i++) {
        _is_odd = _is_odd && (numArr[i] % 2 == 1);
    }
    return _is_odd;
}

function isLessAll(number, compareNum, count) {
    var _is_less = true;
    for (var i = 0; i < count; i++) {
        _is_less = _is_less && (number[i] < compareNum);
    }
    return _is_less;
}
function isMoreAll(number, compareNum, count) {
    var _is_more = true;
    for (var i = 0; i < count; i++) {
        _is_more = _is_more && (number[i] > compareNum);
    }
    return _is_more;
}

/**
 * bet policy
 */
function bet_policy(code, recommend) {

    if (!(code instanceof Array) || code.length < 5) {
        return {};
    }

    var _code = null;
    var _is_super = false;
    var _msg = "";

    // 4. 下个投注新策略
    if (typeof(recommend) == "string") {
        recommend = recommend.split("");
        var _recommend = [];
        for (var i in recommend) {
            _recommend.push(parseInt(recommend[i]));
        }
        recommend = _recommend;
    }
    if (recommend.length >= 5) {
        _code = recommend;
        _is_super = false;
        _msg = "自定义号码: " + recommend.join(", "); //自定义号码

        // 4.1. 如果连续6个偶数，下个投1，3，5，7，9    -----10倍
    } else if (isEvenAll(code, 6)) {
        _code = [1, 3, 5, 7, 9];
        _is_super = false; // super times
        _msg = "超级概率，连续6个偶数:  " + code.join(", ") + "\n";

        // 4.2. 如果连续6个奇数，下个投2，4，6，8，0    -----10倍
    } else if (isOddAll(code, 6)) {
        _code = [0, 2, 4, 6, 8];
        _is_super = true;
        _msg = "超级概率，连续6个奇数:  " + code.join(", ") + "\n";

        // 4.3. 如果连续6个<5, 下个投5，6，7，8，9    -----10倍
    } else if (isLessAll(code, 5, 6)) {
        _code = [5, 6, 7, 8, 9];
        _is_super = true;
        _msg = "超级概率，连续6个小： " + code.join(", ") + "\n";

        // 4.4. 如果连续6个>=5, 下个投0，1，2，3，4    -----10倍
    } else if (isMoreAll(code, 4, 6)) {
        _code = [0, 1, 2, 3, 4];
        _is_super = true;
        _msg = "超级概率，连续6个大： " + code.join(", ") + "\n";

        // 4.5. 投除了最近3个数以外的所有数
    } else {
        var code_09 = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
        var _old= [parseInt(code[0]), parseInt(code[1]), parseInt(code[2])];
        for (var idx in _old) {
            if (code_09.indexOf(_old[idx]) != -1) {
                code_09.splice(code_09.indexOf(_old[idx]), 1);
            }
        }
        if (code_09.length == 7) {
            _msg = "普通概率，去前三";
            _code = code_09;
        } else {
            _code = [];
            _msg = "重复号，本次不投！";
        }

        _is_super = false;
    }

    return {code: _code, msg: _msg, is_super: _is_super};
}

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

/**
 * 检查投注或中奖状态
 */
function checkStatus() {
    // 3.1 如果上次有投注
    if (bet_last.code) {

        // 如果中奖，输出中奖信息
        if (bet_last.code.indexOf(code_all[0]) != -1) {
            console.log("************** congratulations **************");
            console.log("++++++>中奖金额：" + bet_last.gift + " - " + bet_last.cost);
            var msg = {
                "恭喜您，中奖金额": bet_last.gift + "元",
                "中奖号码": code_all[0] + " <-- " + bet_last.code.join(", "),
                "期　　号": $("span.past-period").text(),
                "当前余额": $(".balance-gross").text()
            };

            sendDing(msg);
            current_time = default_time; // 如果中奖，倍率改为默认倍率；
            again_count = 0; // 复投次数归0
            is_bet_again = false;
            bet_last = {};
            recommend = "";
        } else { // 没中奖怎么办
            // 按设定好的比例递增
            is_bet_again = true; // 再投注
            current_time = again_times[++again_count];
            msg =  "很遗憾没有中奖，计划倍投中，号码：" + code_all[0] + " <---" + bet_last.code.join(", ");
            console.log(msg.toString());
            //sendDing(msg);
        }
    } else {
        console.log("************** 上期没有投注 **************")
    }

    console.log("当前倍率： " + current_time + "，   原始倍率： " + default_time);
    console.log("当前单位： " + (['元', '角', '分'][unit]));
    console.log("是否复投： " + is_bet_again + "，   复投次数： " + again_count);
    console.log("当前余额： " + $(".balance-gross").text());
    console.log("自定义号码： " + recommend);
}

/**
 * 下注
 */
function makePolicyAndBet() {

    if (is_stop) {
        console.log("************** 手动暂停中... **************");
        return false;
    }
    var bet_new = {};

    // 翻倍的倍数太多自动回到默认
    if (is_bet_again && again_count > 4) {
        console.log("************** 风险过大，关闭复投 **************");
        console.log("当前倍率： " + current_time);
        current_time = default_time;
        again_count = 0;
        is_bet_again = false; // 再投注
    }
    // 新策略
    bet_last = {}; // 先清空投注数据
    var policy = bet_policy(code_all, recommend); // get policy
    console.log(policy.msg + "\n" + code_all.join(", "));
    if (!policy.is_super && policy.code) {
        bet_new = sendBet(policy.code, current_time, unit, code_all);
    }

    if (bet_new.code)
        bet_last = bet_new; // 保存投注号码
}

function stop() {
    is_stop = true;
    current_time = 1;
    is_bet_again = false;
    again_count = 0;
    console.log("************** 已暂停自动投注... **************");
}

function start() {
    is_stop = false;
    current_time = 1;
    console.log("************** 已启动自动投注... **************");
}