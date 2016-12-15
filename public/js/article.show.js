/**
 * Created by zhangkx on 2016/12/13.
 */
layui.config({base: '/public/layui/lay/'}).extend({
    markdown: 'modules/markdown'
});
layui.use(['form', 'markdown'], function () {
    layui.markdown.build("layui_md", {
        image_upload_action: '/admin/attachment/uploadImage',
        height: 200, required: true,
        tools: [
            'face', 'link', 'code', 'preview'
        ]
    });
    Vue.config.delimiters = ['{', '}'];
    var vo = new Vue({
        el: '.vue-div',
        data: {
            nick_name: '',
            link: '',
            markdown_content: '',
            captcha: '',
            comment_items: []
        },
        methods: {
            // 点赞
            comment_like: function (model, id, event) {
                $.post("/" + model + "/" + id + "/like", function (data) {
                    if (data.status == 1) {
                        var like_span = $(event.target).parents("div.vo-block").find("span.like");
                        like_span.text(Number(like_span.text()) + 1);
                        layer.msg("谢谢点赞", {time: 1000})
                    }
                })
            },
            // ajax提交评论表单
            comment_submit: function (event) {
                ajax_submit($(event.target), false, function (data) {
                    var _content = (new HyperDown).makeHtml(vo.markdown_content);
                    var item = {id: data.id, avatar: data.avatar,  nickname: vo.nickname, link: vo.link, content: _content}
                    vo.comment_items.push(item);

                    // document.comment_form.reset();
                    setTimeout(function () {
                        vo.markdown_content = '';
                        vo.captcha = '';
                        Prism.highlightAll();
                    }, 100);
                });
            }
        }
    });
});

$(function () {
    // 图片双击放大
    $(".layui-markdown img").click(function () {
        var img = new Image();
        var image_src = $(this).attr("src");
        img.src = image_src;
        var width = img.width, height = img.height;
        if (width > $(window).width() || height > $(window).height()) {
            width = "98%";
            height = "96%";
        } else {
            width = width + "px";
            height = height + "px";
        }
        layer.open({
            type: 1, title: false, shade: 0.6, closeBtn: 0, fixed: true, scrollbar: false,
            area: [width, height], shadeClose: true,
            content: "<div style='text-align: center'><img class='zoom-out' src='" + image_src + "' /></div>",
            success: function (dom, idx) {
                dom.click(function () {
                    layer.close(idx);
                })
            }
        });
    });
});


/**
 * ajax submit
 * @param obj $(this)
 * @param is_iframe 是否iframe
 */
function ajax_submit(obj, is_iframe, callback) {
    $(".btn-submit").attr("disabled", true);
    if (is_iframe)
        layer = parent.layer;
    var load = layer.load(8);
    obj.ajaxSubmit({
        success: function (rst) {
            layer.close(load);
            if (rst.status == 1) {
                if (rst.msg) {
                    layer.msg(rst.msg, {time: (rst.time ? rst.time * 1000 : 1000)}, function () {
                        if (callback && typeof callback === "function") {
                            $(".btn-submit").removeAttr("disabled");
                            callback(rst);
                        } else {
                            layer.load(8);
                            // 如果返回结果待url，跳转url
                            if (rst.url) {
                                if (is_iframe) {
                                    parent.location.href = rst.url;
                                } else {
                                    window.location.href = rst.url;
                                }
                            } else {
                                if (is_iframe) {
                                    // 如果是iframe打开，刷新父页面
                                    parent.location.reload();
                                } else {
                                    // 如果是本页面打开，刷新本页面
                                    window.location.reload();
                                }
                            }
                        }
                    });
                } else {
                    if (callback && typeof callback === "function") {
                        $(".btn-submit").removeAttr("disabled");
                        callback(rst);
                    } else {
                        layer.load(8);
                        // 如果返回结果待url，跳转url
                        if (rst.url) {
                            if (is_iframe) {
                                parent.location.href = rst.url;
                            } else {
                                window.location.href = rst.url;
                            }
                        } else {
                            if (is_iframe) {
                                // 如果是iframe打开，刷新父页面
                                parent.location.reload();
                            } else {
                                // 如果是本页面打开，刷新本页面
                                window.location.reload();
                            }
                        }
                    }
                }
            } else {
                $(".btn-submit").removeAttr("disabled");
                layer.alert(rst.msg, {icon: 5, shade: 0.6});
            }
        },
        error: function (rst) {
            layer.close(load);
            $(".btn-submit").removeAttr("disabled");
            layer.alert(rst.responseJSON.msg, {icon: 5, shade: 0.6});
        }
    });
}
