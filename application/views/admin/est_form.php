<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once( 'includes/head.php'); ?>
    <link type="text/css" rel="stylesheet" href="<?=base_url()?>assets/css/bootstrap-multiselect.css">
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">

</head>
<body onload="initialize()">

  <section id="container">
    <!-- main content !-->
    <section id="main-content shiftleft">
      <section class="wrapper site-min-height">
            <h1 class="shiftright">Establishment Form</h1>
            <hr>
            <div class="row mt shiftright">
              <div class="col-md-6">
              <form id="frm_est" onsubmit="return validate_form();" action="<?=base_url()?>index.php/admin/save_est_form" method="post">
                <input type="hidden" name="txt_offer_id" id="txt_offer_id" value="<?=$offer_data->id?>" />
                <h3>Offer Heading</h3>
                <input type="text" name="txt_offer" id="txt_offer" class="form-control" value="<?=$offer_data->offer?>" required />

                <h3>Card Name</h3>
                <textarea name="txt_card_name" id="txt_card_name" class="form-control" cols="30" rows="10" readonly><?=$offer_data->card_name?></textarea>

                <h3>Offer Category</h3>
                <input type="hidden" name="txt_offer_category" id="txt_offer_category" value="<?=$offer_data->offer_category?>" />
                <select class="form-control" name="txt_category" id="txt_category">
                  <option value="">Select</option>
                  <?php
                  foreach($categories as $categories_row){
                    $is_selected = "";
                    if($categories_row->id == $offer_data->offer_category){
                        $is_selected = "selected";
                    }
                    ?>
                    <option <?=$is_selected?> value="<?=$categories_row->id?>"><?=$categories_row->category?></option>
                    <?php
                  }
                  ?>
                </select>
                <h3>Offer Subcategory</h3>
                <input type="hidden" name="txt_offer_sub_category" id="txt_offer_sub_category" value="<?=$offer_data->offer_subcategory?>" />
                <select name="txt_offer_subcategory" id="txt_offer_subcategory" class="form-control">
                  <?php
                    foreach($subcategories as $subcategories_row){
                      $is_selected2 = "";
                      if($subcategories_row->id == $offer_data->offer_subcategory){
                        $is_selected2 = "selected";
                      }
                      ?>
                      <option <?=$is_selected2?> value="<?=$subcategories_row->id?>"><?=$subcategories_row->category?></option>
                      <?php
                    }
                  ?>
                </select>

                <h3>Offer Type</h3>
                <select class="form-control" id="txt_offer_type" name="txt_offer_type" value="<?=$offer_data->offer_type?>">
                  <option value="">Select Option</option>
                  <option value="<?=$offer_data->offer_type?>" selected><?=$offer_data->offer_type?></option>
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
                <input type="text" name="txt_amount" id="txt_amount" class="form-control" value="<?=$offer_data->amount?>" />

                <h3>Offer Url</h3>
                <input type="url" name="txt_offer_url" id="txt_offer_url" class="form-control" value="<?=$offer_data->offer_url?>" readonly />

                <h3>Terms and Conditions</h3>
                <textarea name="txt_tnc" id="txt_tnc" cols="90" rows="5" class="form-control"><?=$offer_data->tnc?></textarea>

                <h3>Important Terms and Conditions</h3>
                <textarea name="txt_imp_tnc" id="txt_imp_tnc" cols="90" rows="5" class="form-control"><?=$offer_data->imp_tnc?></textarea>

                <h3>Offer Content</h3>
                <textarea name="txt_offer_content" id="txt_offer_content" cols="90" rows="5" class="form-control" required><?=$offer_data->offer_content?></textarea>

                <h3>Week Days</h3>
                <input type="text" name="txt_week_days" id="txt_week_days" class="form-control" value="<?=$offer_data->week_days?>" />

                <h3>Establishment</h3>
                <input type="hidden" name="txt_establishment_id" value="<?=$offer_data->establishment_id?>" />
                <input type="text" name="txt_establishment" id="txt_establishment" class="form-control" value="<?=$esta_data->establishment?>" required />

                <h3>Url</h3>
                <input type="url" name="txt_url" id="txt_url" class="form-control" value="<?=$esta_data->url?>" />

                <h3>Class</h3>
                <select class="form-control" id="txt_class" name="txt_class" value="<?=$esta_data->class?>">
                  <option value="">Select Option</option>
                  <option value="<?=$esta_data->class?>" selected><?=$esta_data->class?></option>
                  <option value="Regular">Regular</option>
                  <option value="Sponsored">Sponsored</option>
                  <option value="Premium">Premium</option>
                  <option value="Popular">Popular</option>
                </select>

                <h3>Offer in specific cities only</h3>
                <input type="text" name="txt_location" id="txt_location" class="form-control" value="<?=$offer_data->city?>" />

                <h3>specific_location_exists</h3>
                <select name="txt_specific_location_exists" id="txt_specific_location_exists" class="form-control">
                  <option value="0">No</option>
                  <option value="1">Yes</option>
                </select>

                <h3>Latitude</h3>
                <input type="text" name="txt_latitude" id="txt_latitude" class="form-control" value="<?=$esta_data->latitude?>" />

                <h3>Longtitude</h3>
                <input type="text" name="txt_longtitude" id="txt_longtitude" class="form-control" value="<?=$esta_data->longtitude?>" />

                <h3>specific_location_exists</h3>
                <select name="txt_specific_location_exists" id="txt_specific_location_exists" class="form-control">
                  <option value="0">No</option>
                  <option value="1">Yes</option>
                </select>

                <h3>Applicable Across Category</h3>
                <select class="form-control" name="txt_applicable_across_category" id="txt_applicable_across_category">
                  <option value="">Select</option>
                  <?php
                  foreach($categories as $categories_row){
                    $is_selected = "";
                    if($offer_data->applicable_across_category == $categories_row->id){
                      $is_selected = "selected";
                    }
                    ?>
                      <option <?=$is_selected?> value="<?=$categories_row->id?>"><?=$categories_row->category?></option>
                    <?php
                  }
                  ?>
                </select>
                <br><br>

                <div class= 'col-md-12'>
                  <div class="col-md-6" style="float: left">
                    <input type="submit" value="Save" class="form-control btn btn-warning" style="width:200px;" />
                  </div>
                  <div class="col-md-6">
                    <a href="<?=base_url()?>index.php/admin/mark_verify/<?=$offer_data->id?>" class="form-control btn btn-danger" style="width:200px;">Need to Verify</a>
                  </div>
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
    <script src="<?=base_url()?>assets/css/chosen/chosen.jquery.min.js"></script>

    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>
    <script src="<?=base_url()?>assets/js/bootstrap-multiselect.js"></script>

    <script>

      var autocomplete;
      function initialize() {
        autocomplete = new google.maps.places.Autocomplete(
          (document.getElementById('txt_establishment')),
        { types: ['establishment'] });
        google.maps.event.addListener(autocomplete, 'place_changed', function() {});
      }

      function validate_form(){
        
        var est_name = $("#txt_establishment").val();
        var applicable_across_category = $("#txt_applicable_across_category").val();
        if(est_name == "" && applicable_across_category == ""){
          alert("please fill up establishment name or applicable_across_category.");
          return false;
        }

        var lat = $("#txt_latitude").val();
        var lng = $("#txt_longtitude").val();
        var specific_location_exists = $("#txt_specific_location_exists").val();
        if(lat == "" && lng == "" && specific_location_exists == "1"){
          alert("Specific location exists cannot be Yes if no Lat and Lng are provided.");
          return false;
        }

        var offer_type = $("#txt_offer_type").val();
        var amount = $("#txt_amount").val();
        if((offer_type == "Discount Percentage" || offer_type == "Discount" || offer_type == "Cashback Percentage" || offer_type == "Cashback" || offer_type == "Reward Point Multiplier" || offer_type == "Free reward points") && amount == ""){
          alert("Please fill up the amount field for "+offer_type+" offer type.");
            return false;
        }
        return true;
      }

      $(document).ready(function(){

        $("#txt_category").change(function(){
          var category_id = $(this).val();
          $.ajax({
            url: "<?=base_url()?>index.php/admin/get_sub_category",
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

        $(".chosen-select").chosen({max_selected_options: 5});


        $('#offer_category').change(function(){
          
          var cat_id = $(this).val()

          $.ajax({
            url:'<?=base_url()?>admin/get_sub_categories/'+cat_id,
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
