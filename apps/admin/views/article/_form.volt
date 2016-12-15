<div class="layui-form-item">
    <label class="layui-form-label required">{{ lang._('article.title') }}</label>
    <div class="layui-input-block">
        <input type="text" name="title" v-model="title" lay-verify="required" required value="{{ article.title }}"
               autocomplete="off" class="layui-input input-text required" placeholder="输入文章标题">
    </div>
</div>
<div class="layui-form-item">
    <label class="layui-form-label">{{ lang._('article.link') }}</label>
    <div class="layui-input-block">
        <input type="text" name="link" v-model="link" autocomplete="off" class="layui-input input-text"
               value="{{ article.link }}" placeholder="输入文章链接" />
    </div>
    <div class="layui-form-mid block layui-word-aux">{{ lang._('article.link.hint') }}</div>
</div>
<div class="layui-form-item item-inline">
    <label class="layui-form-label required">{{ lang._('article.category') }}</label>
    <div class="layui-input-inline">
        <select name="category_id" lay-verify="required" required style="width: 50%; min-width: 433px;">
            <option value="">{{ lang._('article.category.option1') }}</option>
            {% for _cat in categories %}
            <option value="{{ _cat.id }}" {{ _cat.id == article.category_id ? 'selected' : '' }}>{{ _cat.title }}</option>
            {% endfor %}
        </select>
    </div>
</div>
<div class="layui-form-item item-inline">
    <label class="layui-form-label label-80">{{ lang._('article.is_show') }}</label>
    <div class="layui-input-block">
        <input type="checkbox" name="is_show"
               title="{{ lang._('article.is_show.title') }}" {{ article.is_show == 1 ? 'checked' : '' }}>
    </div>
</div>
<div class="layui-form-item layui-form-text">
    <label class="layui-form-label">{{ lang._('article.content') }}</label>
    <div class="layui-input-block" id="layui_md"></div>
</div>
<div class="layui-form-item">
    <div class="layui-input-block">
        <button class="layui-btn padding-25" lay-submit="">
            <i class="iconfont m-r-5">&#xe7bd;</i> {{ lang._('handle.submit') }}
        </button>
        {% if _is_new %}
        <button type="reset" class="layui-btn layui-btn-primary">{{ lang._('common.reset') }}</button>
        {% endif %}
    </div>
</div>