<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once( 'includes/head.php'); ?>
    <link type="text/css" rel="stylesheet" href="<?=base_url()?>assets/css/bootstrap-multiselect.css">
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.0/css/bootstrap-datepicker.css">
</head>
<body onload="initialize()">

  <section id="container">
    <!-- main content !-->
    <section id="main-content shiftleft">
      <section class="wrapper site-min-height">
            <h1 class="shiftright">Offers Form</h1>
            <hr>
            <div class="row mt shiftright">
              <div class="col-md-6">
              <form id="frm_est" onsubmit="return validate_form();" action="<?=base_url()?>index.php/add_form/add_est_form" method="post">
                <h3>Offer Heading</h3>
                <input type="text" name="txt_offer" id="txt_offer" class="form-control" placeholder="Offer Heading" value="" required />

                <h3>Card Name</h3>
                <textarea name="txt_card_name" id="txt_card_name" class="form-control" cols="30" rows="10" required></textarea>

                <h3>Offer Category</h3>
                <select class="form-control" name="txt_category" id="txt_category">
                  <option value="">Select</option>
                  <?php
                  foreach($categories as $categories_row){
                    ?>
                    <option value="<?=$categories_row->id?>"><?=$categories_row->category?></option>
                    <?php
                  }
                  ?>
                </select>

                <h3>Offer Subcategory</h3>
                <select name="txt_offer_subcategory" id="txt_offer_subcategory" class="form-control">
                  <?php
                    foreach($subcategories as $subcategories_row){
                      ?>
                      <option value="<?=$subcategories_row->id?>"><?=$subcategories_row->category?></option>
                      <?php
                    }
                  ?>
                </select>

                <h3>Offer Type</h3>
                <select class="form-control" id="txt_offer_type" name="txt_offer_type" value="">
                  <option value="">Select Option</option>
                  <option value="Discount">Discount</option>
                  <option value="Cashback">Cashback</option>
                  <option value="Discount Percentage">Discount In Percentage</option>
                  <option value="Cashback Percentage">Cashback In Percentage</option>
                  <option value="EMI">EMI</option>
                  <option value="Free Gifts">Free Gifts</option>
                  <option value="Lounge Access">Lounge Access</option>
                  <option value="Upgrades And Privileges">Upgrades And Privileges</option>
                  <option value="Miscellaneous">Miscellaneous</option>
                  <option value="Reward Point Multiplier">Reward Point Multiplier</option>
                  <option value="Bonus Rewards Points / Miles">Bonus Rewards Points / Miles</option>
                </select>

                <h3>Amount</h3>
                <input type="text" name="txt_amount" id="txt_amount" class="form-control" value="" placeholder = "Amount" />

                <h3>Valid Till</h3>
                <input type="text" name="txt_valid_till" id="txt_valid_till" class="form-control" value="" placeholder = "" />

                <h3>Offer Url</h3>
                <input type="url" name="txt_offer_url" id="txt_offer_url" class="form-control" value="" placeholder = "Offer Url" required />

                <h3>Terms and Conditions</h3>
                <textarea name="txt_tnc" id="txt_tnc" cols="90" rows="5" class="form-control" placeholder = "TNC"></textarea>

                <h3>Important Terms and Conditions</h3>
                <textarea name="txt_imp_tnc" id="txt_imp_tnc" cols="90" rows="5" class="form-control" placeholder = "Important TNC"></textarea>

                <h3>Offer Content</h3>
                <textarea name="txt_offer_content" id="txt_offer_content" cols="90" rows="5" class="form-control" placeholder = "Offer Content" required></textarea>

                <h3>Week Days</h3>
                <select name="txt_week_days[]" id="txt_week_days" placeholder="Select week days" class="form-control chosen-select" tabindex="8" multiple="true">
                  <option value="">Select Week Days</option>
                  <option value="Monday">Monday</option>
                  <option value="Tuesday">Tuesday</option>
                  <option value="Wednesday">Wednesday</option>
                  <option value="Thursday">Thursday</option>
                  <option value="Friday">Friday</option>
                  <option value="Saturday">Saturday</option>
                  <option value="Sunday">Sunday</option>
                </select>

                <h3>Establishment</h3>
                <input type="text" name="txt_establishment" id="txt_establishment" class="form-control" value="" placeholder = "Establishment" />

                <h3>Address</h3>
                <input type="text" name="txt_address" id="txt_address" class="form-control" value="" placeholder = "Address" />

                <h3>Url</h3>
                <input type="url" name="txt_url" id="txt_url" class="form-control" value="" placeholder = "Url" />

                <h3>Class</h3>
                <select class="form-control" id="txt_class" name="txt_class" value="">
                  <option value="">Select Option</option>
                  <option value="Regular">Regular</option>
                  <option value="Sponsored">Sponsored</option>
                  <option value="Premium">Premium</option>
                  <option value="Popular">Popular</option>
                </select>

                <h3>Offer in specific cities only</h3>
                <input type="text" name="txt_location" id="txt_location" class="form-control" value="" placeholder = "City" />
                <div class="btncity">
	                <span class="btn btn-primary" onclick="addCities()"><i class="fa fa-plus"></i></span>
                </div>
				<div class="cityslide">
	                <h4>Location 2</h4>
	                <input type="text" name="txt_location1" id="txt_location1" class="form-control" value="" placeholder = "City" />
	                <h4>Location 3</h4>
	                <input type="text" name="txt_location2" id="txt_location2" class="form-control" value="" placeholder = "City" />
	                <h4>Location 4</h4>
	                <input type="text" name="txt_location3" id="txt_location3" class="form-control" value="" placeholder = "City" />
<!-- 	                <h4>Location 5</h4>
	                <input type="text" name="txt_location4" id="txt_location4" class="form-control" value="" placeholder = "City" />
	                <h4>Location 6</h4>
	                <input type="text" name="txt_location5" id="txt_location5" class="form-control" value="" placeholder = "City" />
	                <h4>Location 7</h4>
	                <input type="text" name="txt_location6" id="txt_location6" class="form-control" value="" placeholder = "City" />
	                <h4>Location 8</h4>
	                <input type="text" name="txt_location7" id="txt_location7" class="form-control" value="" placeholder = "City" />
	                <h4>Location 9</h4>
	                <input type="text" name="txt_location8" id="txt_location8" class="form-control" value="" placeholder = "City" />
	                <h4>Location 10</h4>
	                <input type="text" name="txt_location9" id="txt_location9" class="form-control" value="" placeholder = "City" />
	                <h4>Location 11</h4>
	                <input type="text" name="txt_location10" id="txt_location10" class="form-control" value="" placeholder = "City" />
	                <h4>Location 12</h4>
	                <input type="text" name="txt_location11" id="txt_location11" class="form-control" value="" placeholder = "City" />
	                <h4>Location 13</h4>
	                <input type="text" name="txt_location12" id="txt_location12" class="form-control" value="" placeholder = "City" /> -->
	                <input type="text" name="txt_location13" id="txt_location13" class="form-control" value="" placeholder = "City" style="display: none" />
				</div>
<!--                 <select name="txt_location[]" id="txt_location" placeholder="Select week days" class="form-control chosen-select" tabindex="8" multiple="true">
                  <option value="">Select Cities</option>
                </select> -->

                <h3>specific_location_exists</h3>
                <!-- <input type="text" name="txt_specific_location_exists" id="txt_specific_location_exists" class="form-control" /> -->
                <select name="txt_specific_location_exists" id="txt_specific_location_exists" class="form-control">
                  <option value="0">No</option>
                  <option value="1">Yes</option>
                </select>
  
<!--                 <h3>Latitude</h3>
                <input type="text" name="txt_latitude" id="txt_latitude" class="form-control" value="" placeholder = "Latitude" />

                <h3>Longtitude</h3>
                <input type="text" name="txt_longtitude" id="txt_longtitude" class="form-control" value="" placeholder = "Longitude" /> -->
        
                <h3>Applicable Across Category</h3>
                <select class="form-control chosen-select" name="txt_applicable_across_category[]" id="txt_applicable_across_category" multiple="true" tabindex="8">
                  <option value="">Select</option>
                  <?php
                  foreach($applicable as $aac){
                    ?>
                    <option value="<?=$aac->applicable_category_id?>"><?=$aac->category?></option>
                    <?php
                  }
                  ?>
                </select>

                <br><br>
                <div class= 'col-md-12'>
                  <div class="col-md-6" style="float: left">
                    <input type="submit" value="Save" class="form-control btn btn-warning" style="width:200px;" />
                  </div>
<!--                   <div class="col-md-6">
                    <a href="<?=base_url()?>index.php/admin/mark_verify/<?=$offer_data->id?>" class="form-control btn btn-danger" style="width:200px;">Need to Verify</a>
                  </div> -->
                </div>
              </form>

               <!-- <input type="text" name="txt_category" id="txt_category" class="form-control" /> -->
               <!--  <h3>id</h3>
                <input type="text" name="txt_id" id="txt_id" class="form-control" /> -->
                <!-- <h3>specific_location_exists</h3>
                <input type="text" name="txt_specific_location_exists" id="txt_specific_location_exists" class="form-control" /> -->
                <!-- <input type="text" name="txt_offer_subcategory" id="txt_offer_subcategory" class="form-control" /> -->
                <!-- <h3>establishment_logo</h3>
                <input type="text" name="txt_establishment_logo" id="txt_establishment_logo" class="form-control" /> -->
                <!-- <h3>ultimate_card</h3>
                <input type="text" name="txt_ultimate_card" id="txt_ultimate_card" class="form-control" /> -->
                <!-- <h3>best_card</h3>
                <input type="text" name="txt_best_card" id="txt_best_card" class="form-control" /> -->
                <!-- <h3>created_date</h3>
                <input type="text" name="txt_created_date" id="txt_created_date" class="form-control" /> -->
                <!-- <h3>id</h3>
                <input type="text" name="txt_id" id="txt_id" class="form-control" /> -->
                <!-- <h3>offer_id</h3>
                <input type="text" name="txt_offer_id" id="txt_offer_id" class="form-control" /> -->
                <!-- <input type="text" name="txt_card_name" id="txt_card_name" class="form-control" value="<?=$offer_data->card_name?>" readonly /> -->
                <!-- Take Offer category from above -->
                <!-- <h3>offer_category</h3>
                <input type="text" name="txt_offer_category" id="txt_offer_category" class="form-control" /> -->
                <!-- Take Offer Sub category from above -->
                <!-- <h3>offer_subcategory</h3>
                <input type="text" name="txt_offer_subcategory" id="txt_offer_subcategory" class="form-control" /> -->
                <!-- <h3>establishment_id</h3>
                <input type="text" name="txt_establishment_id" id="txt_establishment_id" class="form-control" /> -->
<!--                 <input type="text" name="txt_offer_type" id="txt_offer_type" class="form-control" value="<?=$offer_data->offer_type?>" /> -->

                <!-- <h3>valid_till</h3>
                <input type="text" name="txt_valid_till" id="txt_valid_till" class="form-control" /> -->
                <!-- Take latitude from above -->
                <!-- <h3>latitude</h3>
                <input type="text" name="txt_latitude" id="txt_latitude" class="form-control" /> -->
                <!-- Take longitude from above -->
                <!-- <h3>longtitude</h3>
                <input type="text" name="txt_longtitude" id="txt_longtitude" class="form-control" /> -->
                <!-- Take specific_location_exists from above -->
                <!-- <h3>specific_location_exists</h3>
                <input type="text" name="txt_specific_location_exists" id="txt_specific_location_exists" class="form-control" /> -->
                <!-- <input type="text" name="txt_applicable_across_category" id="txt_applicable_across_category" class="form-control" value="<?=$offer_data->applicable_across_category?>" /> -->
<!--                 <select class="form-control" id = "txt_week_days" name="txt_week_days" value = "<?=$offer_data->week_days?>" multiple>
                    <option value="<?=$offer_data->week_days?>" selected><?=$offer_data->week_days?></option>
                    <option value="Monday">Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday">Thursday</option>
                    <option value="Friday">Friday</option>
                    <option value="Saturday">Saturday</option>
                    <option value="Sunday">Sunday</option>
                </select> -->
                <!-- Taks city from location above -->
                <!-- <h3>city</h3>
                <input type="text" name="txt_city" id="txt_city" class="form-control" /> -->
                <!-- <h3>scrapper_log_url</h3>
                <input type="text" name="txt_scrapper_log_url" id="txt_scrapper_log_url" class="form-control" /> -->
                <!-- <h3>manually_updated</h3>
                <input type="text" name="txt_manually_updated" id="txt_manually_updated" class="form-control" /> -->
                <!-- <h3>created_date</h3>
                <input type="text" name="txt_created_date" id="txt_created_date" class="form-control" /> -->
              </div>
            </div>
            </section>
            <!-- /wrapper -->
        </section>
        <!-- /MAIN CONTENT -->

        <!--main content end-->
        <!--footer start-->
        <!--footer end-->
    </section>

    <?php include_once( 'includes/site_bottom_scripts.php'); ?>

    <link rel="stylesheet" href="<?=base_url()?>assets/css/chosen/chosen.min.css">
	<!-- // <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script> -->
    <script src="<?=base_url()?>assets/css/chosen/chosen.jquery.min.js"></script>

    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>
    <script src="<?=base_url()?>assets/js/bootstrap-multiselect.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.0/js/bootstrap-datepicker.min.js"></script>

    <script>

      $(window).load(function(){
        initialize();
        initialize1();
        initialize2();
        initialize3();
        initialize4();
        // initialize5();
        // initialize6();
        // initialize7();
        // initialize8();
        // initialize9();
        // initialize10();
        // initialize11();
        // initialize12();
        // initialize13();
      });

      var autocomplete;
      function initialize() {
        autocomplete = new google.maps.places.Autocomplete(
          (document.getElementById('txt_establishment')),
        { types: ['establishment'] });
        google.maps.event.addListener(autocomplete, 'place_changed', function() {});
      }

      var autocomplete1;
      function initialize1() {
        autocomplete1 = new google.maps.places.Autocomplete(
          (document.getElementById('txt_location')),
        { types: ['establishment'] });
        google.maps.event.addListener(autocomplete1, 'place_changed', function() {});
      }


      var autocomplete2;
      function initialize2() {
        autocomplete2 = new google.maps.places.Autocomplete(
          (document.getElementById('txt_location1')),
        { types: ['establishment'] });
        google.maps.event.addListener(autocomplete2, 'place_changed', function() {});
      }

      var autocomplete3;
      function initialize3() {
        autocomplete3 = new google.maps.places.Autocomplete(
          (document.getElementById('txt_location2')),
        { types: ['establishment'] });
        google.maps.event.addListener(autocomplete3, 'place_changed', function() {});
      }

      var autocomplete4;
      function initialize4() {
        autocomplete2 = new google.maps.places.Autocomplete(
          (document.getElementById('txt_location3')),
        { types: ['establishment'] });
        google.maps.event.addListener(autocomplete4, 'place_changed', function() {});
      }

      var autocomplete5;
      function initialize5() {
        autocomplete2 = new google.maps.places.Autocomplete(
          (document.getElementById('txt_location4')),
        { types: ['establishment'] });
        google.maps.event.addListener(autocomplete5, 'place_changed', function() {});
      }

      var autocomplete6;
      function initialize6() {
        autocomplete6 = new google.maps.places.Autocomplete(
          (document.getElementById('txt_location5')),
        { types: ['establishment'] });
        google.maps.event.addListener(autocomplete6, 'place_changed', function() {});
      }

      var autocomplete7;
      function initialize7() {
        autocomplete7 = new google.maps.places.Autocomplete(
          (document.getElementById('txt_location6')),
        { types: ['establishment'] });
        google.maps.event.addListener(autocomplete7, 'place_changed', function() {});
      }

      var autocomplete8;
      function initialize8() {
        autocomplete8 = new google.maps.places.Autocomplete(
          (document.getElementById('txt_location7')),
        { types: ['establishment'] });
        google.maps.event.addListener(autocomplete8, 'place_changed', function() {});
      }

      var autocomplete9;
      function initialize9() {
        autocomplete9 = new google.maps.places.Autocomplete(
          (document.getElementById('txt_location8')),
        { types: ['establishment'] });
        google.maps.event.addListener(autocomplete9, 'place_changed', function() {});
      }

      var autocomplete10;
      function initialize10() {
        autocomplete10 = new google.maps.places.Autocomplete(
          (document.getElementById('txt_location9')),
        { types: ['establishment'] });
        google.maps.event.addListener(autocomplete10, 'place_changed', function() {});
      }

      var autocomplete11;
      function initialize11() {
        autocomplete11 = new google.maps.places.Autocomplete(
          (document.getElementById('txt_location10')),
        { types: ['establishment'] });
        google.maps.event.addListener(autocomplete11, 'place_changed', function() {});
      }

      var autocomplete12;
      function initialize12() {
        autocomplete12 = new google.maps.places.Autocomplete(
          (document.getElementById('txt_location11')),
        { types: ['establishment'] });
        google.maps.event.addListener(autocomplete12, 'place_changed', function() {});
      }

      var autocomplete13;
      function initialize13() {
        autocomplete13 = new google.maps.places.Autocomplete(
          (document.getElementById('txt_location12')),
        { types: ['establishment'] });
        google.maps.event.addListener(autocomplete13, 'place_changed', function() {});
      }

      function validate_form(){
        
        var est_name = $("#txt_establishment").val();
        var applicable_across_category = $("#txt_applicable_across_category").val();
        if(est_name == "" && applicable_across_category == ""){
          alert("please fill up establishment name or applicable_across_category.");
          return false;
        }

        var offer_type = $("#txt_offer_type").val();
        var amount = $("#txt_amount").val();
        if((offer_type == "Discount Percentage" || offer_type == "Discount" || offer_type == "Cashback Percentage" || offer_type == "Cashback" || offer_type == "Reward Point Multiplier" || offer_type == "Free reward points") && amount == ""){
          alert("Please fill up the amount field for "+offer_type+" offer type.");
            return false;
        }

        // var city_id = '#txt_location';
        // var inc;

        // for (var i = 0; i < 13; i++) {
        // 	if($(city).val() != ''){
	       //  	$('#txt_location13').val() = $(city).val()+', '+$('#txt_location13').val()
        // 	}
        // 	city_id = city_id+inc;
        // }
        // console.log($('#txt_location13').val());

        // $('#txt_location13').val() = $('#txt_location').val() + ', ' + $('#txt_location1').val() + ', ' + $('#txt_location2').val() + ', ' + $('#txt_location3').val() + ', ' + $('#txt_location4').val() + ', ' + $('#txt_location5').val() + ', ' + $('#txt_location6').val() + ', ' + $('#txt_location7').val() + ', ' + $('#txt_location8').val() + ', ' + $('#txt_location9').val() + ', ' + $('#txt_location10').val() + ', ' + $('#txt_location11').val() + ', ' + $('#txt_location12').val();

        // var lat = $("#txt_latitude").val();
        // var lng = $("#txt_longtitude").val();
        // var specific_location_exists = $("#txt_specific_location_exists").val();
        // if(lat == "" && lng == "" && specific_location_exists == "1"){
        //   alert("Specific location exists cannot be Yes if no Lat and Lng are provided.");
        //   return false;
        // }

        return true;
      }

      $(document).ready(function(){

        $('#txt_valid_till').datepicker();

        $("#txt_category").change(function(){
          var category_id = $(this).val();
          $.ajax({
            url: "<?=base_url()?>index.php/add_form/get_sub_category",
            type: "post",
            data: "txt_category="+category_id,
            success: function(response){
              // console.log(response);
              var htm = "";
              for(var i=0;i<response.length;i++){
                //txt_offer_subcategory
                htm += '<option value="'+response[i].id+'">'+response[i].category+'</option>';
              }
              $("#txt_offer_subcategory").html(htm);
            }
          });
        });

        $('.btncity').click(function(){
        	$('.cityslide').fadeIn(1000);
        })

        $(".chosen-select").chosen({max_selected_options: 5});


        $('#offer_category').change(function(){
          
          var cat_id = $(this).val()

          $.ajax({
            url:'<?=base_url()?>add_form/get_sub_categories/'+cat_id,
            success: function(data){
              
              $('#offer_subcategory')
                .find('option')
                .remove()
                .end()
                .append(data);

                $('#offer_subcategory').val('').trigger('chosen:updated');
            }
          })

        })


          

      })
    </script>
</body>

</html>
