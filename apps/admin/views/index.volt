<!DOCTYPE html>
<html lang="zh-CN">
<head>
    {% include "_meta_header.volt" %}
    {% block js_css %}{% endblock %}
</head>
<body>
<div class="layui-layout layui-layout-admin">
    <div class="layui-header header header-demo">
        <div class="layui-main">
            <a class="logo" href="/">
                <!--                <img src="//res.layui.com/images/layui/logo-1.png" alt="layui">-->
                <i class="iconfont" style="font-size: 32px;">&#xe601;</i> MIAO.BLOG
            </a>
            <ul class="layui-nav">
                <li class="layui-nav-item ">
                    <a href="/" target="_blank">博客</a>
                </li>
            </ul>
        </div>
    </div>
    {% include "_menu.volt" %}
    <div class="layui-body">
        <div class="layui-main">
            <div class="layui-breadcrumb">
                <a href="/admin"><img src="/public/img/home_16px.png" class="icon"> {{ lang._('miao') }}</a>
                <a href="/admin/{{ router.getControllerName() }}">{{ controller_name }}</a>
                {% if action_name is not empty %}
                <a><cite>{{ action_name }}</cite></a>
                {% endif %}
            </div>
            {% block body %}{{ content() }}{% endblock %}
        </div>
    </div>
    <div class="layui-footer footer footer-demo">
        <div class="layui-main">
            Powered by <a href="http://robbie.im" target="_blank">{{ config.project.name }} {{ config.project.version }}</a>
        </div>
    </div>
</div>
<script>
    layui.use('element', function () { });
    $(function () {
        $(".layui-this").removeClass("layui-this");
        $(".layui-nav-tree li[name='{{ router.getControllerName() }}/{{ router.getActionName() }}']").addClass("layui-this");
    });
</script>
<div style="display: none">
    <script src="https://s5.cnzz.com/z_stat.php?id=3471426&web_id=3471426" language="JavaScript"></script>
</div>
</body>
</html>