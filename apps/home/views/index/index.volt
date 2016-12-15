{% extends "index.volt" %}
{% block js_css %}
<link rel="stylesheet" href="/public/js/HyperDown/markdown.css">
<link rel="stylesheet" href="/public/js/prism/prism.css">
<script src="/public/js/prism/prism.js"></script>
{% endblock %}
{% block body %}
{% for article in articles %}
<div class="main-box">
    <div class="article-block">
        {% if article.cover_img_url %}
        <div class="img">
            <a href="/article/{{ article.link | default(article.id) }}"><img src="{{ article.cover_img_url }}"/></a>
        </div>
        {% endif %}
        <div class="content {{ article.cover_img_url ? 'margin' : '' }}">
            <h4><a href="/article/{{ article.link | default(article.id) }}">{{ article.title }}</a></h4>
            <div class="m-t-20 desc layui-markdown">
                {{ article.html }}
            </div>
        </div>
        <div class="article-info">
            <i class="fa fa-user m-r-3" title="作者"></i> <a href="#" title="不会PS的程序员不是好产品经理">{{ article.user.name }}</a>
            <i class="fa fa-eye m-l-20 m-r-3" title="阅读数"></i> {{ article.view_count }}
            <i class="fa fa-thumbs-o-up m-l-20 m-r-3 pointer" title="点赞"></i> {{ article.like_count }}
            <i class="fa fa-commenting-o m-l-20 m-r-3" title="评论数"></i> {{ article.comment_count }}
            <i class="fa fa-clock-o m-l-20 m-r-3" title="发布时间"></i> {{ article.created_at | date_format }}
        </div>
    </div>
</div>
{% endfor %}
{% endblock %}