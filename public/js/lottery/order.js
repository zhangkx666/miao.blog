/**
 * Created by zhangkx on 2016/10/5.
 */

if (idx) {
    console.log(idx);
    clearInterval(idx);
}
var idx = setInterval(function () {
    console.log("++++++++++++++++++++++++ start ++++++++++++++++++++++++");

    var _m = parseInt(Math.random() * random_time); // 随机提交时间，显得没有那么有规律

    // 1. 获取页面上历史中奖信息, 保存所有历史中奖信息
    code_all = [];
    $(".recent-lottery").find("li").each(function () {
        code_all.push(parseInt($(this).find("i:eq(4)").text()));
    });
    console.log(code_all);

    // 2. 发送号码到服务器保存
    sendLotteryCode([getLastCode()]);

    // 3. 检查上次投注中奖状态
    checkStatus();

    // 4. 两分钟后投注
    setTimeout(function () {
        makePolicyAndBet();
    }, (1000 * 60 * bet_after_time) + _m * 1000); // 秒

    console.log("+++++++++++++++++++++++++ end +++++++++++++++++++++++++");
}, 1000 * 60 * repeat_interval);

console.log(idx);
