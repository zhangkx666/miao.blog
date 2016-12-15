<ul class="nav nav-list">
    <li name="index/index">
        <a href="/admin">
            <i class="menu-icon iconfont smaller-90">&#xe609;</i>
            <span class="menu-text">{{ lang._('index') }}</span>
        </a>
    </li>

    <li name="article">
        <a href="#" class="dropdown-toggle">
            <i class="menu-icon iconfont">&#xe60f;</i>
            <span class="menu-text">{{ lang._('article') }}</span>
            <b class="arrow fa fa-angle-down"></b>
        </a>
        <ul class="submenu">
            <li name="article/new">
                <a href="/admin/article/new">
                    <i class="menu-icon fa fa-pencil"></i>
                    <span class="menu-text">{{ lang._('article_new') }}</span>
                </a>
            </li>

            <li name="article/index">
                <a href="/admin/article">
                    <i class="menu-icon fa fa-list"></i>
                    <span class="menu-text">{{ lang._('article_index') }}</span>
                </a>
            </li>

            <li name="category/index">
                <a href="/admin/category">
                    <i class="menu-icon fa fa-list"></i>
                    <span class="menu-text">{{ lang._('category') }}</span>
                </a>
            </li>

            <li name="tag/index">
                <a href="/admin/tag">
                    <i class="menu-icon fa fa-tags"></i>
                    <span class="menu-text">{{ lang._('tag') }}</span>
                </a>
            </li>
        </ul>
    </li>

    <li name="user/index">
        <a href="/admin/user">
            <i class="menu-icon fa fa-user"></i>
            <span class="menu-text">{{ lang._('user') }}</span>
        </a>
    </li>

    <li name="setting/index">
        <a href="/admin/setting">
            <i class="menu-icon fa fa-cog"></i>
            <span class="menu-text">{{ lang._('setting') }}</span>
        </a>
    </li>

    <li name="lottery">
        <a href="#" class="dropdown-toggle">
            <i class="menu-icon iconfont">&#xe60f;</i>
            <span class="menu-text">{{ lang._('lottery') }}</span>
            <b class="arrow fa fa-angle-down"></b>
        </a>
        <ul class="submenu">
            <li name="lottery/three">
                <a href="/admin/lottery/three">
                    <i class="menu-icon fa fa-pencil"></i>
                    <span class="menu-text">{{ lang._('lottery_three') }}</span>
                </a>
            </li>
            <li name="lottery/groupsix">
                <a href="/admin/lottery/groupsix?is_before=0">
                    <i class="menu-icon fa fa-list"></i>
                    <span class="menu-text">{{ lang._('lottery_groupsix') }}</span>
                </a>
            </li>
            <li name="lottery/policy">
                <a href="/admin/lottery/policy?start_time=6">
                    <i class="menu-icon fa fa-list"></i>
                    <span class="menu-text">{{ lang._('lottery_policy') }}</span>
                </a>
            </li>
            <li name="lottery/always">
                <a href="/admin/lottery/always">
                    <i class="menu-icon fa fa-list"></i>
                    <span class="menu-text">{{ lang._('lottery_always') }}</span>
                </a>
            </li>
        </ul>
    </li>
</ul>
