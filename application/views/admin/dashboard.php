<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once( 'includes/head.php'); ?>
</head>

<body>

    <section id="container">
        <header class="header black-bg">
            <div class="sidebar-toggle-box">
                <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
            </div>
            <!--logo start-->
            <a href="javascript:void(0);" class="logo"><b>menu</b></a>
            <!--logo end-->
            <div class="nav notify-row" id="top_menu">
                <!--  notification start -->
                <ul class="nav top-menu">

                </ul>
                <!--  notification end -->
            </div>
            <div class="top-menu">
                <ul class="nav pull-right top-menu">
                    <li><a class="logout" href="<?=base_url()?>auth/logout">Logout</a>
                    </li>
                </ul>
            </div>
        </header>
        <!--header end-->

        <!--sidebar start-->
        <aside>
            <?php include_once( 'includes/sidebar.php'); ?>
        </aside>
        <!--sidebar end-->

        <!--main content start-->
        <section id="main-content">
            <section class="wrapper site-min-height">
                <h1 class="page-header">Dashboard</h1>
                <hr>
                <div class="row mt">
                    <div class="col-lg-12">
                        <!-- <div id="site_users_chart"></div> -->

                        <div class="col-lg-6">
                            <div id="new_users_chart"></div>
                        </div>

                        <div class="col-lg-6">
                            <div id="posts_chart"></div>
                        </div>

                    </div>
                    <div class="col-md-12">
                        <h3>Offers : <?=$offerscount->totaloffers?></h3>          
                    </div>
                    <div class="col-md-12">
                        <h3>Establishment : <?=$establishmentcount->totalest?></h3>        
                    </div>
                    <div class="col-md-12">
                        <h3>Cards : <?=$cardcount->totalcards?></h3>         
                    </div>      
                </div>
            </section>
            <!-- /wrapper -->
        </section>
        <!-- /MAIN CONTENT -->

        <!--main content end-->
        <!--footer start-->
<!--         <footer class="site-footer">
            <div class="text-center">
                Zipsave - 2015
                <a href="blank.html#" class="go-top">
                    <i class="fa fa-angle-up"></i>
                </a>
            </div>
        </footer> -->
        <!--footer end-->
    </section>

    <?php include_once( 'includes/site_bottom_scripts.php'); ?>
    <script>
$(function () {
    $('#new_users_chart').highcharts({
        chart: {
            type: 'line'
        },
        title: {
            text: 'New users this week'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: [<?php echo implode(', ', array_map(function ($entry) { return "'".$entry['day']."'"; }, $new_users)); ?>]
        },
        yAxis: {
            title: {
                text: 'New users'
            }
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: false
            }
        },
        series: [{
            name: 'Users',
            data: [<?php echo implode(',', array_map(function ($entry) { return $entry['users']; }, $new_users)); ?>]
        }]
    });



    $('#posts_chart').highcharts({
        chart: {
            type: 'line'
        },
        title: {
            text: 'Posts this week'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: [<?php echo implode(', ', array_map(function ($entry) { return "'".$entry['day']."'"; }, $fb_posts)); ?>]
        },
        yAxis: {
            title: {
                text: 'New users'
            }
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: false
            }
        },
        series: [{
            name: 'Facebook posts',
            data: [<?php echo implode(',', array_map(function ($entry) { return $entry['posts']; }, $fb_posts)); ?>]
        },
        {
            name: 'Twitter posts',
            data: [<?php echo implode(',', array_map(function ($entry) { return $entry['posts']; }, $tw_posts)); ?>]
        }
        ]
    });
});
    </script>
</body>

</html>