<div class="layui-side layui-bg-black">
        <div class="layui-side-scroll">
            <ul class="layui-nav layui-nav-tree">
                <li class="layui-nav-item" name="index/index">
                    <a href="/admin">
                        <i class="menu-icon iconfont smaller-90">&#xe609;</i>
                        <span>{{ lang._('menu.index') }}</span>
                    </a>
                </li>

                <li class="layui-nav-item layui-nav-title">
                    <a>
                        <span class="menu-text">{{ lang._('menu.content') }}</span>
                    </a>
                </li>
                <li class="layui-nav-item" name="article/new">
                    <a href="/admin/article/new">
                        <i class="iconfont">&#xe649;</i>
                        <span class="menu-text">{{ lang._('menu.article_new') }}</span>
                    </a>
                </li>
                <li class="layui-nav-item" name="article/index">
                    <a href="/admin/article">
                        <i class="iconfont">&#xe626;</i>
                        <span class="menu-text">{{ lang._('menu.article_index') }}</span>
                    </a>
                </li>

                <li class="layui-nav-item" name="category/index">
                    <a href="/admin/category">
                        <i class="iconfont">&#xe7be;</i>
                        <span class="menu-text">{{ lang._('menu.category') }}</span>
                    </a>
                </li>

                <li class="layui-nav-item" name="tag/index">
                    <a href="/admin/tag">
                        <i class="iconfont">&#xe6a4;</i>
                        <span class="menu-text">{{ lang._('menu.tag') }}</span>
                    </a>
                </li>

                <li class="layui-nav-item" name="comment/index">
                    <a href="/admin/comment">
                        <i class="iconfont">&#xe608;</i>
                        <span class="menu-text">{{ lang._('menu.comment') }}</span>
                    </a>
                </li>

                <li class="layui-nav-item layui-nav-title">
                    <a>
                        <span class="menu-text">{{ lang._('menu.system') }}</span>
                    </a>
                </li>
                <li class="layui-nav-item" name="user/index">
                    <a href="/admin/user">
                        <i class="iconfont">&#xe621;</i>
                        <span class="menu-text">{{ lang._('menu.user') }}</span>
                    </a>
                </li>

                <li class="layui-nav-item" name="setting/index">
                    <a href="/admin/setting">
                        <i class="iconfont">&#xe79c;</i>
                        <span class="menu-text">{{ lang._('menu.setting') }}</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>