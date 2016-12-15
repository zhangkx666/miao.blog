<div class="m-t-10 m-b-10 m-l-50">
    {% set __counter = 0 %}
    {% for key in code_total | array_keys %}
    {% set __counter += 1 %}
    <div class="inline m-r-20 align-center">
        <span class="badge badge-{{ __counter <= (10-wipe) ? 'pink' : 'default' }}" style="transform: scale(1.5)">
            <b>{{ code_total[key]['code'] }}</b>
        </span>
        <div class="color-default m-t-10">{{ code_total[key]['count'] | default(0) }}</div>
    </div>
    {% endfor %}
    {% if (is_mobile != '1') %}
    <div class="inline m-l-20 color-red">
        <form method="get">
            <input class="layui-input inline" autocomplete="off" type="text" style="width: 80px" name="code_count" value="{{ code_count }}" placeholder="号码个数" />
            <input class="layui-input inline" autocomplete="off" type="text" style="width: 80px" name="limit" value="{{ limit }}" placeholder="记录条数" />
            <input class="layui-input inline" autocomplete="off" type="text" style="width: 150px" name="policy_codes" value="{{ policy_codes }}" placeholder="自定义号码" />
            <button type="submit" class="layui-btn top-2px" style="height: 38px"><i class="fa fa-search"></i> 查询</button>
        </form>
    </div>
    {% endif %}
</div>
<div class="hr hr-double hr-dotted hr18"></div>
<div class="row">
    <div style="width: {{ (is_mobile != '1') ? '54%' : '100%' }}; float: left">
        <div class="m-b-5">统计数据：<b class="color-red">{{ limit }}</b> 条</div>
        <table class="table table-bordered table-striped table-hover table-center table-center">
            <thead>
            <tr>
                <th rowspan="2">日期</th>
                <th rowspan="2">期数</th>
                <th rowspan="2">开奖号码</th>
                <th colspan="10" class="parent">号码</th>
            </tr>
            <tr>
                {% for num in 0..9 %}
                <th class="child">{{ num }}</th>
                {% endfor %}
            </tr>
            </thead>
            <tbody>
            <tr>
                <td colspan="3">遗漏次数</td>
                {% for num in 0..9 %}
                <td>{{ code_total['_' ~ num]['miss'] }}</td>
                {% endfor %}
            </tr>
            {% for idx in 0..(data|length - 1) %}
            {% set _code = data[idx]['lottery'].attr('code' ~ code) %}
            <tr>
                <td>{{ data[idx]['lottery'].date }}</td>
                <td>{{ data[idx]['lottery'].period}}</td>
                <td>
                    <span class="badge badge badge-{{ code == 1 ? data[idx]['color'] : 'default' }}">{{ data[idx]['lottery'].code1 }}</span>
                    <span class="badge badge-{{ code == 2 ? data[idx]['color'] : 'default' }}">{{ data[idx]['lottery'].code2 }}</span>
                    <span class="badge badge-{{ code == 3 ? data[idx]['color'] : 'default' }}">{{ data[idx]['lottery'].code3 }}</span>
                    <span class="badge badge-{{ code == 4 ? data[idx]['color'] : 'default' }}">{{ data[idx]['lottery'].code4 }}</span>
                    <span class="badge badge-{{ code == 5 ? data[idx]['color'] : 'default' }}">{{ data[idx]['lottery'].code5 }}</span>
                </td>
                {% for num in 0..9 %}
                {% if _code == num %}
                <td><span class="badge badge-{{ data[idx]['color'] }}">{{ _code }}</span></td>
                {% else %}
                <td></td>
                {% endif %}
                {% endfor %}
            </tr>
            {% endfor %}
            </tbody>
        </table>
    </div>
    {% if (is_mobile != '1') %}
    <div style="width: 44%; float: right">
        <div class="m-b-5">统计数据：<b class="color-red">{{ limit }}</b> 条</div>
        <table class="table table-bordered table-striped table-center table-center">
            <thead>
            <tr>
                <th>投注情况</th>
                <th>次数</th>
                <th>概率</th>
                <th>单价</th>
                <th>金额</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>中奖</td>
                <td>{{ count['success'] }}</td>
                <td>{{ ((count['success'] / data|length) * 100) | round(2) }}%</td>
                {% set gift = (19.2 - (10-wipe)*2) %}
                <td>{{ gift * 10 }}</td>
                <td>{{ gift * count['success'] }}</td>
            </tr>
            <tr>
                <td>未中奖</td>
                <td>{{ count['failed'] }}</td>
                <td>{{ ((count['failed'] / data|length) * 100) | round(2) }}%</td>
                {% set cost = (10-wipe)*2 %}
                <td>-{{ cost * 10 }}</td>
                <td>-{{ cost * count['failed'] }}</td>
            </tr>
            <tr>
                <td>未投注</td>
                <td>{{ count['ignore'] }}</td>
                <td>{{ ((count['ignore'] / data|length) * 100) | round(2) }}%</td>
                <td>-</td>
                <td>-</td>
            </tr>
            <tr>
                <td>收益</td>
                <td>{{ data|length }}</td>
                <td>-</td>
                <td>-</td>
                <td class="color-red bolder">
                    {{ (((gift * count['success']) - (cost * count['failed'])) | round(2)) * 10 }}
                </td>
            </tr>
            </tbody>
        </table>

        <div class="m-b-5">
            未中连续出现次数及概率，统计数据：<b class="color-red">{{ limit }}</b> 条，
            共 <b class="color-red">{{ total['total'] }}</b> 次
        </div>
        <table class="table table-bordered table-striped table-center table-center">
            <thead>
            <tr>
                <th rowspan="2">第几<br>次中</th>
                <th rowspan="2">次数</th>
                <th rowspan="2">概率</th>
                <th colspan="5" class="parent">倍投策略</th>
            </tr>
            <tr>
                <th class="child">倍率</th>
                <th class="child">单次<br>成本</th>
                <th class="child">总成本</th>
                <th class="child">奖金</th>
                <th class="child">合计</th>
            </tr>
            </thead>
            <tbody>
            {% set _total = 0 %}
            {% for time in time_min..time_max %}
            <tr {{ total['rate'][time] == 100 ? 'style="background: #DFF0D8"' : '' }} >
                <td class="bolder align-left" style="padding-left: 15px;">
                    {{ time + 1 }}
                </td>
                {% set _time = time == time_min ? (total['time'][time]) : total['time'][time] %}
                <td class="align-right">{{ _time }}</td>
                <td class="align-right">{{ total['rate'][time] | round(2) }}%</td>
                {% set bet = bet_times[time - time_min] %}
                <td class="align-right">{{ bet['time'] }}</td>
                <td class="align-right">{{ bet['time'] * 2 * code_count }}</td>
                <td class="align-right">{{ bet['cost'] }}</td>
                <td class="align-right">{{ bet['gift'] | round(2) }}</td>
                {% set _total_gift = (bet['gift'] * _time) | round(2) %}
                {% if time == 3 %}
                  {% set _cost = bet['cost'] %}
                {% endif %}
                {% set _total_gift = time <= 3 ? _total_gift : (-_cost * _time) %}
                {% set _total += _total_gift %}
                <td class="align-right">{{ _total_gift }}</td>
            </tr>
            {% endfor %}
            <tr>
                <td colspan="7">合计</td>
                <td>{{ _total }}</td>
            </tr>
            </tbody>
        </table>
    </div>
    {% endif %}
</div>