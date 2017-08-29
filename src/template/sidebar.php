<!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
    <!-- BEGIN SIDEBAR -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            <li class="sidebar-toggler-wrapper hide">
                <div class="sidebar-toggler">
                    <span></span>
                </div>
            </li>
            <!-- END SIDEBAR TOGGLER BUTTON -->
            <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
            <li class="sidebar-search-wrapper">
                <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
                <!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
                <!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
                <form class="sidebar-search  " action="page_general_search_3.html" method="POST">
                    <a href="javascript:;" class="remove">
                        <i class="icon-close"></i>
                    </a>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search...">
                        <span class="input-group-btn">
                            <a href="javascript:;" class="btn submit">
                                <i class="icon-magnifier"></i>
                            </a>
                        </span>
                    </div>
                </form>
                <!-- END RESPONSIVE QUICK SEARCH FORM -->
            </li>
            <li class="nav-item start <? if($page === 'dashboard') {echo 'active';}?>">
                <a href="index.php" class="nav-link">
                    <i class="icon-home"></i>
                    <span class="title">Dashboard</span>
                    <span class="selected"></span>
                    <span class="arrow open"></span>
                </a>
            </li>
            <li class="heading">
                <h3 class="uppercase">Menu</h3>
            </li>

            <li class="nav-item <? if(in_array($page, ['add_machine', 'add_class', 'add_component'])) {echo 'active';}?>">
                <a href="javascript:;" class="nav-link nav-toggle ">
                    <!-- <i class="icon-diamond"></i> -->
                    <span class="title">Setup</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item <? if($page === 'add_machine') {echo 'active';}?>">
                        <a href="index.php?page=add_machine" class="nav-link ">
                            <span class="title">Add New Machine</span>
                        </a>
                    </li>
                    <li class="nav-item <? if($page === 'add_class') {echo 'active';}?>">
                        <a href="index.php?page=add_class" class="nav-link ">
                            <span class="title">Add Component Class</span>
                        </a>
                    </li>
                    <li class="nav-item <? if($page === 'add_component') {echo 'active';}?>">
                        <a href="index.php?page=add_component" class="nav-link ">
                            <span class="title">Add New Component</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item <? if(in_array($page, ['hour_log_entry', 'component_fitting', 'component_unfitting'])) {echo 'active';}?>">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <!-- <i class="icon-puzzle"></i> -->
                    <span class="title">Entry</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item <? if($page === 'hour_log_entry') {echo 'active';}?>">
                        <a href="index.php?page=hour_log_entry" class="nav-link ">
                            <span class="title">Hour Log Entry</span>
                        </a>
                    </li>
                    <li class="nav-item <? if($page === 'component_fitting') {echo 'active';}?>">
                        <a href="index.php?page=component_fitting" class="nav-link ">
                            <span class="title">Component Fitting</span>
                            <!-- <span class="badge badge-danger">2</span> -->
                        </a>
                    </li>
                    <li class="nav-item <? if($page === 'component_unfitting') {echo 'active';}?>">
                        <a href="index.php?page=component_unfitting" class="nav-link ">
                            <span class="title">Component Unfitting</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item <? if(in_array($page, ['list_machine', 'list_class', 'list_component', 'list_hour_log'])) {echo 'active';}?>">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <!-- <i class="icon-settings"></i> -->
                    <span class="title">List & Search</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item <? if($page === 'list_machine') {echo 'active';}?>">
                        <a href="index.php?page=list_machine" class="nav-link ">
                            <span class="title">Machine</span>
                        </a>
                    </li>
                    <li class="nav-item <? if($page === 'list_class') {echo 'active';}?>">
                        <a href="index.php?page=list_class" class="nav-link ">
                            <span class="title">Component Class</span>
                        </a>
                    </li>
                    <li class="nav-item <? if($page === 'list_component' && empty($status)) {echo 'active';}?>">
                        <a href="index.php?page=list_component" class="nav-link ">
                            <span class="title">All Components</span>
                        </a>
                    </li>
                    <li class="nav-item <? if($page === 'list_component' && $status === 'active') {echo 'active';}?>">
                        <a href="index.php?page=list_component&status=active" class="nav-link ">
                            <span class="title">Active Components</span>
                        </a>
                    </li>
                    <li class="nav-item <? if($page === 'list_component' && $status === 'expired') {echo 'active';}?>">
                        <a href="index.php?page=list_component&status=expired" class="nav-link ">
                            <span class="title">Expired Components</span>
                        </a>
                    </li>
                    <li class="nav-item <? if($page === 'list_component' && $status === 'expiring') {echo 'active';}?>">
                        <a href="index.php?page=list_component&status=expiring" class="nav-link ">
                            <span class="title">Expiring Components</span>
                        </a>
                    </li>
                    <li class="nav-item <? if($page === 'list_component' && $status === 'unfitted') {echo 'active';}?>">
                        <a href="index.php?page=list_component&status=unfitted" class="nav-link ">
                            <span class="title">Unfitted Components</span>
                        </a>
                    </li>
                    <li class="nav-item <? if($page === 'list_hour_log') {echo 'active';}?>">
                        <a href="index.php?page=list_hour_log" class="nav-link ">
                            <span class="title">Hour Log</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- END SIDEBAR MENU -->
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>
<!-- END SIDEBAR -->