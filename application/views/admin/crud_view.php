<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include_once('includes/head.php'); ?>
 
    <?php 
    foreach($css_files as $file): ?>
        <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
     
    <?php endforeach; ?>
    <?php foreach($js_files as $file): ?>
     
        <script src="<?php echo $file; ?>"></script>
    <?php endforeach; ?>
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
  </head>

  <body>

  <section id="container" >
      <header class="header black-bg">
              <div class="sidebar-toggle-box">
                  <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
              </div>
            <!--logo start-->
            <a href="javascript:void(0);" class="logo"><b>Menu</b></a>
            <!--logo end-->
            <div class="nav notify-row" id="top_menu">
                <!--  notification start -->
                <ul class="nav top-menu">
                   
                </ul>
                <!--  notification end -->
            </div>
            <div class="top-menu">
            	<ul class="nav pull-right top-menu">
                    <li><a class="logout" href="<?=base_url()?>auth/logout">Logout</a></li>
            	</ul>
            </div>
        </header>
      <aside>
        <?php include_once('includes/sidebar.php'); ?>
      </aside>
      <section id="main-content">
          <section class="wrapper site-min-height">
          	<h1><?=str_replace("_", " ", ucfirst($this->uri->segment(2, 0)))?></h1>
            <hr>
          	<div class="row mt">
              <div class="col-lg-12">
                <?php echo $output; ?>
              </div>
          	</div>
			
		</section><!-- /wrapper -->
      </section><!-- /MAIN CONTENT -->
  </section>

  <?php include_once('includes/site_bottom_scripts.php'); ?>
  <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>
  <script src="text/javascript">
      $(document).ready(function(){
        initialize();
            $('.colorpickeradmin').colorpicker();
      })
      
      var autocomplete;
      function initialize() {
        autocomplete = new google.maps.places.Autocomplete(
          (document.getElementById('field-establishment')),
        { types: ['establishment'] });
        google.maps.event.addListener(autocomplete, 'place_changed', function() {});
      }

  </script>
  </body>
</html>
