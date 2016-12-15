/**
 * Created by zhangkx on 2016/9/22.
 */

/**
 * 打开layer
 * @param _options
 */
function layer_open(_options) {
    var defaults = {
        type: 2,          // 5种层类型
        maxmin: true,     // 可最大化
        fix: false,       // 鼠标滚动时，层是否固定在可视区域。
        scroll: true,    // 是否滚动
        refresh: false,   // 关闭时是否刷新
        max_when_open: false,   // 打开时最大化
        shade: 0.6,       // 遮罩层透明度,
        shadeClose: false, // 点击shade层关闭弹唱
        shift: 0,         // 动画 0-6,
        moveType: 1,
        skin: "layui-layer-rim",
        top: "auto",
        zIndex: 1111
    };
    var options = $.extend(defaults, _options);
    options.width = ($(window).width() < options.width) ? "100%" : options.width + "px";
    if (options.max_when_open || $(window).height() < options.height) {
        options.maxmin = true;
        options.scroll = true;
    }
    var index = layer.open({
        type: options.type,
        shift: options.shift,
        moveType: options.moveType,
        shade: options.shade,
        shadeClose: options.shadeClose,
        maxmin: options.maxmin,
        fix: false,
        zIndex: options.zIndex,
        title: options.title,
        area: [options.width, options.height + "px"],
        offset: options.top,
        skin: options.skin,
        content: (options.type == 1) ? options.content : [options.content, options.scroll ? "yes" : "no"],
        success: function (layer_dom, index) {
            if (options.success) options.success(layer_dom, index);
        },
        end: function () {
            if (options.refresh) {
                parent.location.reload();
            }
            if (options.end) options.end();
        }
    });
    if (options.max_when_open || $(window).height() < options.height) {
        layer.full(index);
    }
    return index;
}

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
                    layer.msg(rst.msg, {icon: 6, shade: 0.6, time: (rst.time ? rst.time * 1000 : 1000)}, function () {
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

$(function () {
    // ajax提交表单
    $(".ajax-form").on("submit", function (e) {
        e.preventDefault();
        ajax_submit($(this), $(this).attr("iframe") == "true");
    });
});


// ajax 提交
window.ajax_post = function(options, callback) {
    var defaults = {
        reload: true,     // ajax success 后刷新
        show_msg: true,   // 显示消息
        is_iframe: false, // 是iframe弹层提交
        icon: 8,
        data: {},
        method: "POST"
    };
    options = $.extend(defaults, options);
    var load = layer.load(options.icon);
    $(".btn-submit").attr("disabled", true);
    $.ajax({
        type: "POST", url: options.url, data: options.data,
        success: function (rst) {
            layer.close(load);
            if (rst.status == 1) {
                if (options.show_msg && rst.msg) {
                    layer.msg(rst.msg, {icon: 6, shade: 0.6, time: (rst.time ? rst.time * 1000 : 1000)}, function () {
                        if (callback && typeof callback === "function") {
                            $(".btn-submit").removeAttr("disabled");
                            callback(rst);
                        } else {
                            // 如果返回结果待url，跳转url
                            if (rst.url) {
                                if (options.is_iframe) {
                                    parent.location.href = rst.url;
                                } else {
                                    window.location.href = rst.url;
                                }
                            } else {
                                if (options.reload) {
                                    layer.load(options.icon);
                                    if (options.is_iframe) {
                                        parent.location.reload();
                                    } else {
                                        window.location.reload();
                                    }
                                }
                            }
                        }
                    });
                } else {
                    if (callback && typeof callback === "function") {
                        $(".btn-submit").removeAttr("disabled");
                        callback(rst);
                    } else {
                        // 如果返回结果待url，跳转url
                        if (rst.url) {
                            if (options.is_iframe) {
                                parent.location.href = rst.url;
                            } else {
                                window.location.href = rst.url;
                            }
                        } else {
                            if (options.reload) {
                                layer.load(options.icon);
                                if (options.is_iframe) {
                                    parent.location.reload();
                                } else {
                                    window.location.reload();
                                }
                            }
                        }
                    }
                }
            } else {
                $(".btn-submit").removeAttr("disabled");
                layer.alert(rst.msg, {icon: 5, shade: 0.6});
            }
        },
        error: function(rst) {
            layer.close(load);
            $(".btn-submit").removeAttr("disabled");
            layer.alert(rst.responseJSON.msg, {icon: 5, shade: 0.6});
        }
    });
};
