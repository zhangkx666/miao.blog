<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MIAO.BLOG</title>
    <link href="//cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="/public/css/animate.css" rel="stylesheet">
    <link href="//at.alicdn.com/t/font_fx3bbyo2x5lpiudi.css" rel="stylesheet"/>
    <link href="/public/layui/css/layui.css" rel="stylesheet">
    <link href="/public/css/index.css" rel="stylesheet">
    {% block js_css %}{% endblock %}
</head>
<body>
<div class="container">
    <div class="layui-header header">
        <div class="layui-main">
            <a href="/" class="logo">MIAO.BLOG</a>
            <ul class="layui-nav" lay-filter="">
                <li class="layui-nav-item layui-this" name="index"><a href="/">首页</a></li>
                {% for cat in nav_categories %}
                <li class="layui-nav-item {{ (cat.children | length) > 0 ? 'parent-menu' : '' }}" name="{{ cat.name }}">
                    {% if cat.children | length > 0 %}
                    <a href="/{{ cat.name }}">{{ cat.title }}</a>
                    <dl class="layui-nav-child"> <!-- 二级菜单 -->
                        {% for sub_cat in cat.Children %}
                        {% if sub_cat.show_in_nav %}
                        <dd><a href="/{{ sub_cat.name }}">{{ sub_cat.title }}</a></dd>
                        {% endif %}
                        {% endfor %}
                    </dl>
                    {% else %}
                    <a href="/{{ cat.name }}">{{ cat.title }}</a>
                    {% endif %}
                </li>
                {% endfor %}
            </ul>
            <button class="menu-more"><i class="fa fa-align-justify"></i></button>
        </div>
    </div>
    <div class="layui-main layui-content animated fadeInDown">
        <!--        <div class="image-banner">-->
        <!--            <img src="/img/header.jpg"/>-->
        <!--        </div>-->
        {% block body %}{{ content() }}{% endblock %}
    </div>
    <div class="layui-footer">
        <div class="layui-main">
            <p>Powered by <a href="http://miao.blog" target="_blank">MIAO.BLOG</a></p>
        </div>
    </div>
</div>
<div style="display: none">
    <script src="https://s5.cnzz.com/z_stat.php?id=3471426&web_id=3471426" language="JavaScript"></script>
</div>
<script src="/public/assets/js/jquery.min.js"></script>
<script src="/public/layui/layui.js"></script>
<script>
    layui.use('element', function () {
        var $ = layui.jquery;
        if (document.documentElement.clientWidth < 740)
            $(".layui-nav-item").unbind("mouseenter").unbind("mouseleave");
        $(".menu-more").click(function () {
            $(".layui-nav").fadeToggle("fast", function () {
            });
        });
        $(".layui-this").removeClass("layui-this");
        $(".layui-nav li[name='{{ category_name }}']").addClass("layui-this");
    });
</script>
{% block js_footer %}{% endblock %}
</body>
</html>
