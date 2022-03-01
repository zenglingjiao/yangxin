<!--sidebar-wrapper-->
<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div class="">
            <img src="assets/images/logo-icon.png" class="logo-icon-2" alt=""/>
        </div>
        <div>
            <h4 class="logo-text">Sunny</h4>
        </div>
        <a href="javascript:void(0);" class="toggle-btn ml-auto"> <i class="bx bx-menu"></i>
        </a>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <template v-for="v in get_menu()">
            <li v-if="v.level==1">
                <a v-if="v.is_route==1" :href="v.route" class="menu_list" :param_name="v.name">
                    <div class="parent-icon icon-color-9"><i :class="v.ico"></i></div>
                    <div class="menu-title">@{{v.full_name}}</div>
                </a>
                <a v-else class="has-arrow" href="javascript:void(0);">
                    <div class="parent-icon icon-color-10"><i :class="v.ico"></i>
                    </div>
                    <div class="menu-title">@{{v.full_name}}</div>
                </a>
                <tree :children="v.children"></tree>
                {{--<ul v-if="v.children&&v.children.length>0">--}}
                {{--    <li v-for="vv in v.children" :class="(vv.name=='{{isset($active)?$active:''}}'?'mm-active':'')">--}}
                {{--        <a :href="vv.route" class="menu_list" :param_name="vv.name">--}}
                {{--            <div class="parent-icon icon-color-9"><i :class="vv.ico"></i></div>--}}
                {{--            <div class="menu-title">@{{vv.full_name}}</div>--}}
                {{--        </a>--}}
                {{--    </li>--}}
                {{--</ul>--}}
            </li>
        </template>
    </ul>
    <!--end navigation-->
</div>
<!--end sidebar-wrapper-->
<!--header-->
<header class="top-header">
    <nav class="navbar navbar-expand">
        <div class="left-topbar d-flex align-items-center">
            <a href="javascript:;" class="toggle-btn"> <i class="bx bx-menu"></i>
            </a>
        </div>
        <div class="right-topbar ml-auto">
            <ul class="navbar-nav">
                <li class="nav-item dropdown dropdown-user-profile">
                    <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;" data-toggle="dropdown">
                        <div class="media user-box align-items-center">
                            <div class="media-body user-info">
                                <p class="user-name mb-0">Hello @{{get_user()&&get_user().name?get_user().name:""}}</p>
                                <p class="designattion mb-0">@{{get_user()&&get_user().username?get_user().username:""}}</p>
                            </div>
                            <img src="assets/images/user.jpg" class="user-img" alt="manager">
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="javascript:void(0);" onclick="com_password.show=true"><i class="bx bx-user"></i><span>修改密码</span></a>
                        <div class="dropdown-divider mb-0"></div>
                        <a class="dropdown-item" href="javascript:void(0);" onclick="logout_server('{{ route('logout') }}','{{ route('login') }}');"><i class="bx bx-power-off"></i><span>登出</span></a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>
<!--end header-->