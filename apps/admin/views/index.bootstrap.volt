<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta charset="utf-8"/>
    {{ tag.getTitle() }}
    <meta name="description" content=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <link rel="stylesheet" href="/public/assets/css/bootstrap.css"/>
    <link rel="stylesheet" href="/public/font-awesome-4.6.3/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="/public/iconfont/iconfont.css"/>
    <!-- page specific plugin styles -->
    <link rel="stylesheet" href="/public/assets/css/select2.css"/>
    <link rel="stylesheet" href="/public/assets/css/ace-fonts.css"/>
    <link rel="stylesheet" href="/public/assets/css/ace.css" class="ace-main-stylesheet" id="main-ace-style"/>
    <link rel="stylesheet" href="/public/assets/css/ace-skins.css" />

    <!--[if lte IE 9]>
    <link rel="stylesheet" href="/public/assets/css/ace-part2.css" class="ace-main-stylesheet"/>
    <link rel="stylesheet" href="/public/assets/css/ace-ie.css"/>
    <![endif]-->
    <script src="/public/assets/js/ace-extra.js"></script>
    <!--[if lte IE 8]>
    <script src="/public/assets/js/html5shiv.js"></script>
    <script src="/public/assets/js/respond.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="/public/js/layer/skin/layer.css">
    <link rel="stylesheet" href="/public/css/admin/common.css">
    <script src="/public/assets/js/jquery.min.js"></script>
    <script src="/public/js/vue.min.js"></script>
</head>

<body class="no-skin skin-3">
<div id="navbar" class="navbar navbar-default navbar-fixed-top">
    <script type="text/javascript">
        try {
            ace.settings.check('navbar', 'fixed')
        } catch (e) {
        }
    </script>
    <div class="navbar-container" id="navbar-container">
        <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
            <span class="sr-only">Toggle sidebar</span>

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>
        </button>
        <div class="navbar-header pull-left">
            <a href="/admin" class="navbar-brand">
                <small>
                    <i class="iconfont bigger-130">&#xe601;</i>
                    {{ config.project.name }} {{ config.project.version }} {{ lang._('backend') }}
                </small>
            </a>
        </div>
        <div class="navbar-buttons navbar-header pull-right" role="navigation">
            <ul class="nav ace-nav">

                <li class="light-blue">
                    <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                        <!--						<img class="nav-user-photo" src="/" alt="zhangkx" />-->
                        <span class="user-info">
                            <small>Welcome,</small>
                            zhangkx
                        </span>
                        <i class="ace-icon fa fa-caret-down"></i>
                    </a>

                    <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                        <li>
                            <a href="#">
                                <i class="ace-icon fa fa-cog"></i>
                                个人设置
                            </a>
                        </li>

                        <li>
                            <a href="profile.html">
                                <i class="ace-icon fa fa-user"></i>
                                个人面板
                            </a>
                        </li>

                        <li class="divider"></li>

                        <li>
                            <a href="{:U('JC00S11:A03')}?back_url={$Think.session.page_url}">
                                <i class="ace-icon fa fa-power-off"></i>
                                注销
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="main-container" id="main-container">
    <script type="text/javascript">
        try {
            ace.settings.check('main-container', 'fixed')
        } catch (e) {
        }
    </script>
    <div class="sidebar responsive sidebar-fixed sidebar-scroll" id="sidebar" data-sidebar="true"
         data-sidebar-scroll="true" data-sidebar-hover="true" data-scroll-to-active="true" data-include-shortcuts="true"
         data-smooth-scroll="150">
        <script type="text/javascript">
            try {
                ace.settings.check('sidebar', 'fixed')
            } catch (e) {
            }
        </script>
        {% include "_menu.volt" %}
        <!-- #section:basics/sidebar.layout.minimize -->
        <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
            <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left"
               data-icon2="ace-icon fa fa-angle-double-right"></i>
        </div>
        <!-- /section:basics/sidebar.layout.minimize -->
        <script type="text/javascript">
            try {
                ace.settings.check('sidebar', 'collapsed')
            } catch (e) {
            }
        </script>
    </div>
    <div class="main-content">
        <div class="main-content-inner">
            <div class="breadcrumbs" id="breadcrumbs">
                <script type="text/javascript">
                    try {
                        ace.settings.check('breadcrumbs', 'fixed')
                    } catch (e) {
                    }
                </script>

                <ul class="breadcrumb">
                    <li>
                        <i class="ace-icon fa fa-home home-icon"></i>
                        {{ lang._('miao') }}
                    </li>
                    <li>{{ controller_name }}</li>
                    {% if action_name is not empty %}
                    <li>{{ action_name }}</li>
                    {% endif %}
                </ul>
            </div>
            <div class="page-content">
                <div class="row">
                    {% set has_flash = flash.has() %}
                    {% set alert_types = ['success': 'success', 'error': 'danger', 'notice': 'info', 'warning': 'warning'] %}
                    {% if has_flash %}
                    {% for key, messages in flash.getMessages(null, true) %}
                    {% for msg in messages %}
                    <div class="alert alert-{{ alert_types[key] }}">
                        <button type="button" class="close" data-dismiss="alert">
                            <i class="ace-icon fa fa-times"></i>
                        </button>
                        {{ msg }}
                        <br>
                    </div>
                    {% endfor %}
                    {% endfor %}
                    {% endif %}

                    {{ content() }}
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <div class="footer-inner">
            <div class="footer-content">
                <span class="bigger-120">
                    Powered by <a href="http://robbie.im" target="_blank">{{ config.project.name }} {{ config.project.version }}</a>
                </span>
            </div>
        </div>
    </div>

    <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
        <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
    </a>
</div><!-- /.main-container -->

<script src="/public/assets/js/bootstrap.js"></script>

<!-- page specific plugin scripts -->
<script src="/public/assets/js/ace/elements.scroller.js"></script>
<script src="/public/assets/js/jquery.maskedinput.min.js"></script>
<script src="/public/assets/js/jquery.cookie.js"></script>
<script src="/public/assets/js/jquery.form.js"></script>
<!--<script src="/public/assets/js/layer/layer.js"></script>-->
<!--<script src="/public/assets/js/layer/laydate.min.js"></script>-->
<!--<script src="/public/assets/js/layer/laytpl.js"></script>-->
<!--<script src="/x-assets/js/common.js"></script>-->
<script src="/public/assets/js/select2.js"></script>
<script src="/public/assets/js/ace/elements.colorpicker.js"></script>
<script src="/public/assets/js/ace/ace.js"></script>
<script src="/public/assets/js/ace/ace.sidebar.js"></script>
<script src="/public/assets/js/ace/ace.sidebar-scroll-1.js"></script>
<script src="/public/assets/js/ace/ace.submenu-hover.js"></script>
<script src="/public/assets/js/fuelux/fuelux.tree.js"></script>
<script src="/public/assets/js/ace/elements.treeview.js"></script>
<script src="/public/js/layer/layer.js"></script>
<script src="/public/js/admin/common.js"></script>
<!--<script src="/x-assets/js/jquery.data_hook.js"></script>-->

{% if has_flash and flash_time %}
<script type="application/javascript">
    $(function () {
        setTimeout(function () {
            $(".alert").fadeOut();
        }, {{ flash_time }});
    });
</script>
{% endif %}
<script type="application/javascript">
    $(function () {
        $(".nav .active").removeClass("active");
        $(".nav .open").removeClass("open");
        var controller_id = '{{ router.getControllerName() }}';
        if (controller_id == 'category' || controller_id == 'tag') {
            $(".nav li[name='article']").addClass("active open");
        } else {
            $(".nav li[name='" + controller_id + "']").addClass("active open");
        }
        $(".nav li[name='{{ router.getControllerName() }}/{{ router.getActionName() }}']").addClass("active");
    });
</script>
</body>
</html>
