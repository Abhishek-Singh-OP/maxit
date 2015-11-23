<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once('includes/head.php'); ?>
    <link type="text/css" rel="stylesheet" href="<?=base_url()?>assets/css/bootstrap-multiselect.css">
    <link type="text/css" rel="stylesheet" href="<?=base_url()?>assets/css/jquery.tokenize.css">
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.0/css/bootstrap-datepicker.css">
    <link href="<?=base_url()?>assets/css/jquery.tagit.css" rel="stylesheet" type="text/css">
    <!--<link href="<?=base_url()?>assets/css/tagit.ui-zendesk.css" rel="stylesheet" type="text/css">
     -->
    <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/flick/jquery-ui.css">
    <style>
      .tokenize-dropdown {height: 34px !important;width: 100%;}
    </style>
    <!--<script type='text/javascript' src='<?=base_url()?>javascriptspellcheck/include.js'></script>
    <script type='text/javascript'>$Spelling.SpellCheckAsYouType('txt_offer')</script> 
    <script type='text/javascript'>$Spelling.SpellCheckAsYouType('txt_tnc')</script> 
    <script type='text/javascript'>$Spelling.SpellCheckAsYouType('txt_imp_tnc')</script>-->
</head>
<body onload="initialize()">

  <section id="container">
    <!-- main content !-->
    <section id="main-content shiftleft">
    <?php 
      if($this->session->flashdata('msg')!='' || $this->session->flashdata('msg')!=null){
        if($this->session->flashdata('msg') == 'success'){
          echo "<p style='height:25px;background-color:lightgreen;text-align:center'>Offers Added Successfully</p>";
        }
        else
        {
          echo "<p style='height:25px;background-color:red;text-align:center'>Some Error Occured! Please Try again</p>";
        }
      } 
    ?>
      <section class="wrapper site-min-height">
            <h1 class="shiftright">Offers Form</h1>
            <hr>
            <div class="row mt shiftright">
              <div class="col-md-10">
              <form id="frm_est" onsubmit="return validate_form();" action="<?=base_url()?>index.php/new_offers/add_new_offers" method="post">
                <h3>Offer Heading</h3>
                <input type="text" name="txt_offer" onblur="validatedata(this,this.value)" id="txt_offer" class="form-control" placeholder="Offer Heading" value=""  required/>
              
              <h3>Type</h3>
                <select class="form-control" name="txt_type" id="txt_type">
                  <option value="" selected disabled>Select</option>
                  <option value="1">Credit Card Offers</option>
                  <option value="2">Exclusive Offers</option>
                  <option value="3">Aggregate Offers</option>
                  <option value="4">Debit Card Offers</option>
                  <option value="5">Generic Offers</option>
                </select>
                
                <h3>Maxit Delight Points</h3>
                <input type="text" name="txt_points" disabled id="txt_points" class="form-control" value="" placeholder = "Maxit Delight Points" pattern="^[0-9]+(.([0-9]{1,2}))?" title="Only Number and two decimal allowed"/>
              
                <h3>Voucher Code</h3>
                <input type="text" name="txt_vcode" disabled id="txt_vcode" class="form-control" value="" placeholder = "Voucher code" />

                <div class="row">                
                  <div class="col-md-3">
                  <h3>Bank Name</h3>
                    <select class="form-control" name="txt_bank_name" id="txt_bank_name" disabled>
                      <option value="">Select</option>
                      <?php
                      foreach($banks as $bank){
                        ?>
                        <option value="<?=$bank->issuing_organization?>"><?=$bank->issuing_organization?></option>
                        <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="col-md-3">
                  <h3>Affilation</h3>
                    <select class="form-control" name="txt_affilation[]" id="txt_affilation" multiple="true" disabled>
                        <?php
                          foreach($affilations as $affilation){
                            ?>
                            <option value="<?=$affilation->affiliation?>"><?=$affilation->affiliation?></option>
                            <?php
                          }
                        ?>
                    </select>
                  </div>
                  <div class="col-md-3">
                  <h3>Affilation Category</h3>
                  <select class="form-control" name="txt_affilation_category[]" id="txt_affilation_category" multiple="true" disabled>
                  </select>
                  </div>
                  <div class="col-md-3">
                  <h3>Cards</h3>
                    <select class="form-control" name="txt_cards" id="txt_cards" disabled>
                      <option value="">Select</option>
                    </select>
                  </div>
                </div>
                <div class="row clearfix" >
                  <div class="col-md-12" id="idcardno" style="display: none;background-color: #CCC;padding: 10PX 15PX;border-radius: 5px;margin: 2% 0%;word-wrap: break-word"></div>
                </div>
                <input type="hidden" name="selectedcards" id="selectedcards">
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
                <select class="form-control" name="txt_offer_subcategory" id="txt_offer_subcategory" >
                  <option value="">Select</option>
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
                <input type="text" name="txt_amount" id="txt_amount" class="form-control" value="" placeholder = "Amount" pattern="^[0-9]+(.([0-9]{1,2}))?" title="Only Number and two decimal allowed" onkeypress="return isNumber(event)" />

                <h3>Valid Till</h3>
                <input type="text" name="txt_valid_till" id="txt_valid_till" class="form-control" value="" placeholder = "" />

                <h3>Offer Url</h3>
                <input type="url" name="txt_offer_url" id="txt_offer_url" class="form-control" value="" placeholder = "Offer Url" required  />

                <h3>Terms and Conditions</h3>
                <textarea name="txt_tnc"  onblur="validatedata(this,this.value)" id="txt_tnc" cols="90" rows="5" maxlength='1000' class="form-control" placeholder = "TNC"></textarea>

                <h3>Important Terms and Conditions</h3>
                <textarea name="txt_imp_tnc" onblur="validatedata(this,this.value)" id="txt_imp_tnc" cols="90" rows="5" class="form-control" placeholder = "Important TNC"></textarea>

          <!-- <h3>Offer Content</h3>
                <textarea name="txt_offer_content"  onblur="validatedata(this,this.value)" id="txt_offer_content" cols="90" rows="5" class="form-control" placeholder = "Offer Content" required ></textarea>
                 -->
                <h3>Week Days</h3>
                <select multiple="multiple" class="tokenize-dropdown" name="txt_week_days[]" id="txt_week_days">
                  <option value="Monday">Monday</option>
                  <option value="Tuesday">Tuesday</option>
                  <option value="Wednesday">Wednesday</option>
                  <option value="Thursday">Thursday</option>
                  <option value="Friday">Friday</option>
                  <option value="Saturday">Saturday</option>
                  <option value="Sunday">Sunday</option>
                </select>

                <h3>Establishment</h3>
                <select name="txt_establishment_existing" id="txt_establishment_existing" class="form-control">
                  <option value="" selected="true">Select</option>
                  <option value="new">Add New</option>
                  <?php
                    foreach($establishments as $establishment){
                      ?>
                      <option value="<?=$establishment->id?>"><?=$establishment->establishment?></option>
                      <?php
                    }
                  ?>
                </select>
                
                <div id="divotherestablishment" style="display: none;background-color: #CCC;padding: 10PX 15PX;border-radius: 5px;margin: 2% 0%;">
                    <h3>Establisment Status</h3>
                    <select class="form-control" id="txt_est_status" name="txt_est_status" value="">
                      <option value="" selected="true" disabled="true">Select Status</option>
                      <option value="Online">Online</option>
                      <option value="Offline">Offline</option>
                    </select>

                    <h3>New Establishment</h3>
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
                </div>
                <div id="divapplicable">
                  <h3>Applicable Across Category</h3>
                  <select multiple="multiple" class="tokenize-dropdown" name="txt_applicable_across_category[]" id="txt_applicable_across_category">
                    <?php
                    foreach($app_categories as $categories_row){
                      ?>
                        <option value="<?=$categories_row->applicable_category_id?>"><?=$categories_row->category?></option>
                      <?php
                    }
                    foreach($app_subcategories as $subcat){
                    ?>
                      <option value="<?=$subcat->applicable_category_id?>"><?=$subcat->category?></option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
                
                <h3>Specific Location Exists</h3>
                <!-- <input type="text" name="txt_specific_location_exists" id="txt_specific_location_exists" class="form-control" /> -->
                <select name="txt_specific_location_exists" id="txt_specific_location_exists" class="form-control" disabled>
                  <option value="0">No</option>
                  <option value="1">Yes</option>
                </select>

                <div id="divlocationexists" style="display:none">
                  <h3>Offer at Specific Location Only</h3>
                  <input type="text" name="txt_location[]" id="txt_location" class="form-control" placeholder="Select location">
                  <!-- <select multiple="multiple" name="txt_location[]" id="txt_location" class="tokenize-dropdown">
                    <?php
                      foreach($cities as $city){
                        ?>
                        <option value="<?=$city->city?>"><?=$city->city?></option>
                        <?php
                      }
                    ?>
                  </select> -->
                  <h3>Latitude</h3>
                  <input type="text" name="txt_latitude" id="txt_latitude" class="form-control" value="" placeholder = "Latitude" />
                  <h3>Longtitude</h3>
                  <input type="text" name="txt_longtitude" id="txt_longtitude" class="form-control" value="" placeholder = "Longitude" />
                </div> 
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

    <?php include_once('includes/site_bottom_scripts_offers.php'); ?>

    <link rel="stylesheet" href="<?=base_url()?>assets/css/chosen/chosen.min.css">
    <script src="<?=base_url()?>assets/css/chosen/chosen.jquery.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>
    <script src="<?=base_url()?>assets/js/bootstrap-multiselect.js"></script>
    <script src="<?=base_url()?>assets/js/jquery.tokenize.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.0/js/bootstrap-datepicker.min.js"></script>
     <!--<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?libraries=places"></script>-->
    <script>

      $(window).load(function(){
        //initialize2();
      });

      var autocomplete;
      function initialize() {
        autocomplete = new google.maps.places.Autocomplete(
          (document.getElementById('txt_establishment')),
        { types: ['establishment'] });
        google.maps.event.addListener(autocomplete, 'place_changed', function() {});
      }

      /*var autocomplete2;
      function initialize2() {
        autocomplete2 = new google.maps.places.Autocomplete(
          (document.getElementById('txt_location')),
        { types: ['geocode','establishment'] });
        google.maps.event.addListener(autocomplete2, 'place_changed', function() {
          var place = autocomplete2.getPlace();
          console.log(place);
          $('#txt_latitude').val(place.geometry.location.lat());
          $('#txt_longtitude').val(place.geometry.location.lng());
          //alert(place.geometry.location.lat());
        });
      }*/

      function validate_form(){
        var estoption = $("#txt_establishment_existing").val();
        var applicable_across_category = $("#txt_applicable_across_category option:selected").text();
        var offer_type = $("#txt_offer_type").val();
        var amount = $("#txt_amount").val();
        if((offer_type == "Discount Percentage" || offer_type == "Discount" || offer_type == "Cashback Percentage" || offer_type == "Cashback" || offer_type == "Reward Point Multiplier" || offer_type == "Bonus Rewards Points / Miles") && amount == ""){
          alert("Please fill up the amount field for "+offer_type+" offer type.");
            return false;
        }

        var type = $("#txt_type").val();
        if(type==""){
          alert("please select type");
          return false;
        }

        if(estoption == "" && applicable_across_category == ""){
          alert("please fill up establishment name or applicable_across_category.");
          return false;
        }
        else if(estoption=='new'){
          if($('#txt_est_status').val()=="" || $('#txt_establishment').val()=="" || $('#txt_class').val()=="" ){
            alert("Please fill all details for new establishment");
            return false;
          }
          else if($('#txt_est_status').val()=="Online" && ($('#txt_establishment').val()!=$('#txt_url').val() || $('#txt_url').val()=="")){
            alert("Establisment and URL must be same when status is online");
            return false;
          }
        }

        var lat = $("#txt_latitude").val();
        var lng = $("#txt_longtitude").val();
        var specific_location_exists = $("#txt_specific_location_exists").val();
        if(lat == "" && lng == "" && specific_location_exists == "1"){
          alert("Specific location exists cannot be Yes if no Lat and Lng are provided.");
          return false;
        }
        return true;
      }

      $(document).ready(function(){
        $("#frm_est")[0].reset();
        $("#txt_location").tagit({
                allowSpaces: true,
                singleFieldDelimiter: "|",
                autocomplete: {
                delay: 0,
                minLength: 2,
                source: function(request, response) {
                  var callback = function (predictions, status) {
                    if (status != google.maps.places.PlacesServiceStatus.OK) {
                      return;
                    }         
                    var data = $.map(predictions, function(item) {
                       if(item.place_id=="" || item.place_id==null){
                        //return item.place_id;
                      }
                      else{
                        return item.description+" :"+item.place_id;
                      }
                    });
                    response(data);
                  }   
                  var service = new google.maps.places.AutocompleteService();
                  service.getPlacePredictions(
                      {
                      input: request.term,
                       // types: ['(geocode)'],
                      // componentRestrictions: {country: 'INDIA'}
                      }, 
                    callback);
                  //service.getQueryPredictions({ input: request.term,componentRestrictions: {country: 'in'}, }, callback);
                }
              },
              afterTagAdded : function(event, ui) {
                  // do something special
                  var city = $($(ui.tag[0]).find("span")[0]).html();
                  //alert($("#txtlocation").val());
                  console.log(city);
                  var location = $('#txt_establishment_existing option:selected').text();
                  //var city = $('#txt_location').val();
                  if(location!='' && city!='' && city!=null){
                    $.ajax({
                      url: '<?=base_url()?>new_offers/callback_lat_long',
                      type: 'POST',
                      data: {location: location,city: city},
                    })
                    .done(function(data) {
                       var data1 = JSON.parse(data);
                       var lat = $('#txt_latitude').val();
                       var lng = $('#txt_longtitude').val();
                       if(lat==''){
                        $('#txt_latitude').val(data1.lat);
                       }
                       else{
                        var lat= lat+","+data1.lat;
                        $('#txt_latitude').val(lat);
                       }

                       if(lng==''){
                        $('#txt_longtitude').val(data1.lng);
                       }
                       else{
                        var lng= lng+","+data1.lng;
                        $('#txt_longtitude').val(lng);
                       }
                      console.log("success");
                    })
                    .fail(function() {
                      console.log("error");
                    })
                    .always(function() {
                      console.log("complete");
                    });
                  }
              },
              afterTagRemoved : function(event, ui) {
                  // do something special
                  console.log($($(ui.tag[0]).find("span")[0]).html());
                  var city = $("#txt_location").val();
                  var location = $('#txt_establishment_existing option:selected').text();
                  if(city!='' && city!=null){
                    $.ajax({
                      url: '<?=base_url()?>new_offers/callback_lat_long',
                      type: 'POST',
                      data: {location: location,city: city},
                    })
                    .done(function(data) {
                       var data1 = JSON.parse(data);
                        $('#txt_latitude').val(data1.lat);
                        $('#txt_longtitude').val(data1.lng);
                      console.log("success");
                    })
                    .fail(function() {
                      console.log("error");
                    })
                    .always(function() {
                      console.log("complete");
                    });
                  }
                  else{
                        $('#txt_latitude').val("");
                        $('#txt_longtitude').val("");
                  }
              }
        });
        //initialize2();
        //window.history.backward(1);
        //location.reload(true);
/*      Fetching Cities data from json api  
        $.ajax({
            url: 'https://raw.githubusercontent.com/David-Haim/CountriesToCitiesJSON/master/countriesToCities.json',
            type: 'GET',
          })
        .done(function(data) {
          var data = JSON.parse(data);
          var arrdata = data.India;
          $.ajax({
            url: '<?=base_url()?>index.php/admin/tempcities',
            type: 'POST',
            data: {jsondata: arrdata},
          })
          .done(function(data) {
            console.log(data)
            console.log("success");
          })
          .fail(function() {
            console.log("error");
          })
          .always(function() {
            console.log("complete");
          });
          console.log("success");
        })
        .fail(function() {
          console.log("error");
        })
        .always(function() {
          console.log("complete");
        });
*/        
        $('#txt_valid_till').datepicker({
          format: 'yyyy-mm-dd'
        });

        $("#txt_offer_type").change(function() {
          var offer_type = $("#txt_offer_type").val();
            if((offer_type == "Discount Percentage" || offer_type == "Discount" || offer_type == "Cashback Percentage" || offer_type == "Cashback" || offer_type == "Reward Point Multiplier" || offer_type == "Bonus Rewards Points / Miles")){
              $("#txt_amount").removeAttr('disabled');
            }
            else{
              $("#txt_amount").attr('disabled', 'true');
            }
        });

        $("#txt_type").change(function(event) {
          var type = $(this).val();
          if(type=="1"){
            $("#txt_points").attr('disabled', 'true');
            $("#txt_vcode").attr('disabled', 'true');
            $("#txt_cards").removeAttr('disabled');
            /*$("#txt_affilation_category").removeAttr('disabled');
            $("#txt_affilation").removeAttr('disabled');*/
            $("#txt_bank_name").removeAttr('disabled');

            $("#txt_affilation").multiselect('enable');
            $("#txt_affilation_category").multiselect('enable');
          }
          else if(type=="2"){
            $("#txt_points").removeAttr('disabled');
            $("#txt_vcode").removeAttr('disabled');
            $("#txt_cards").attr('disabled', 'true');
            /*$("#txt_affilation_category").attr('disabled', 'true');
            $("#txt_affilation").attr('disabled', 'true');*/
            $("#txt_bank_name").attr('disabled', 'true');

            $("#txt_affilation").multiselect('disable');
            $("#txt_affilation_category").multiselect('disable');
          }
          else if(type=="3"){
            $("#txt_points").attr('disabled', 'true');
            $("#txt_vcode").removeAttr('disabled');
            $("#txt_cards").attr('disabled', 'true');
            /*$("#txt_affilation_category").attr('disabled', 'true');
            $("#txt_affilation").attr('disabled', 'true');*/
            $("#txt_bank_name").attr('disabled', 'true');

            $("#txt_affilation").multiselect('disable');
            $("#txt_affilation_category").multiselect('disable');
          }
          else{
            $("#txt_points").removeAttr('disabled');
            $("#txt_vcode").removeAttr('disabled');
            $("#txt_cards").removeAttr('disabled');
            /*$("#txt_affilation_category").removeAttr('disabled');
            $("#txt_affilation").removeAttr('disabled');*/
            $("#txt_bank_name").removeAttr('disabled'); 

            $("#txt_affilation").multiselect('enable');
            $("#txt_affilation_category").multiselect('enable');
          }
        });

        $("#txt_category").change(function(){
          var category_id = $(this).val();
          $.ajax({
            url: "<?=base_url()?>index.php/new_offers/get_sub_category",
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
          
          var cat_id = $(this).val();

          $.ajax({
            url:'<?=base_url()?>new_offers/get_sub_categories/'+cat_id,
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
        var txtappcat = $('#txt_applicable_across_category').tokenize({
          displayDropdownOnFocus: true,
          newElements: false,
          onAddToken: function(value, text, e){
              //$('#txt_establishment_existing').attr('disabled', 'true');
              $('#txt_establishment_existing').multiselect('disable');
          },
          onRemoveToken: function(value, e){
            var option = $('#txt_applicable_across_category option:selected').text();
            if(option=="")
            {
              //$('#txt_establishment_existing').removeAttr('disabled');
              $('#txt_establishment_existing').multiselect('enable');
            }
            else
            {
              $('#txt_establishment_existing').multiselect('disable');
              //$('#txt_establishment_existing').attr('disabled', 'true');
            }
          }
        });
        $("#txt_affilation").multiselect({
          maxHeight: 200
        });
        $("#txt_affilation_category").multiselect({
          maxHeight: 200
        }); 
        
        $("#txt_establishment_existing").multiselect({
          enableCaseInsensitiveFiltering: true,
          maxHeight: 200
        });
        $("#txt_week_days").tokenize({
          displayDropdownOnFocus: true,
          newElements: false,
        });
        $("#txtlocation").blur(function(event) {
              var location = $('#txt_establishment_existing option:selected').text();
              var city = $(this).val();
              if(location!='' && city!='' && city!=null){
                $.ajax({
                  url: '<?=base_url()?>new_offers/callback_lat_long',
                  type: 'POST',
                  data: {location: location,city: city},
                })
                .done(function(data) {
                   //alert(data);
                   data1 = JSON.parse(data);
                  $('#txt_latitude').val(data1.lat);
                  $('#txt_longtitude').val(data1.lng);
                  console.log("success");
                })
                .fail(function() {
                  console.log("error");
                })
                .always(function() {
                  console.log("complete");
                });
              }
        });
        /*$("#txt_location").tokenize({
          displayDropdownOnFocus: true,
          onAddToken: function(value, text, e){
              var location = $('#txt_establishment_existing option:selected').text();
              var city = $('#txt_location').val();
              if(location!='' && city!='' && city!=null){
                $.ajax({
                  url: '<?=base_url()?>new_offers/callback_lat_long',
                  type: 'POST',
                  data: {location: location,city: city},
                })
                .done(function(data) {
                   var data1 = JSON.parse(data);
                  $('#txt_latitude').val(data1.lat);
                  $('#txt_longtitude').val(data1.lng);
                  console.log("success");
                })
                .fail(function() {
                  console.log("error");
                })
                .always(function() {
                  console.log("complete");
                });
              }
          },
          onRemoveToken: function(value, e){
            if($('#txt_location').val()=='' || $('#txt_location').val()==null){
              $('#txt_latitude').val('');
              $('#txt_longtitude').val('');
            }
            else{
              var location = $('#txt_establishment_existing option:selected').text();
              var city = $('#txt_location').val();
              if(location!='' && city!='' && city!=null){
                $.ajax({
                  url: '<?=base_url()?>admin/callback_lat_long',
                  type: 'POST',
                  data: {location: location,city: city},
                })
                .done(function(data) {
                   //alert(data);
                  data1 = JSON.parse(data);
                  $('#txt_latitude').val(data1.lat);
                  $('#txt_longtitude').val(data1.lng);
                  console.log("success");
                })
                .fail(function() {
                  console.log("error");
                })
                .always(function() {
                  console.log("complete");
                });
              }
            }
          }
        });*/
        /*$("#txt_applicable_across_category").tokenize({
          displayDropdownOnFocus: true
        });
        $("#txt_establishment_existing").tokenize({
          displayDropdownOnFocus: true
        });
        $("#txt_week_days").multiselect({
           includeSelectAllOption: true,
           enableCaseInsensitiveFiltering: true
        });
        $("#txt_location").multiselect({
           includeSelectAllOption: true,
           enableCaseInsensitiveFiltering: true,
            maxHeight: 200
        });
        $("#txt_applicable_across_category").multiselect({
           includeSelectAllOption: true,
           enableCaseInsensitiveFiltering: true,
            maxHeight: 200
        });
        $("#txt_establishment_existing").multiselect({
          includeSelectAllOption: true,
          enableCaseInsensitiveFiltering: true,
          maxHeight: 200
        });
        */

        $('#txt_bank_name').change(function() {
          var bank = $(this).val();
          $.ajax({
            url: '<?=base_url()?>new_offers/callback_affilation/',
            type: 'POST',
            data: {bank: bank},
          })
          .done(function(data) {
            $('#txt_affilation').find('option').remove().end().append(data);
            $('#txt_affilation_category').find('option').remove();
            $('#txt_cards').find('option').remove();
            $('#txt_affilation').val('').trigger('chosen:updated');
            $("#txt_affilation").multiselect('rebuild');
            setcardno();
            console.log("success");
          })
          .fail(function() {
            console.log("error");
          })
          .always(function() {
            console.log("complete");
          });
        });
        var affisset = false;
        var cardnos;
        $('#txt_affilation').change(function(event) {
           var bank = $('#txt_bank_name').val();
          var affilation = $(this).val();
          $.ajax({
            url: '<?=base_url()?>new_offers/callback_affilation_cat/',
            type: 'POST',
            //data: {affilation:affilation},
             data: {bank: bank,affilation:affilation},
          })
          .done(function(data) {
            $('#txt_affilation_category').find('option').remove().end().append(data);
            $('#txt_cards').find('option').remove();
            $('#txt_affilation_category').val('').trigger('chosen:updated');
            $('#txt_affilation_category').multiselect('rebuild');
            affisset = true;
            setcardno();
            console.log("success");
          })
          .fail(function() {
            console.log("error");
          })
          .always(function() {
            console.log("complete");
          });

        });

        $('#txt_affilation_category').change(function(event) {
          var bank = $('#txt_bank_name').val();
          if(bank==''){
            setcardno();
          }
          else{
            var affilation = $('#txt_affilation').val();
            var affilationcat = $(this).val();
            var cardno = $('#idcardno').html();
            $.ajax({
              url: '<?=base_url()?>new_offers/callback_affilation_cards/',
              type: 'POST',
              //data: {affilation:affilation,affilationcat:affilationcat},
               data: {bank: bank,affilation:affilation,affilationcat:affilationcat,cardn:cardnos},
            })
            .done(function(data) {
              $('#txt_cards').find('option').remove().end().append(data);
              $('#txt_cards').val('').trigger('chosen:updated');
              affisset = false;
              setcardno();
              console.log("success");
            })
            .fail(function() {
              console.log("error");
            })
            .always(function() {
              console.log("complete");
            });
          }
        });

        $('#txt_cards').change(function(event) {
          $("#idcardno").html($(this).val());
        });

        function setcardno()
        {
          var bank = $('#txt_bank_name').val();
          var affilation = $('#txt_affilation').val();
          var affilationcat = $('#txt_affilation_category').val();
          $.ajax({
            url: '<?=base_url()?>new_offers/callback_banknos',
            type: 'POST',
            data: {bank: bank,affilation:affilation,affilationcat:affilationcat},
          })
          .done(function(data) {
            if(affisset==true){
              cardnos =  data;
            }
            if(data!=""){
              $("#idcardno").html(data);
              $("#selectedcards").val(data);
            }
            else{
              $("#idcardno").html("No Cards found");
            }
              $("#idcardno").css('display', 'block');
            console.log(data);
            console.log("success");
          })
          .fail(function() {
            console.log("error");
          })
          .always(function() {
            console.log("complete");
          });
          
        }

        $('#txt_establishment_existing').change(function(event) {
          var option = $(this).val();
          if(option=='')
          {
              $('#divotherestablishment').css('display', 'none');
              $('#txt_specific_location_exists').attr('disabled', 'true');
              $('#txt_specific_location_exists').val("0");
              $('#divlocationexists').css('display', 'none');
              //$("#txt_applicable_across_category").multiselect('enable');
              txtappcat.enable();
            // $("#txt_applicable_across_category").removeAttr('disabled');
            //$('#divapplicable').css('display', 'block');
          }
          else if(option=='new')
          {
            $('#txt_specific_location_exists').removeAttr('disabled');
            txtappcat.disable();
            //$("#txt_applicable_across_category").multiselect('disable');
            // $("#txt_applicable_across_category").attr('disabled', 'true');
            $('#divotherestablishment').css('display', 'block');
            //$('#divapplicable').css('display', 'block');
          }
          else
          {
            $('#txt_specific_location_exists').removeAttr('disabled');
            txtappcat.disable();
            //$("#txt_applicable_across_category").multiselect('disable');
            // $("#txt_applicable_across_category").attr('disabled', 'true');
            $('#divotherestablishment').css('display', 'none');
            //$('#divapplicable').css('display', 'none');
          }
        });
/*
        $("#txt_applicable_across_category").change(function(event) {
          alert("Reached");
          var option = $(this).val();
          if(option==null)
          {
            //$('#txt_establishment_existing').multiselect('enable');
            $('#txt_establishment_existing').removeAttr('disabled');
          }
          else
          {
            //$('#txt_establishment_existing').multiselect('disable');
            $('#txt_establishment_existing').attr('disabled', 'true');;
          }
        });  
*/
        $("#txt_specific_location_exists").change(function(event) {
          var option = $(this).val();
          if(option == '0'){
            $('#divlocationexists').css('display', 'none');
          }
          else{
            $('#divlocationexists').css('display', 'block');
          }
        });   

        $("#txt_establishment").focusout(function(event) {
          var value = $(this).val();
          if(value!='')
          {
            $('#divapplicable').css('display', 'none');
          }
          else
          {
            $('#divapplicable').css('display', 'block');
          }
        });

        

      });
    
    function validatedata(thiscontrol,a)
    {
      var control = thiscontrol;
      if(a!=''){
        var patt = /^[a-zA-Z0-9\&@\%.-\s]+$/g
        var res = patt.test(a);
        var strconfirm=true;
        if(!res)
        {
          strconfirm =confirm("Junk Character detected! Do you want to proceed?");
        }
        else{
          var patt1 = /^[A-Z0-9]+[a-zA-Z0-9\&@\%.-\s]+/
          var patt2 = /(\s\s)+/g;
          var res1 = patt1.test(a);
          var res2 = patt2.test(a);
          if(!res1){
            strconfirm = confirm("Start with Capital letter! Do you want to proceed?");
          }
          else{
            if(res2){
              strconfirm = confirm("Double Space detected! Do you want to proceed?");
            }
          }
        }

          if(strconfirm==true){
          }
          else{
            control.focus();
          }
      }
    }
    /*$("#txt_amount").keypress(function(e) {
      if ((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105)) {
        return true;
      }
      else{
        e.returnvalue=false;
        return false;
      }
    });*/
        function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if(charCode==46){
              return true;
            }
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }
    </script>
</body>

</html>
