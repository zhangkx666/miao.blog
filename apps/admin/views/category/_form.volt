<div class="layui-form-item">
    <label class="layui-form-label required">{{ lang._('category.title') }}</label>
    <div class="layui-input-block">
        <input type="text" name="title" lay-verify="required" autocomplete="off" class="layui-input required"
               value="{{ category.title }}">
    </div>
</div>
<div class="layui-form-item">
    <label class="layui-form-label required">{{ lang._('category.name') }}</label>
    <div class="layui-input-block">
        <input type="text" name="name" lay-verify="required" autocomplete="off" class="layui-input required"
               value="{{ category.name }}">
    </div>
</div>
<div class="layui-form-item">
    <label class="layui-form-label">{{ lang._('category.parent') }}</label>
    <div class="layui-input-block">
        <select name="parent_id" class="input-blue" {{(category.children|count) > 0 ? 'disabled' : '' }}>
            <option value=""></option>
            {% for _cat in parent_categories %}
            <option value="{{ _cat.id }}" {{ _cat.id == category.parent_id ? 'selected' : '' }}>{{ _cat.title }}</option>
            {% endfor %}
        </select>
    </div>
</div>
<div class="layui-form-item">
    <label class="layui-form-label">{{ lang._('category.is_show') }}</label>
    <div class="layui-input-block">
        <input type="checkbox" name="is_show" title="{{ lang._('category.is_show_label') }}"
               {{ category.is_show == 1 ? 'checked' : '' }}>
        <input type="checkbox" name="show_in_nav" title="{{ lang._('category.show_in_nav_label') }}"
               {{ category.show_in_nav == 1 ? 'checked' : '' }}>
    </div>
</div>
<div class="layui-form-item">
    <label class="layui-form-label">{{ lang._('common.sort') }}</label>
    <div class="layui-input-block">
        <input type="text" name="sort" autocomplete="off" class="layui-input" value="{{ category.sort }}">
    </div>
</div>

<div class="submit-area m-t-40">
    <button type="submit" class="layui-btn btn-submit" lay-submit>
        <i class="iconfont m-r-5">&#xe7bd;</i> {{ lang._('handle.submit') }}
    </button>
</div>