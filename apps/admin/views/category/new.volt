<div style="padding: 20px;">
    <form method="post" action="/admin/category/create" class="layui-form layer-form m-t-10 ajax-form" iframe="true">
        {% include "category/_form.volt" %}
    </form>
</div>
<script>
    layui.use('form', function () {
        var form = layui.form();
    });
</script>