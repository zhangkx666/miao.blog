# MIAO.BLOG

> 一个基于 [Phalcon framework](https://github.com/phalcon/cphalcon) 开发的Markdown博客程序


Demo: http://miao.blog

Phalcon是一个开源的、全栈的、用C语言编写的PHP5框架，为开发者提供了网站及应用开发所需的大量高级工具。Phalcon中的所有函数都以PHP类的方式呈现，开发者无需学习和使用C语言，且无需担心性能问题。
查看[phalcon's github page](https://github.com/phalcon/cphalcon)的github页面获取使用方法。


博客使用markdown作为编辑器。
编辑器样式和弹窗依赖[Layui](https://github.com/sentsin/layui)

编辑器需要的几个文件：
public/layui/lay/modules/markdown.js
public/layui/css/modules/markdown/*.css


编辑器已封装为插件，使用方法如下：
```
<div id="layui_md"></div>

<script>
    layui.config({base: '/public/layui/lay/'}).extend({
        markdown: 'modules/markdown'
    });
    layui.use(['form', 'markdown'], function () {
        layui.markdown.build("layui_md");
    });
</script>
```