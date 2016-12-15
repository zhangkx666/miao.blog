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
            <th>金额</th>
        </tr>
        </thead>
        <tbody>
        {% set _counter = 0 %}
        {% set _total = 0 %}
        {% for item in bet_histories %}
        <tr>
            <td>{{ item.date }}</td>
            <td>{{ item.period }}</td>
            <td>{{ item.bet_code }}</td>
            <td>{{ item.win_code }}</td>
            {% if item.is_win == 0 %}
                {% set _counter = _counter + 1 %}
                {% set _total -= 20 * code_count %}
            {% else %}
                {% set _total += 192 - (20 * code_count) %}
                {% set _counter = 0 %}
            {% endif %}
            <td>{{ item.is_win == 1 ? '<span class="color-dark-green">中</span>' : '<b class="color-red">×</b> ' ~ _counter }}</td>
            <td {{ _counter > 3 ? 'style="background: #f54b13; color: #fff"' : '' }}>{{ _total }}</td>
        </tr>
        {% endfor %}
        <tr>
            <td colspan="5">合计</td>
            <td>{{ _total }}</td>
        </tr>
        </tbody>
    </table>
</div>