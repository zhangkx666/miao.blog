<div class="m-t-10 m-b-10">
    <a class="btn btn-sm no-border {{ start_time == 4 ? 'btn-success' : '' }} m-l-5" href="?start_time=4">4次</a>
    <a class="btn btn-sm no-border {{ start_time == 5 ? 'btn-success' : '' }} m-l-5" href="?start_time=5">5次</a>
    <a class="btn btn-sm no-border {{ start_time == 6 ? 'btn-success' : '' }} m-l-5" href="?start_time=6">6次</a>
    <a class="btn btn-sm no-border {{ start_time == 7 ? 'btn-success' : '' }} m-l-5" href="?start_time=7">7次</a>
    <a class="btn btn-sm no-border {{ start_time == 8 ? 'btn-success' : '' }} m-l-5" href="?start_time=8">8次</a>
    <a class="btn btn-sm no-border {{ start_time == 9 ? 'btn-success' : '' }} m-l-5" href="?start_time=9">9次</a>
    <a class="btn btn-sm no-border {{ start_time == 10 ? 'btn-success' : '' }} m-l-5" href="?start_time=10">10次</a>
</div>
<div class="hr hr-double hr-dotted hr18"></div>
<div class="row">
    <div class="col-xs-12">
        <div class="m-b-5">
            共 <b class="color-red">{{ limit }}</b> 条号码，

            <span>图标颜色：</span>
            <span class="badge badge-yellow">{{ start_time }}</span>
            <span class="badge badge-success">{{ start_time + 1 }}</span>
            <span class="badge badge-warning">{{ start_time + 2 }}</span>
            <span class="badge badge-danger">{{ start_time + 3 }}</span>
            <span class="badge badge-pink">{{ start_time + 4 }}</span>
            <span class="badge badge-inverse">{{ start_time + 5 }}+</span>
        </div>
        <table class="table table-bordered table-striped table-hover table-center table-center">
            <thead>
            <tr>
                <th>日期</th>
                <th>期数</th>
                <th>小 <span class="badge badge-warning">{{ total['small'] }}</span></th>
                <th>大 <span class="badge badge-warning">{{ total['big'] }}</span></th>
                <th>单 <span class="badge badge-warning">{{ total['odd'] }}</span></th>
                <th>双 <span class="badge badge-warning">{{ total['even'] }}</span></th>
            </tr>
            </thead>
            <tbody>
            {% for idx in 0..(data|length - 1) %}
            <tr>
                <td>{{ data[idx]['lottery'].date }}</td>
                <td>{{ data[idx]['lottery'].period}}</td>
                {% for type in policy_types %}
                <td>
                    <span class="badge badge-{{ data[idx][type][1] }}">{{ data[idx]['lottery'].code1 }}</span>
                    <span class="badge badge-{{ data[idx][type][2] }}">{{ data[idx]['lottery'].code2 }}</span>
                    <span class="badge badge-{{ data[idx][type][3] }}">{{ data[idx]['lottery'].code3 }}</span>
                    <span class="badge badge-{{ data[idx][type][4] }}">{{ data[idx]['lottery'].code4 }}</span>
                    <span class="badge badge-{{ data[idx][type][5] }}">{{ data[idx]['lottery'].code5 }}</span>
                </td>
                {% endfor %}
            </tr>
            {% endfor %}
            </tbody>
        </table>
    </div>
</div>