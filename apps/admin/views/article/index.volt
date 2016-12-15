<div class="table-responsive">
    <table class="table table-striped table-hover table-center">
        <thead>
        <tr>
            <th style="min-width: 40px">{{ lang._('common.index') }}</th>
            <th class="align-left" style="min-width: 70px">{{ lang._('article.user') }}</th>
            <th class="align-left" style="min-width: 80px">{{ lang._('article.category') }}</th>
            <th class="align-left">{{ lang._('article.title') }}</th>
            <th class="align-left">{{ lang._('article.link') }}</th>
            <th style="min-width: 60px">{{ lang._('article.view_count') }}</th>
            <th style="min-width: 60px">{{ lang._('article.comment_count') }}</th>
            <th style="min-width: 60px">{{ lang._('article.is_show') }}</th>
            <th>{{ lang._('article.created_at') }}</th>
            <th>{{ lang._('common.handle') }}</th>
        </tr>
        </thead>
        <tbody>
        {% for index,article in articles %}
        <tr>
            <td>{{ article.id }}</td>
            <td class="align-left">{{ article.user.name }}</td>
            <td class="align-left">{{ article.category.name }}</td>
            <td class="align-left"><a href="/admin/article/{{ article.id }}/edit">{{ article.title }}</a></td>
            <td class="align-left">
                <a href="/article/{{ article.link is empty ? article.id : article.link }}" target="_blank">
                    <span class="color-default">/article/</span>{{ article.link is empty ? article.id : article.link }}
                </a>
            </td>
            <td>{{ article.view_count }}</td>
            <td>{{ article.comment_count }}</td>
            <td>
                {% if article.is_show == 1 %}
                <i class="iconfont green bigger-130">&#xe616;</i>
                {% else %}
                <i class="iconfont red bigger-130">&#xe611;</i>
                {% endif %}
            </td>
            <td>{{ article.created_at | date_format }}</td>
            <td>
                <div class="scale inline">
                    <a href="/admin/article/{{ article.id }}/edit" title="{{ lang._('common.edit') }}">
                        <i class="iconfont bigger-120 color-blue pointer">&#xe686;</i>
                    </a>
                </div>
                <div class="scale inline">
                    <i class="iconfont bigger-120 color-danger m-l-10 pointer"
                       title="{{ lang._('common.delete') }}" onclick="func_delete({{ article.id }})">&#xe61b;</i>
                </div>
            </td>
        </tr>
        {% endfor %}
        </tbody>
    </table>
</div>
<input type="hidden" id="total_page" value="{{total_page}}" />
<div id="pager"></div>
<script>
    function func_delete(id) {
        layer.confirm("确认删除吗？", {shade: 0.6}, function() {
            ajax_post({
                url: '/admin/article/' + id + '/delete'
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