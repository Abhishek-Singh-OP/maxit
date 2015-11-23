<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once('includes/head.php'); ?>
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
    <style>
      .tokenize-dropdown {height: 34px !important;width: 100%;}
    </style>
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
         <h1>Cedilla Files for <?php echo substr($methodname, 0, strpos($methodname, '_')); ?></h1>
         <hr>
			<button id="generafile" class="btn btn-primary">Generate File</button>
			<button id="publishfile" class="btn btn-primary" disabled="true">Publish File</button><br />
      <div id="divpublish"></div>
      <div class="alert alert-success"  id="divsuccess" style="display:none">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Success!</strong> File Generated Succesfully
      </div>
      <div class="alert alert-danger" id="diverr" style="display:none">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Error!</strong> 
      </div>
			<!-- <div style="color:red"></div>
      <div style="color:ligh-green" id="divsuccess"></div> -->
      </section><!-- /MAIN CONTENT -->
  </section>

  <?php include_once('includes/site_bottom_scripts.php'); ?>
  <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>

  <script>
      $(document).ready(function(){
        $("#divsuccess").hide();
        $("#diverr").hide();
        $("#divpublish").html("");
      	$("#generafile").click(function(event) {
	      $.ajax({
	      	url: '<?=base_url()?>index.php/paletro_files/<?=$methodname?>',
	      	type: 'POST',
	      })
	      .done(function(data) {
	      	if($.trim(data)=="Success"){
	      		$("#publishfile").removeAttr('disabled');
            $("#divsuccess").show();
            $("#diverr").hide();
	      		//$("#divsuccess").append('Files Generated Successfully');
	      		//$("#diverr").html("");
	      	}
	      	else{
	      		$("#publishfile").attr('disabled', 'true');
            $("#divsuccess").hide();
            $("#diverr").show();
	      		$("#diverr").append(data);
	      		//$("#divsuccess").html("");	
	      	}
          document.location.href="<?=base_url()?>index.php/paletro_files/download_file/<?php echo substr($methodname, 0, strpos($methodname, '_')); ?>";
	      	console.log("success");
	      })
	      .fail(function() {
	      	console.log("error");
	      })
	      .always(function() {
	      	console.log("complete");
	      });
      	});
      	$("#publishfile").click(function(event) {
      		$.ajax({
      			url: '<?=base_url()?>index.php/paletro_files/send_file/<?php echo substr($methodname, 0, strpos($methodname, '_')); ?>',
      			type: 'POST',
      		})
      		.done(function(data) {
      			/*if($.trim(data)=="Success"){
		      		$("#divsuccess").html("File Published Successfully");
	      			$("#diverr").html("");
		      	}
		      	else{
		      		$("#diverr").html("Error Occured > "+data);
	      			$("#divsuccess").html("");	
		      	}*/
            $("#divsuccess").hide();
            $("#diverr").hide();
            $("#divpublish").html(data);
      			console.log("success");
      		})
      		.fail(function() {
      			console.log("error");
      		})
      		.always(function() {
      			console.log("complete");
      		});
      		
      	});
      });
  </script>
</body>
</html>