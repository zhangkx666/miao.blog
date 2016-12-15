<div class="m-b-5">统计数据：<b class="color-red">{{ limit }}</b> 条</div>
<table class="table table-bordered table-striped table-hover table-center table-center">
    <thead>
    <tr>
        <th rowspan="2" style="width: 66px">连续<br>次数</th>
        <th colspan="5">倍投策略</th>
        {% set type_count = (types|length) + 1 %}
        {% for code in codes %}
        <th colspan="{{ type_count }}">第{{ code }}位</th>
        {% endfor %}
    </tr>
    <tr>
        <th class="child">倍率</th>
        <th class="child">成本</th>
        <th class="child">奖金</th>
        <th class="child">胜率</th>
        <th class="child">总数</th>
        {% for code in codes %}
            {% for type in types %}
            <th class="child">{{ lang._('lottery.' ~ type) }}</th>
            {% endfor %}
            <th class="child">总</th>
        {% endfor %}
    </tr>
    </thead>
    <tbody>
    {% for time in time_min..time_max %}
    <tr {{ time == time_min + 2 ? 'style="background: #DFF0D8"' : '' }} >
        <td class="bolder align-left" style="padding-left: 15px;">
            {% if time > time_min %}
            <span class="color-default">{{ time_min }}</span> <span class="color-red">+{{ time - time_min }}</span>
            {% else %}
            <span class="color-default">{{ time_min }}</span>
            {% endif %}
        </td>

        {% set bet = bet_times[time - time_min] %}
        <td class="align-right">{{ bet['time'] }}</td>
        <td class="align-right">{{ bet['cost'] }}</td>
        <td class="align-right">{{ bet['gift'] | round(2) }}</td>
        <td class="align-right">{{ total['rate'][time]|round(2) }}%</td>
        <td class="align-right">{{ total['time'][time] }}</td>
        {% for code in codes %}
            {% for type in types %}
                <td>{{ counts[code][type][time] == 0 ? '-' : counts[code][type][time] }}</td>
            {% endfor %}
            <td>
                {% if total['code_time'][code][time] == 0 %}
                -
                {% else %}
                <span class="badge badge-warning">{{ total['code_time'][code][time] }}</span>
                {% endif %}
            </td>
        {% endfor %}
    </tr>
    {% endfor %}

    <tr>
        <td colspan="5">合计</td>
        <td class="align-right">{{ total['total'] }}</td>
        {% for code in codes %}
            {% for type in types %}
                <td>{{ total['code_type'][code][type] }}</td>
            {% endfor %}
            <td class="color-red bolder">{{ total['code'][code] }}</td>
        {% endfor %}
    </tr>
    </tbody>
</table>
