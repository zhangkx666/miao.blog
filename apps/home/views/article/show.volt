{% extends "index.volt" %}

{% block js_css %}
<link rel="stylesheet" href="/public/js/HyperDown/markdown.css">
<link href="/public/css/markdown-editor.css" rel="stylesheet">
<link rel="stylesheet" href="/public/js/prism/prism.css">
{% endblock %}

{% block body %}
<div class="vue-div">
<div class="main-box">
    <div class="article-show">
        <h1>{{ article.title }}</h1>
        <div class="article-info vo-block">
            <i class="fa fa-user m-r-3" title="作者"></i> <a href="#" title="不会PS的程序员不是好产品经理">{{ article.user.name }}</a>
            <i class="fa fa-eye m-l-20 m-r-3" title="阅读数"></i> {{ article.view_count }}
            <a href="#" @click.prevent="comment_like('article', {{ article.id }}, $event)">
                <i class="fa fa-thumbs-o-up m-l-20 m-r-3 pointer" title="点赞"></i></a>
            <span class="like">{{ article.like_count }}</span>
            <i class="fa fa-commenting-o m-l-20 m-r-3" title="评论数"></i> {{ article.comment_count }}
            <i class="iconfont m-l-20 m-r-3" title="发布时间">&#xe627;</i> {{ article.created_at | date_format }}
        </div>
        <div class="content layui-markdown">
            {{ article.html }}
        </div>
    </div>
</div>
<blockquote class="layui-elem-quote quote-white quote-title">评论</blockquote>
<div class="main-box comment">
    <div class="comment-items">
        {% for comment in comments %}
        <div class="comment-block">
            <div class="avatar">
                <a href="{{ comment.link }}" target="_blank" title="{{ comment.nickname }}">
                    <img src="{{ comment.avatar|default('https://www.gravatar.com/avatar/00000000000000000000000000000000') }}" alt="{{ comment.nickname }}" /></a>
                <p>{{ comment.nickname }}</p>
            </div>
            <div class="time vo-block">
                <i class="iconfont m-r-3" title="发布时间">&#xe627;</i> <span>{{ comment.created_at | from_now }}</span>
                <a href="#" @click.prevent="comment_like('comment', {{ comment.id }}, $event)">
                    <i class="fa fa-thumbs-o-up m-l-20 m-r-3 pointer" title="点赞"></i></a>
                <span class="like">{{ comment.like_count }}</span>
<!--                <a href="#" class="m-l-20 back">回复</a>-->
<!--                <a href="#" class="m-l-5 back red">删除</a>-->
            </div>
            <div class="content layui-markdown">{{ comment.html }}</div>
        </div>
        {% endfor %}
        <template v-for="item in comment_items">
            <div class="comment-block">
                <div class="avatar">
                    <a href="{ item.link }" target="_blank" title="{item.nickname}">
                        <img src="{ item.avatar }" alt="{ item.nickname }" /></a>
                    <p>{ item.nickname }</p>
                </div>
                <div class="time vo-block">
                    <i class="iconfont m-r-3" title="发布时间">&#xe627;</i> 刚刚
                    <a href="#" @click.prevent="comment_like('comment', item.id, $event)">
                        <i class="fa fa-thumbs-o-up m-l-20 m-r-3 pointer" title="点赞"></i></a>
                    <span class="like">0</span>
<!--                    <a href="#" class="m-l-20 back">回复</a>-->
<!--                    <a href="#" class="m-l-5 back red">删除</a>-->
                </div>
                <div class="content layui-markdown" v-html="item.content"></div>
            </div>
        </template>
    </div>

    <div class="comment-form">
        <form class="layui-form ajax-form" name="comment_form" @submit.prevent="comment_submit($event)"
              method="post" action="/article/{{article.id}}/comment">
            <div class="layui-form-item m-b-10">
                <div class="layui-input-inline no-margin">
                    <input type="text" name="nickname" lay-verify="required" v-model="nickname"
                           class="layui-input input-text required" placeholder="请输入昵称（必填）" title="">
                </div>
                <div class="layui-input-inline no-margin">
                    <input type="text" name="email" lay-verify="email" v-model="email"
                           class="layui-input input-text required" placeholder="请输入Email地址（必填）"
                           title="您的邮箱地址仅用于获取头像，请放心输入。头像设置请移步 http://www.gravatar.com">
                </div>
                <div class="layui-input-inline no-margin width-370px">
                    <input type="text" name="link" class="layui-input input-text" v-model="link"
                           placeholder="输入网址" title="输入网址后，点击头像即可跳转到您的网站"/>
                </div>
            </div>
            <div id="layui_md"></div>
            <div class="layui-form-item">
                <div class="layui-input-inline no-margin width-370px m-t-10">
                    <input type="text" name="captcha" lay-verify="required" placeholder="人类验证：1 + 9 = ？"
                           autocomplete="off" class="layui-input input-text required" v-model="captcha">
                </div>
            </div>
            <button class="layui-btn padding-25 btn-submit m-t-10" lay-submit="" lay-filter="demo1">
                <i class="iconfont m-r-5">&#xe7bd;</i> 提交
            </button>
        </form>
    </div>
</div>
</div>
{% endblock %}
{% block js_footer %}
<script src="/public/js/layer/layer.js"></script>
<script src="/public/js/HyperDown/Parser.js"></script>
<script src="/public/js/prism/prism.js"></script>
<script src="/public/assets/js/jquery.form.js"></script>
<script src="/public/js/vue.min.js"></script>
<script src="/public/js/article.show.js"></script>
{% endblock %}