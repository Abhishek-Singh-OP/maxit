<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>Simpleread</title>
    <link href="<?=base_url()?>assets/admin/css/bootstrap.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/admin/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/admin/css/style.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/admin/css/style-responsive.css" rel="stylesheet">
  </head>
  <body onload="getTime()">
	  	<div class="container">
            <button class="btn btn-warning" name="establishment" id="establishment" onclick="generate_establishment();"> Generate Ultimate Card </button>
	  	</div>
    <!-- js placed at the end of the document so the pages load faster -->
    <script src="<?=base_url()?>assets/admin/js/jquery.js"></script>
    <script src="<?=base_url()?>assets/admin/js/bootstrap.min.js"></script>

    <!--BACKSTRETCH-->
    <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
    <script type="text/javascript" src="<?=base_url()?>assets/admin/js/jquery.backstretch.min.js"></script>
    <script>

        function generate_establishment(){
          $.ajax({
            url: "<?=base_url()?>index.php/admin/get_establishments_data",
            type: "post",
            success: function(response){
              // console.log(response);
              for(var i=0;i<response.length;i++){
                //txt_offer_subcategory
                var id = response[i].id;
                console.log(id);
                genrate_ultimatecard(id);
                genrate_bestcard(id);
              }
            }
          });
        }

        function genrate_ultimatecard(id){
            $.ajax({
                url: "<?=base_url()?>index.php/examples/ultimate_cards",
                type: "post",
                data: "txt_category="+id,
                success: function(response){
                    alert('Ultimate card Created Successfully');
                }
            });
         }

        function genrate_bestcard(id){
            $.ajax({
                url: "<?=base_url()?>index.php/examples/best_cards",
                type: "post",
                data: "txt_category="+id,
                success: function(response){
                    alert('Ultimate card Created Successfully');
                }
            });
         }

    </script>
        
    <script>
    </script>

  </body>
</html>
