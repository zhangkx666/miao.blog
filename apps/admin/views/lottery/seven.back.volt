<div class="m-t-10 m-b-10 m-l-50">

</div>
<div class="hr hr-double hr-dotted hr18"></div>
<div class="m-b-5">
    统计数据：<b class="color-red">{{ bet_histories | length }}</b> 条，
    策略延迟：<b class="color-red">{{ limit }}</b> 条，
    号码个数：<b class="color-blue">{{ code_count }}</b> 个
</div>
<div class="row col-xs-8">
    <table class="table table-bordered table-striped table-hover table-center table-center">
        <thead>
        <tr>
            <th>日期</th>
            <th>期数</th>
            <th>投注号码</th>
            <th>开奖号码</th>
            <th>中奖</th>
            <th>成本</th>
            <th>金额</th>
        </tr>
        </thead>
        <tbody>
        {% set _counter = 0 %}
        {% set _total = 0 %}
        {% set _money = 0 %}
        {% set _cost = 0 %}
        {% for item in bet_histories %}
        <tr>
            <td>{{ item.date }}</td>
            <td>{{ item.period }}</td>
            <td>{{ item.bet_code }}</td>
            <td>{{ item.win_code }}</td>
            {% if item.is_win == 0 %}
                {% set _counter = _counter + 1 %}
                {% set _cost = 0 %}
                {% set _money = 0 %}
            {% else %}
                {% set _cost = [20, 70, 170, 390, 870, 1870, 3970, 8370, 17570, 35570, 79570, 179570][_counter] / 10 %}
                {% set _money = [18.4, 26, 22, 32.4, 51.6, 50, 62, 78, 94, 830, 1070, 12430][_counter] / 10 %}
                {% set _counter = 0 %}
            {% endif %}
            {% set _total += _money %}
            <td>{{ item.is_win == 1 ? '<span class="color-dark-green">中</span>' : '<b class="color-red">×</b> ' ~ _counter }}</td>
            <td {{ _counter > 6 ? 'style="background: #f54b13; color: #fff"' : '' }}>{{ _cost }}</td>
            <td {{ _counter > 6 ? 'style="background: #f54b13; color: #fff"' : '' }}>{{ _money }}</td>
        </tr>
        {% endfor %}
        <tr>
            <td colspan="6">合计</td>
            <td>{{ _total }}</td>
        </tr>
        </tbody>
    </table>
</div>