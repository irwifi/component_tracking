<?
  $page_title = "Admin Dashboard";
?>

<!-- BEGIN DASHBOARD STATS 1-->
<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
            <div class="visual">
                <i class="fa fa-comments"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="126">0</span>
                </div>
                <div class="desc"> Machines </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 red" href="#">
            <div class="visual">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="419">0</span></div>
                <div class="desc"> Active Components </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 green" href="#">
            <div class="visual">
                <i class="fa fa-shopping-cart"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="174">0</span>
                </div>
                <div class="desc"> Unfitted Components </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 purple" href="#">
            <div class="visual">
                <i class="fa fa-globe"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="89"></span></div>
                <div class="desc"> Expired Components </div>
            </div>
        </a>
    </div>
</div>
<div class="clearfix"></div>
<!-- END DASHBOARD STATS 1-->


<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption ">
            <span class="caption-subject font-dark bold uppercase">Component By Status</span>
            <span class="caption-helper">component stats...</span>
        </div>
        <div class="actions">
            <div class="btn-group">
                <a class="btn green-haze btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
                    <i class="fa fa-angle-down"></i>
                </a>
                <ul class="dropdown-menu pull-right">
                    <li>
                        <a href="javascript:;"> Option 1</a>
                    </li>
                    <li class="divider"> </li>
                    <li>
                        <a href="javascript:;">Option 2</a>
                    </li>
                    <li>
                        <a href="javascript:;">Option 3</a>
                    </li>
                    <li>
                        <a href="javascript:;">Option 4</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="portlet-body">
        <div id="dashboard_amchart_4" class="CSSAnimationChart"></div>
    </div>
</div>