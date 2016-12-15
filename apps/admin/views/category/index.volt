<div id="vo">
    <div class="layui-clear m-t-5">
        <div class="pull-left m-t-10">
            {{ lang._('common.total') }} <span class="color-red">7</span> {{ lang._('common.records_count') }}
        </div>
        <div class="pull-right">
            <button class="layui-btn layui-btn-small" onclick="func_add();">
                <i class="iconfont">&#xe618;</i> {{ lang._('common.add') }}
            </button>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-hover table-center m-t-5">
            <thead>
            <tr>
                <th>{{ lang._('common.index') }}</th>
                <th class="align-left">{{ lang._('category.title') }}</th>
                <th class="align-left">{{ lang._('category.name') }}</th>
                <th>{{ lang._('category.is_show') }}</th>
                <th>{{ lang._('category.show_in_nav') }}</th>
                <th>{{ lang._('common.sort') }}</th>
                <th>{{ lang._('common.handle') }}</th>
            </tr>
            </thead>
            <tbody>
            {% for index,cat in categories %}
            <tr>
                <td>{{ index + 1 }}</td>
                <td class="align-left">{{ cat.title }}</td>
                <td class="align-left">
                    <a href="/{{ cat.name }}" target="_blank">
                        <span class="color-default">http://blog.robbie.im/</span>{{ cat.name }}
                    </a>
                </td>
                <td>
                    {% if cat.is_show == 1 %}
                    <i class="iconfont color-dark-green">&#xe616;</i>
                    {% else %}
                    <a><i class="iconfont color-danger">&#xe611;</i></a>
                    {% endif %}
                </td>
                <td>
                    {% if cat.show_in_nav == 1 %}
                    <a><i class="iconfont color-dark-green">&#xe616;</i></a>
                    {% else %}
                    <a><i class="iconfont color-danger">&#xe611;</i></a>
                    {% endif %}
                </td>
                <td>{{ cat.sort }}</td>
                <td>
                    <div class="scale inline"><i class="iconfont bigger-120 color-blue pointer"
                                           title="{{ lang._('common.edit') }}" onclick="func_edit({{ cat.id }})">&#xe686;</i></div>
                    <div class="scale inline"><i class="iconfont bigger-120 color-danger m-l-10 pointer"
                                           title="{{ lang._('common.delete') }}" onclick="func_delete({{ cat.id }})">&#xe61b;</i></div>
                </td>
            </tr>
            {% for sub_idx,sub_cat in cat.Children %}
            <tr>
                <td></td>
                <td class="align-left">
                    <span class="color-default m-l-25">
                        {{ loop.last ? '└─' : '├─' }}
                    </span>
                    {{ sub_cat.title }}
                </td>
                <td class="align-left">
                    <a href="/{{ sub_cat.name }}" target="_blank">
                        <span class="color-default">http://blog.robbie.im/</span>{{ sub_cat.name }}
                    </a>
                </td>
                <td>
                    {% if sub_cat.is_show == 1 %}
                    <i class="iconfont color-dark-green">&#xe616;</i>
                    {% else %}
                    <i class="iconfont color-danger">&#xe611;</i>
                    {% endif %}
                </td>
                <td>
                    {% if sub_cat.show_in_nav == 1 %}
                    <i class="iconfont color-dark-green">&#xe616;</i>
                    {% else %}
                    <i class="iconfont color-danger">&#xe611;</i>
                    {% endif %}
                </td>
                <td>{{ sub_cat.sort }}</td>
                <td>
                    <div class="scale inline"><i class="iconfont bigger-120 color-blue pointer"
                                                 title="{{ lang._('common.edit') }}" onclick="func_edit({{ sub_cat.id }})">&#xe686;</i></div>
                    <div class="scale inline"><i class="iconfont color-danger bigger-120 m-l-10 pointer"
                                                 title="{{ lang._('common.delete') }}" onclick="func_delete({{ sub_cat.id }})">&#xe61b;</i></div>
                </td>
            </tr>
            {% endfor %}
            {% endfor %}
            </tbody>
        </table>
    </div>
</div>
<input type="hidden" id="total_page" value="{{total_page}}" />
<input type="hidden" id="layer_add_title" value="{{ lang._('category.add_new') }}："/>
<input type="hidden" id="layer_edit_title" value="{{ lang._('category.edit') }}："/>

<div id="pager"></div>
<script>
    function func_add() {
        layer_open({
            title: $("#layer_add_title").val(),
            width: 520, height: 430, maxmin: false,
            content: '/admin/category/new'
        });
    }
    function func_edit(id) {
        layer_open({
            title: $("#layer_edit_title").val(),
            width: 520, height: 430, maxmin: false,
            content: '/admin/category/' + id + '/edit'
        });
    }
    function func_delete(id) {
        layer.confirm("确认删除吗？", {shade: 0.6}, function() {
            ajax_post({
                url: '/admin/category/' + id + '/delete'
            });
        });
    }
    layui.use(['laypage'], function () {
        var total_page = $("#total_page").val() || 1;
        layui.laypage({
            cont: 'pager',
            pages: total_page,
            first: 1,
            last: total_page,
            skin: 'molv',
            prev: '<em><</em>',
            next: '<em>></em>',
            curr: function () {
                var page = location.search.match(/page=(\d+)/);
                return page ? page[1] : 1;
            }(),
            jump: function (e, first) {
                if (!first) {
                    location.href = '?page=' + e.curr;
                }
            }
        });
    });
</script>
