{% extends "index.volt" %}
{% block js_css %}
<link rel="stylesheet" href="/public/css/admin/article_new.css">
<link rel="stylesheet" href="/public/js/HyperDown/markdown.css">
<link href="/public/css/markdown-editor.css" rel="stylesheet">
<link rel="stylesheet" href="/public/js/prism/prism.css">
<script src="/public/js/prism/prism.js"></script>
<script src="/public/js/HyperDown/Parser.js"></script>
<script src="//cdn.bootcss.com/jquery.form/3.51/jquery.form.min.js"></script>
{% endblock %}
{% block body %}

<div id="vo" class="clearfix m-t-20">
    <div class="article-form">
        <form class="layui-form ajax-form" method="post" action="/admin/article/create">
            {% set _is_new = true %}
            {% include "article/_form.volt" %}
        </form>
    </div>
    <div class="article-preview" v-showx="title || link || markdown_html">
        <h4 class="article-title">{title}</h4>
        <p class="url color-default" v-if="link">{{ lang._('article.link.always') }}：http://miao.blog/article/{link}</p>
        <div class="layui-markdown m-t-20" v-html="markdown_html"></div>
    </div>
</div>

<script>
    layui.config({base: '/public/layui/lay/'}).extend({ //设定组件别名
        markdown: 'modules/markdown'
    });
    layui.use(['form', 'markdown'], function () {
        layui.markdown.build("layui_md", {
            image_upload_action: '/admin/attachment/uploadImage',
            height: 400, required: true
        });

        // markdown 解析
        var parser = new HyperDown;
        Vue.config.delimiters = ['{', '}'];
        var vo = new Vue({
            el: '#vo',
            data: {
                markdown_content: null,
                markdown_html: ''
            },
            watch: {
                markdown_content: function(val) {
                    vo.markdown_html = parser.makeHtml(val);
                    Prism.highlightAll();
                }
            }
        });
    });
</script>
{% endblock %}