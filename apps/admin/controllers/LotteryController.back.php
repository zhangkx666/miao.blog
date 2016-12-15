<?php

namespace Miao\Admin\Controllers;

use Miao\Common\Models\Bet;
use Miao\Common\Models\BetHistory;
use Miao\Common\Models\Conster;
use Miao\Common\Models\Lottery;
use Phalcon\Acl\Exception;

class LotteryController extends BaseController
{
    /**
     * 组六
     */
    public function groupsixAction()
    {
        // 前三组六
        $is_before = isset($_GET['is_before']) && $_GET['is_before'] == '1';

        // 查询历史记录数据量
        $limit = 120 * 3;

        // 统计的最小连续次数
        $time_min = 1;

        // 统计的最大连续次数
        $time_max = 10;

        // 倍投倍率
        $bet_times = [1, 4, 15, 60, 240, 960, 3840, 15360];

        // 赔率
        $odds = 320;

        // 查询号码记录
        $lotteries = Lottery::find(['order' => 'period desc', 'limit' => $limit]); // "date between '2016-10-01' and '2016-10-30'",

        // 统计数据
        $count = ['leopard' => 0, 'group_three' => 0, 'group_six' => 0]; // 统计
        $counter = 0;
        $total = [];
        $total['money'] = 0; // 中金额，钱钱
        for ($time = $time_min; $time <= $time_max; $time++) {  // 4-9 连续
            $total['time'][$time] = 0; // 按次数统计
            $total['total'] = 0; // 按次数统计
        }

        // 循环去处理数据
        $data = [];
        for ($i = 0; $i < count($lotteries); $i++) {
            $lottery = $lotteries[$i];
            $group = null;
            $group_before1 = [];
            $group_before2 = [];
            $group_before3 = [];
            if ($is_before) {// 前三组六
                $group = array_unique([$lottery->code1, $lottery->code2, $lottery->code3]);
                if ($i < count($lotteries) - 3) {
                    $group_before1 = array_unique([$lotteries[$i + 1]->code1, $lotteries[$i + 1]->code2, $lotteries[$i + 1]->code3]);
                    $group_before2 = array_unique([$lotteries[$i + 2]->code1, $lotteries[$i + 2]->code2, $lotteries[$i + 2]->code3]);
                    $group_before3 = array_unique([$lotteries[$i + 3]->code1, $lotteries[$i + 3]->code2, $lotteries[$i + 3]->code3]);
                }
            } else { // 后三组六
                $group = array_unique([$lottery->code3, $lottery->code4, $lottery->code5]);
                if ($i < count($lotteries) - 3) {
                    $group_before1 = array_unique([$lotteries[$i + 1]->code3, $lotteries[$i + 1]->code4, $lotteries[$i + 1]->code5]);
                    $group_before2 = array_unique([$lotteries[$i + 2]->code3, $lotteries[$i + 2]->code4, $lotteries[$i + 2]->code5]);
                    $group_before3 = array_unique([$lotteries[$i + 3]->code3, $lotteries[$i + 3]->code4, $lotteries[$i + 3]->code5]);
                }
            }

            // 计算号码类型
            $group_count = count($group);
            $is_leopard = false;
            $is_group_three = false;
            $is_group_six = false;
            if ($group_count == 1) {
                $is_leopard = true; // 豹子
                $count['leopard']++;
                $counter++;
            } else if ($group_count == 2) {
                $is_group_three = true;  // 组三
                $count['group_three']++;
                $counter++;
            } else {
                $is_group_six = true;  // 组六
                $count['group_six']++;
                $counter = 0;
            }

            // 计算钱钱
            $money = 0;
            if ($i < count($lotteries) - 3) { // 最后3个号码忽略掉
                // 去除3个数字，投注金额为70元
                $group_compare = [0, 1, 2];
                $moneys = [240, 168, 112, 70, 40, 20];
                $money_cost = $moneys[count(array_unique($group_compare))];

                $group_before1_count = count($group_before1); // 前一个号码的情况
                $group_before2_count = count($group_before2); // 前一个号码的情况
                $group_before3_count = count($group_before3); // 前一个号码的情况

                // 对比计算钱钱
                $money_gift = 320 - $money_cost;
                if ($group_count == 3) { // 组六

                    // 如果前1-2个号码是组三或者豹子。那么本次为0
                    if ($group_before1_count < 3 || $group_before2_count < 3) {
                        $money = 0;

                        // 如果比价号码位数不足3位不投注
                    } else if (count(array_unique($group_compare)) < count($group_compare)) {
                        $money = 0;

                        // 如果前一个号码之前的号码跟本次号码有重复。金额为 -70
                    } else if (array_intersect($group, $group_compare)) {
                        $money = -$money_cost;
                    } else {
                        $money = $money_gift;
                    }
                } else {
                    if ($group_before1_count < 3 || $group_before2_count < 3) {
                        $money = 0;
                    } else {
                        $money = -$money_cost;
                    }
                }
            } else {
                $money = 0;
            }
            $total['money'] += $money;

            // 色块数据
            $data[] = [
                'lottery' => $lottery,
                'is_leopard' => $is_leopard,
                'is_group_three' => $is_group_three,
                'is_group_six' => $is_group_six,
                'color' => $is_leopard ? 'pink' : ($is_group_three ? 'warning' : 'default'),
                'money' => $money
            ];

            // 统计连续次数和概率
            for ($time = $time_min; $time <= $time_max; $time++) {
                if ($counter == $time) {

                    $total['time'][$time]++; // 统计次数 +1
                    $total['total']++;
                    // 如果是比最小连续数字 4 大的，
                    if ($time > $time_min) {
                        // 那么在加大同时，前边的一个要 -1
                        $total['time'][$time - 1]--; // 统计次数 +1
                        $total['total']--;
                    }
                }
            }
        }

        // 计算胜率
        for ($time = $time_min; $time <= $time_max; $time++) {
            $total['rate'][$time] = ($total['time'][$time] / $total['total']) * 100;

            // 如果是大于起始连续数量的，要加上之前的概率
            if ($time > $time_min)
                $total['rate'][$time] += $total['rate'][$time - 1];
        }

        $this->view->data = $data;
        $this->view->count = $count;
        $this->view->is_before = $is_before;
        $this->view->time_min = $time_min;
        $this->view->time_max = $time_max;
        $this->view->total = $total;
        $this->view->limit = $limit;

        // 倍率策略
        $this->view->bet_times = $this->getBetTimes($bet_times, 0, $odds);
    }

    /**
     * 主要投注策略
     */
    public function threeAction()
    {
        // 去除code数量
        $wipe = $_GET['wipe'] ? (int)$_GET['wipe'] : 3;

        // 查询历史记录数据量
        $limit = $_GET['limit'] ? (int)$_GET['limit'] : 100;

        // 延迟期数
        $offset = 0;

//        $bet_times = [1, 2, 4, 8, 15, 30, 55, 100, 200, 400, 800];
//        $bet_times = [5, 15, 45, 100, 200, 80, 140, 48, 90, 160, 400, 800];
//        $bet_times = [0.1, 0.2, 0.4, 0.6, 1, 1.8, 3.2, 5.6]; // 柳儿专用倍率
//        $bet_times = [0.5, 1, 2, 4, 6, 10, 18, 32, 56];
//        $bet_times = [1, 10, 30];
        $bet_times = [1, 4, 15];
        $bet_times = [1, 3, 10];

        // 5码
//        $bet_times = [1, 2, 5, 10, 22, 50, 100, 200, 500];

        // 3码
//        $bet_times = [1, 2, 3, 4, 6, 8, 12, 17, 25, 36, 53];


        // 2码
//        $bet_times = [5, 6, 7, 9, 11, 14, 18, 23, 28, 36, 45, 56, 70];

        // 6码
//        $bet_times = [10, 25, 70];

        $bet_times = [0.2, 0.4, 0.8, 1.5, 3, 5.2, 9, 16, 28, 48, 82, 140, 240]; // 柳儿专用倍率




        // 赔率
        $odds = 19.2;

        // 统计的最小连续次数
        $time_min = 0;

        // 统计的最大连续次数
        $time_max = 15;

        // 查看的code
        $code = 5;

        $code_count = $_GET['code_count'] ? (int)$_GET['code_count'] : 5;

        // 查询号码记录
        $lotteries = Lottery::find(['order' => 'period desc', 'limit' => $limit]);

        // 初始化统计数据
        $data = [];
        $count = ['success' => 0, 'failed' => 0, 'ignore' => 0]; // success: 成功 failed: 失败 ignore：未投注
        $total = [];
        foreach (range($time_min, $time_max) as $time) {
            $total['time'][$time] = 0;
        }

        // 获取到号码出现次数和遗漏数据的多为数组
        $codes = $this->getPolicyCodes($limit, $offset);

        // 取号码
        $last = array_slice(array_column($codes, 'code'), 0, $code_count);
//        $last = [1, 2, 3, 4, 5, 6];
        $last = [0, 2, 3, 7, 9];



        $wipe = 10 - count($last);
        $counter = 0;
        for ($i = 0; $i < count($lotteries); $i++) {

            // 默认color为success
            $color = 'success';

            if (in_array($lotteries[$i]->attr('code' . $code), $last)) {
                $count['success']++;
                $counter = 0;// 未中次数=0
            } else {
                $color = 'danger';
                $count['failed']++;
                $counter++; // 未中次数+1
            }

            // 统计重复不中次数
            if ($color != 'default') {
                foreach (range($time_min, $time_max) as $time) {
                    if ($counter == $time) {
                        $total['time'][$time]++;
                        $total['total']++;
                        if ($time > 1) {
                            $total['time'][$time - 1]--;
                            $total['total']--;
                        }
                    }
                }
            }

            $data[] = ['lottery' => $lotteries[$i], 'color' => $color];
        }

        // 计算胜率
        for ($time = $time_min; $time <= $time_max; $time++) {
            $total['rate'][$time] = ($total['time'][$time] / $total['total']) * 100;

            // 如果是大于起始连续数量的，要加上之前的概率
            if ($time > $time_min)
                $total['rate'][$time] += $total['rate'][$time - 1];
        }

        $this->view->data = $data;
        $this->view->count = $count;
        $this->view->wipe = $wipe;
        $this->view->total = $total;
        $this->view->limit = $limit;
        $this->view->time_min = $time_min;
        $this->view->time_max = $time_max;
        $this->view->bet_times = $this->getBetTimes($bet_times, $wipe, $odds); // 倍率策略
        $this->view->code = $code;
        $this->view->code_total = $codes;
        $this->view->policy_codes = implode('', $last);
        $this->view->code_count = $code_count;

//        $this->view->disable();
//        echo $this->response->setJsonContent($bet_arr)->getContent();

        if ($_GET['is_mobile']) {
            $this->useBlankTpl();
        }
        $this->view->is_mobile = $_GET['is_mobile'];
    }

    public function sevenAction()
    {
        $limit = $_GET['limit'] ? $_GET['limit'] : 60;
        $code_count = $_GET['code_count'] ? $_GET['code_count'] : 7;

        $bet_histories = BetHistory::find(["data_limit = $limit and code_count = $code_count", 'order' => 'period asc']);

        $this->view->bet_histories = $bet_histories;
        $this->view->limit = $limit;
        $this->view->code_count = $code_count;
    }

    /**
     * 返回投注号码
     */
    public function getLocalPolicyAction()
    {
        try {
            // 读取策略文件
            $file_lines = file('X:/lottery.txt');
            preg_match("/.*【(\\d+)】(\\d+).*/", $file_lines[6], $matchs);

//            $bet_times = [4, 8, 15, 30, 52, 90, 160, 280, 480, 820, 1400, 2400];
            $bet_times = [5, 10, 20, 50, 100, 200, 500, 1000, 2400];
            $unit = 1;

            // 日期和投注期数
            $date = date('Ymd', time());
            $period = $date . '-' . $matchs[2];
            $codes = $matchs[1];
            $codes = '02379';

            // 如果没有投注过，才投注。
            if (Bet::count(["period = '$period'"]) == 0) {
                // 保存到数据库
                $bet = new Bet();
                $bet->date = $date;
                $bet->codes = $codes;
                $bet->period = $period;
                $bet->save();

                // 返回json
                $this->renderJson([
                    'status' => Conster::AJAX_SUCCESS,
                    'codes' => $codes,
                    'period' => $period,
                    'bet_times' => $bet_times,
                    'unit' => $unit
                ]);
            } else {
                $this->renderJson([
                    'status' => Conster::AJAX_FAILED,
                    'codes' => $codes,
                    'period' => $period,
                    'bet_times' => $bet_times,
                    'unit' => $unit,
                    'msg' => 'current period exists'
                ]);
            }
        } catch (Exception $e) {
            $this->renderJson(['status' => Conster::AJAX_FAILED]);
        }
    }

    public function makeBetAction()
    {
        $limit = $_GET['limit'] ? $_GET['limit'] : 40;;
        $code_count = $_GET['code_count'] ? $_GET['code_count'] : 7;
        for ($i = 480; $i < 480 * 2; $i++) {
            $win_bet = Lottery::findFirst(['order' => 'period desc', 'offset' => $i]);
            $bet_codes = $this->getPolicyBetCodes($limit, $i + 1, $code_count);

            $bet_history = new BetHistory();
            $bet_history->date = $win_bet->date;
            $bet_history->period = $win_bet->period;
            $bet_history->bet_code = implode('', $bet_codes);
            $bet_history->win_code = $win_bet->code5;
            $bet_history->code_count = $code_count;
            $bet_history->data_limit = $limit;
            $bet_history->is_win = in_array($win_bet->code5, $bet_codes) ? 1 : 0;
            $bet_history->save();
        }

        $this->renderJson(['status' => Conster::AJAX_SUCCESS, 'code' => $code_count]);
    }

    /**
     * 获取投注号码
     */
    public function getPolicyCodesAction()
    {
        // 先保存上次的数据
        $this->saveLastCode($_POST['data']);

        // 参考数据条数。默认100条
        $limit = $_GET['limit'] ? (int)$_GET['limit'] : 30;

        // 偏移量 默认0
        $offset = $_GET['offset'] ? (int)$_GET['offset'] : 0;

        // 策略号码个数
        $code_count = $_GET['code_count'] ? (int)$_GET['code_count'] : 7;

        // 获取到号码出现次数和遗漏数据的多为数组
        $codes = $this->getPolicyCodes($limit, $offset);

        // 取号码
        $output_codes = array_slice(array_column($codes, 'code'), 0, $code_count);

        // 返回结果$codes
        $this->renderJson(['status' => Conster::AJAX_SUCCESS, 'limit' => $limit, 'codes' => implode('', $output_codes)]);
    }

    /**
     * 概率数据显示
     */
    public function alwaysAction()
    {
        // 查询历史记录数据量
        $limit = 120 * 30;

        // 统计的最小连续次数
        $time_min = 6;

        // 统计的最大连续次数
        $time_max = 20;

        // 赔率
        $odds = 19.2;

        // 倍投倍率
        $bet_times = [1, 2.2, 5, 11, 25, 60, 130, 260, 436, 1000];

        // 策略类型
        $policy_types = ['small', 'big', 'odd', 'even'];

        // 查看的号码
        $codes = [1, 2, 3, 4, 5];

        $lotteries = Lottery::find(['order' => 'period desc', 'limit' => $limit]);

        // 开始伟大的策略
        $counters = []; // 计数器  $counter[5]['small']
        $counts = [];   // 统计　  $count[5]['small'][6]
        $total = [];    // 总计
        $total['total'] = 0; // 总次数

        foreach ($codes as $code) {
            $total['code'][$code] = 0; // code总计

            foreach ($policy_types as $type) {
                $counters[$code][$type] = 0; // 计数器初始化 =0
                $total['code_type'][$code][$type] = 0; // 按分类统计

                $counts[$code][$type] = [];  // 统计数据初始化 =0
                for ($time = $time_min; $time <= $time_max; $time++) {  // 4-9 连续
                    $counts[$code][$type][$time] = 0;
                    $total['time'][$time] = 0; // 按次数统计
                    $total['code_time'][$code][$time] = 0; // 按code和次数统计
                    $total['rate'][$time] = 0;
                }
            }
        }

        // 开始统计
        for ($i = 0; $i < count($lotteries); $i++) {
            $lottery = $lotteries[$i];
            foreach ($codes as $code) {
                // 大小 规则
                if ($lottery->attr("code$code") < 5) {
                    $counters[$code]['small']++;
                    $counters[$code]['big'] = 0;
                } else {
                    $counters[$code]['small'] = 0;
                    $counters[$code]['big']++;
                }

                // 奇偶 规则
                if ($lottery->attr("code$code") % 2 == 0) {
                    $counters[$code]['even']++;
                    $counters[$code]['odd'] = 0;
                } else {
                    $counters[$code]['even'] = 0;
                    $counters[$code]['odd']++;
                }

                // 连续 4-9 统计
                foreach ($policy_types as $type) {
                    for ($time = $time_min; $time <= $time_max; $time++) {
                        if ($counters[$code][$type] == $time) {

                            $counts[$code][$type][$time]++; // 统计次数 +1
                            $total['code'][$code]++;
                            $total['time'][$time]++;
                            $total['code_time'][$code][$time]++; // code总计+1
                            $total['code_type'][$code][$type]++;
                            $total['total']++;
                            // 如果是比最小连续数字 4 大的，
                            if ($time > $time_min) {
                                // 那么在加大同时，前边的一个要 -1
                                $counts[$code][$type][$time - 1]--;
                                $total['code'][$code]--;
                                $total['time'][$time - 1]--;
                                $total['code_time'][$code][$time - 1]--;
                                $total['code_type'][$code][$type]--;
                                $total['total']--;
                            }
                        }
                    }
                }
            }
        }

        // 计算胜率
        for ($time = $time_min; $time <= $time_max; $time++) {
            $total['rate'][$time] = ($total['time'][$time] / $total['total']) * 100;

            // 如果是大于起始连续数量的，要加上之前的概率
            if ($time > $time_min)
                $total['rate'][$time] += $total['rate'][$time - 1];

        }

        // 倍投计算
        $bet_arr = [];
        for ($x = 0; $x < count($bet_times); $x++) {
            // 倍率
            $time = $bet_times[$x];
            $cost = 0;
            for ($y = $x; $y >= 0; $y--) {
                $cost += $bet_times[$y] * 10;
            }
            $gift = ($odds * $time) - $cost;
            $bet_arr[$x] = ['time' => $time, 'cost' => $cost, 'gift' => $gift];
        }

        // 数据处理完毕，传到页面显示去
        $this->view->codes = $codes;
        $this->view->types = $policy_types;
        $this->view->counts = $counts;
        $this->view->time_min = $time_min;
        $this->view->time_max = $time_max;
        $this->view->total = $total;
        $this->view->limit = $limit;

        // 倍率策略
        $this->view->bet_times = $bet_arr;
    }

    /**
     * 连续概率观察模式
     */
    public function policyAction()
    {
        // 查询历史记录数据量
        $limit = 360;

        // 开始投注次数
        $start_time = $_GET['start_time'] ? (int)$_GET['start_time'] : 6;

        // 策略类型
        $policy_types = ['small', 'big', 'odd', 'even'];

        $lotteries = Lottery::find(['order' => 'period desc', 'limit' => $limit]);

        $counter = [];
        $total = [];
        $start_periods = [];
        foreach (range(1, 5) as $code) {
            foreach ($policy_types as $type) {
                $counter[$type][$code] = 0;
                $start_periods[$type][$code] = 0;
                $total[$type] = 0;
            }
        }

        $data = [];
        for ($i = 0; $i < count($lotteries); $i++) { // 遍历所有记录
            $lottery = $lotteries[$i];
            $data[$i] = ['lottery' => $lottery];

            foreach (range(1, 5) as $code) { // 所有号码
                // 大小 规则
                if ($lottery->attr("code$code") < 5) {
                    $counter['small'][$code]++;
                    if ($counter['big'][$code] >= $start_time) {
                        $total['big']++;
                    }
                    $counter['big'][$code] = 0;
                    $start_periods['big'][$code] = $i + 1;
                } else {
                    $counter['big'][$code]++;
                    if ($counter['small'][$code] >= $start_time) {
                        $total['small']++;
                    }
                    $counter['small'][$code] = 0;
                    $start_periods['small'][$code] = $i + 1;
                }
                // 奇偶 规则
                if ($lottery->attr("code$code") % 2 == 0) {
                    $counter['even'][$code]++;
                    if ($counter['odd'][$code] >= $start_time) {
                        $total['odd']++;
                    }
                    $counter['odd'][$code] = 0;
                    $start_periods['odd'][$code] = $i + 1;
                } else {
                    $counter['odd'][$code]++;
                    if ($counter['even'][$code] >= $start_time) {
                        $total['even']++;
                    }
                    $counter['even'][$code] = 0;
                    $start_periods['even'][$code] = $i + 1;
                }

                foreach ($policy_types as $type) { // 所有类型
                    $data[$i][$type][$code] = 'default';
                    if ($counter[$type][$code] > $start_time + 4) {
                        for ($x = $i; $x >= $start_periods[$type][$code]; $x--) {  // 之前所有的code
                            $data[$x][$type][$code] = 'inverse';
                        }
                    } else if ($counter[$type][$code] > $start_time + 3) {
                        for ($x = $i; $x >= $start_periods[$type][$code]; $x--) {  // 之前所有的code
                            $data[$x][$type][$code] = 'pink';
                        }
                    } else if ($counter[$type][$code] > $start_time + 2) {
                        for ($x = $i; $x >= $start_periods[$type][$code]; $x--) {  // 之前所有的code
                            $data[$x][$type][$code] = 'danger';
                        }
                    } else if ($counter[$type][$code] > $start_time + 1) {
                        for ($x = $i; $x >= $start_periods[$type][$code]; $x--) {  // 之前所有的code
                            $data[$x][$type][$code] = 'warning';
                        }
                    } else if ($counter[$type][$code] > $start_time) {
                        for ($x = $i; $x >= $start_periods[$type][$code]; $x--) {  // 之前所有的code
                            $data[$x][$type][$code] = 'success';
                        }
                    } else if ($counter[$type][$code] == $start_time) {
                        for ($x = $i; $x >= $start_periods[$type][$code]; $x--) {  // 之前所有的code
                            $data[$x][$type][$code] = 'yellow';
                        }
                    }
                }
            }
        }

        $this->view->data = $data;
        $this->view->policy_types = $policy_types;
        $this->view->limit = $limit;
        $this->view->start_time = $start_time;
        $this->view->total = $total;
    }

    /**
     * 接收传送过来的数据并保存
     * 格式：
     * {data: [{"date":"2016-09-08", "period":"20160908107", "code":["4","0","3","7","6"]}]}
     */
    public function sendLastCodeAction()
    {
        try {
            $count = $this->saveLastCode($_POST['data']); // 保存数据
            $total_count = count($_POST['data']);
            $msg = "++++> 服务器收到 $total_count 条号码数据，保存 $count 条。";
            $this->logger->info($msg);

            // 返回结果
            $this->renderJson(['status' => Conster::AJAX_SUCCESS, 'msg' => 'success: ' . $count]);

        } catch (Exception $e) {
            $this->logger->debug($e->getMessage());
            $this->renderJson(['status' => Conster::AJAX_FAILED, 'msg' => $e->getMessage()]);
        }
    }


    public function sendBetAction()
    {
        $data = $this->request->getPost();
        $this->renderJson(['status' => Conster::AJAX_SUCCESS]);
    }

    public function sendBetHistoryAction()
    {
        $data = $this->request->getPost();
        $this->renderJson(['status' => Conster::AJAX_SUCCESS]);
    }

    public function sendCurrentBetHistoryAction()
    {
        $this->renderJson(['status' => Conster::AJAX_SUCCESS]);
    }


    /**
     * 取号码和遗漏数据
     * @param $limit
     * @param $offset
     * @return array
     */
    private function getPolicyCodes($limit, $offset)
    {
        // 查询数据条数
        $limit = $limit ? $limit : 120;

        // 延迟期数
        $offset = $offset ? $offset : 0;

        // 查询号码
        $lotteries = Lottery::find(['order' => 'period desc', 'limit' => $limit, 'offset' => $offset]);

        // 统计0-9号码在 $limit 条数据中出现的次数
        $code_all = [];
        for ($i = 0; $i < count($lotteries); $i++) {
            $code_all[] = $lotteries[$i]->attr('code5');
        }
        $code_counter = array_count_values($code_all);

        // 加入遗漏的数据来进行排序
        $miss_codes = $this->getMissCodes($limit, $offset);
        $codes = [];
        foreach (range(0, 9) as $num) {
            $codes["_$num"] = ['code' => $num, 'count' => $code_counter[$num], 'miss' => $miss_codes[$num]];
        }

        // 牛逼的多字段排序
        $count = [];
        $miss = [];
        foreach ($codes as $key => $value) {
            $count[$key] = $value['count'];
            $miss[$key] = $value['miss'];
        }
        array_multisort($count, SORT_DESC, $miss, SORT_ASC, $codes);
//        array_multisort($miss, SORT_ASC, $codes);
        return $codes;
    }

    /**
     * 获取投注号码
     * @param $limit
     * @param $offset
     * @param $code_count
     * @return array
     */
    private function getPolicyBetCodes($limit, $offset, $code_count)
    {
        $codes = $this->getPolicyCodes($limit, $offset);
        return array_slice(array_column($codes, 'code'), 0, $code_count);
    }

    /**
     * @param $limit
     * @param $offset
     * @return array 获取遗漏数据
     */
    private function getMissCodes($limit, $offset)
    {
        $miss = [];
        $count = 0;
        foreach (range(0, 9) as $code) {
            $miss[$code] = 0;
        }
        $lotteries = Lottery::find(['order' => 'period desc', 'limit' => $limit, 'offset' => $offset]);
        for ($i = 0; $i < count($lotteries); $i++) {
            $current_now = $lotteries[$i]->attr('code5');
            foreach (range(0, 9) as $code) {
                if ($miss[$code] == 0 && $current_now == $code) {
                    $miss[$code] = $i + 1;
                    $count++;
                    if ($count == 10) {
                        break 2;
                    }
                }
            }
        }
        foreach ($miss as &$item) {
            $item -= 1;
        }
        arsort($miss);
        return $miss;
    }

    /**
     * 保存号码
     * @param $data
     * @return int
     */
    private function saveLastCode($data)
    {
        // 如果木有号码，直接返回0
        if (!is_array($data) || count($data) == 0) {
            return 0;
        }
        $count = 0;
        foreach ($data as $item) {
            if (strlen($item['period']) == 11) {
                $item['period'] = substr($item['period'], 0, 8) . '-' . substr($item['period'], 8, 3);
            }
            if (Lottery::count("period = '{$item['period']}'") == 0) {
                $lottery = new Lottery();
                $lottery->date = substr($item['period'], 0, 8);
                $lottery->period = $item['period'];
                $lottery->code1 = $item['code'][0];
                $lottery->code2 = $item['code'][1];
                $lottery->code3 = $item['code'][2];
                $lottery->code4 = $item['code'][3];
                $lottery->code5 = $item['code'][4];
                $lottery->save();
                $count++;
            }

            // 检查自动投注是否中奖
            $bet = Bet::findFirst("period = '{$item['period']}'");
            $this->logger->info("bet: " . json_encode($bet));
            if ($bet != null && empty($bet->win_code)) {
                $bet->win_code = $item['code'][4];
                $bet->is_win = strpos($bet->codes, "{$item['code'][4]}") !== false ? 1 : 0;
                $bet->save();
                $this->logger->info(json_encode($bet));
            }
        }
        // 修正一下每日120期的日期
        $this->db->query("update lottery set date = left(period, 8) where right(period, 3) = '120'");
        return $count;
    }

    /**
     * 获取倍率
     * @param array $bet_times
     * @param int $wipe
     * @param float $odds
     * @return array
     */
    private function getBetTimes($bet_times = [], $wipe = 0, $odds = 19.2)
    {
        $bet_arr = [];
        for ($x = 0; $x < count($bet_times); $x++) {
            // 倍率
            $time = $bet_times[$x];
            $cost = 0;
            for ($y = $x; $y >= 0; $y--) {
                $cost += $bet_times[$y] * 2 * (10 - $wipe);
            }
            $gift = ($odds * $time) - $cost;
            $bet_arr[$x] = ['time' => $time, 'cost' => $cost, 'gift' => $gift];
        }
        return $bet_arr;
    }
}
