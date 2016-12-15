<div class="m-t-10 m-b-12">
    <a class="layui-btn layui-btn-small {{ is_before ? '' : 'layui-btn-primary' }} m-l-5" href="?is_before=1">前三组六</a>
    <a class="layui-btn layui-btn-small {{ is_before ? 'layui-btn-primary' : '' }} m-l-5" href="?is_before=0">后三组六</a>
    <span class="m-l-10" style="position: relative; top: 12px;">统计数据：<b class="color-red">{{ limit }}</b> 条</span>
</div>
<div class="hr hr-double hr-dotted hr18"></div>
<div class="row m-t-20">
    <div style="width: 64%; float: left">
        <table class="table table-bordered table-striped table-hover table-center table-center">
            <thead>
            <tr>
                <th rowspan="2">日期</th>
                <th rowspan="2">期数</th>
                <th rowspan="2">开奖号码</th>
                <th colspan="3">类型</th>
<!--                <th>金额</th>-->
            </tr>
            <tr>
                <th class="child">豹子</th>
                <th class="child">组三</th>
                <th class="child">组六</th>
<!--                <th class="child color-red">{{ total['money'] }}</th>-->
            </tr>
            </thead>
            <tbody>
            {% for idx in 0..(data|length - 1) %}
            <tr>
                <td>{{ data[idx]['lottery'].date }}</td>
                <td>{{ data[idx]['lottery'].period}}</td>
                <td>
                    <span class="badge badge-{{ is_before ? data[idx]['color'] : 'default' }}">{{ data[idx]['lottery'].code1 }}</span>
                    <span class="badge badge-{{ is_before ? data[idx]['color'] : 'default' }}">{{ data[idx]['lottery'].code2 }}</span>
                    <span class="badge badge-{{ data[idx]['color'] }}">{{ data[idx]['lottery'].code3 }}</span>
                    <span class="badge badge-{{ is_before ? 'default' : data[idx]['color'] }}">{{ data[idx]['lottery'].code4 }}</span>
                    <span class="badge badge-{{ is_before ? 'default' : data[idx]['color'] }}">{{ data[idx]['lottery'].code5 }}</span>
                </td>
                <td class="{{ data[idx]['is_leopard'] ? 'background-pink' : '' }}">
                    {{ data[idx]['is_leopard'] ? '豹子' : '' }}
                </td>
                <td class="{{ data[idx]['is_group_three'] ? 'background-warning' : '' }}">
                    {{ data[idx]['is_group_three'] ? '组三' : '' }}
                </td>
                <td class="{{ data[idx]['is_group_six'] ? 'background-default' : '' }}">
                    {{ data[idx]['is_group_six'] ? '组六' : '' }}
                </td>
<!--                <td class="{{ data[idx]['money'] > 0 ? 'background-success' : (data[idx]['money'] < 0 ? 'background-danger' : '') }}">{{ data[idx]['money'] }}</td>-->
            </tr>
            {% endfor %}
            </tbody>
        </table>
    </div>
    <div style="width: 34%; float: right;">
        <div>
            <table class="table table-bordered table-striped table-center table-center">
                <thead>
                <tr>
                    <th>类型</th>
                    <th>概率</th>
                    <th>次数</th>
                    <th>金额</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>豹子</td>
                    <td>{{ (count['leopard'] / (data|length) * 100) | round(2) }}%</td>
                    <td>{{ count['leopard'] }}</td>
                    <td class="align-right">-{{ count['leopard'] * 240 }}</td>
                </tr>
                <tr>
                    <td>组三</td>
                    <td>{{ (count['group_three'] / (data|length) * 100) | round(2) }}%</td>
                    <td>{{ count['group_three'] }}</td>
                    <td class="align-right">-{{ count['group_three'] * 240 }}</td>
                </tr>
                <tr>
                    <td>组六</td>
                    <td>{{ (count['group_six'] / (data|length) * 100) | round(2) }}%</td>
                    <td>{{ count['group_six'] }}</td>
                    <td class="align-right">{{ count['group_six'] * 80 }}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div>
            <div class="m-b-5">组三连续出现次数及概率，统计数据：<b class="color-red">{{ limit }}</b> 条</div>
            <table class="table table-bordered table-striped table-center table-center">
                <thead>
                <tr>
                    <th rowspan="2">连续<br>次数</th>
                    <th rowspan="2">出现<br>次数</th>
                    <th rowspan="2">概率</th>
<!--                    <th colspan="3">倍投策略</th>-->
                </tr>
<!--                <tr>-->
<!--                    <th class="child">倍率</th>-->
<!--                    <th class="child">成本</th>-->
<!--                    <th class="child">奖金</th>-->
<!--                </tr>-->
                </thead>
                <tbody>
                {% for time in time_min..time_max %}
                <tr {{ total['rate'][time] == 100 ? 'style="background: #DFF0D8"' : '' }} >
                    <td class="bolder align-left" style="padding-left: 15px;">
                        {% if time > time_min %}
                        <span class="color-default">{{ time }}</span> <span class="color-red"></span>
                        {% else %}
                        <span class="color-default">{{ time_min }}</span>
                        {% endif %}
                    </td>
                    <td class="align-right">{{ total['time'][time] }}</td>
                    <td class="align-right">{{ total['rate'][time] | round(2) }}%</td>
<!--                    {% set bet = bet_times[time - time_min] %}-->
<!--                    <td class="align-right">{{ bet['time'] }}</td>-->
<!--                    <td class="align-right">{{ bet['cost'] }}</td>-->
<!--                    <td class="align-right">{{ bet['gift'] }}</td>-->
                </tr>
                {% endfor %}
                </tbody>
            </table>
        </div>
    </div>
</div>