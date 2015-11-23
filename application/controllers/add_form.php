<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Add_form extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data["categories"] = $this->db->get("categories_master")->result();

		$data["subcategories"] = $this->db->get("subcategories_master")->result();

		$data["applicable"] = $this->db->query("SELECT applicable_category_id, category FROM categories_master UNION SELECT applicable_category_id, category FROM subcategories_master")->result();

		$this->load->view('admin/add_page', $data);
	}

	public function add_offers(){
		$data["categories"] = $this->db->get("categories_master")->result();

		$data["subcategories"] = $this->db->get("subcategories_master")->result();

		$data["applicable"] = $this->db->query("SELECT applicable_category_id, category FROM categories_master UNION SELECT applicable_category_id, category FROM subcategories_master")->result();

		$this->load->view('admin/add_page', $data);
	}

	public function add_est_form(){

		$esta_id 				  = 0;
		$est_name 				  = explode(",", $this->input->post("txt_establishment"));
		$status 				  = 'Offline';
		$class 					  = 'Regular';
		$applicable_cat		  	  = $this->input->post("txt_applicable_across_category");
		$offer_category_val       = $this->input->post('txt_applicable_across_category');
		$offer_weekdays       	  = $this->input->post('txt_week_days');
		$offer_category_final_val = "";
		$offer_weekdays_val 	  = "";

		if($offer_category_val != ''){
			foreach($offer_category_val as $vals){
				$offer_category_final_val .= $vals.", ";
			}
		}

		if($offer_weekdays != ''){
			foreach($offer_weekdays as $vals){
				$offer_weekdays_val .= $vals.", ";
			}
		}

		// echo $offer_category_final_val;
		// echo $offer_weekdays_val;
		// die();

		if($this->input->post("txt_url") != ''){
			$status = 'Online';
		}

		if($this->input->post("txt_class") != ''){
			$class = $this->input->post("txt_class");
		}

		// if($this->input->post('txt_applicable_across_category') != '' && $est_name != ''){
		// 	$applicable_cat = $this->input->post("txt_category");
		// }

		$esta = $this->db->query("SELECT * FROM establishment WHERE establishment = '".$this->input->post("txt_establishment")."' AND category = ".$this->input->post("txt_category")." AND offer_subcategory = ".$this->input->post("txt_offer_subcategory"));

		if($esta->num_rows() > 0){
			$esta_id = $esta->row()->id;
		} else {

			$upd_data_est = array(
				"establishment"      => $est_name[0],
				"address"    		 => $this->input->post('txt_address'),
				"url"                => $this->input->post("txt_url"),
				"status"             => $status,
				"class"              => $class,
				"category"           => $this->input->post("txt_category"),
				"offer_subcategory"  => $this->input->post("txt_offer_subcategory"),
				// "location"           => $this->input->post("txt_location"),
				// "latitude"           => $this->input->post("txt_latitude"),
				// "longtitude"         => $this->input->post("txt_longtitude")
			);

			$this->db->insert('establishment', $upd_data_est);
			$esta_id = $this->db->insert_id();
		}

		// $specific_location_exists = "no";
		// if($this->input->post("txt_latitude") != "" && $this->input->post("txt_longtitude") != ""){
		// 	$specific_location_exists = "yes";
		// }

		if($this->input->post("txt_specific_location_exists") == '1'){
			$city = $this->input->post("txt_location") . ', ' .$this->input->post("txt_location1") . ', ' .$this->input->post("txt_location2") . ', ' .$this->input->post("txt_location3") . ', ' .$this->input->post("txt_location4") . ', ' .$this->input->post("txt_location5") . ', ' .$this->input->post("txt_location6") . ', ' .$this->input->post("txt_location7") . ', ' .$this->input->post("txt_location8") . ', ' .$this->input->post("txt_location9") . ', ' .$this->input->post("txt_location10") . ', ' .$this->input->post("txt_location11") . ', ' .$this->input->post("txt_location12");
			$city = $this->input->post("txt_location") . ', ' .$this->input->post("txt_location1") . ', ' .$this->input->post("txt_location2");
			$locat = explode( ',', $city );

			// $location = $this->input->post("txt_location");
			// $city = explode( ',', $location );
			// $est_name = explode(",", $this->input->post("txt_establishment"));
			for ($i=0; $i < count($locat); $i++) {
				if($locat[$i] != ''){
					$address = $est_name[0].$locat[$i];
					$prepAddr = str_replace(' ','+',$address);

					$geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
					$output= json_decode($geocode);

					$lat = $output->results[0]->geometry->location->lat;
					$long = $output->results[0]->geometry->location->lng;

					$upd_data_offers = array(
						"establishment_id"           => $esta_id,
						"card_name"                  => $this->input->post("txt_card_name"),
						"offer"                      => $this->input->post("txt_offer"),
						"offer_type"                 => $this->input->post("txt_offer_type"),
						"amount"                     => $this->input->post("txt_amount"),
						"offer_category"           	 => $this->input->post("txt_category"),
						"offer_subcategory"  		 => $this->input->post("txt_offer_subcategory"),
						"valid_till"                 => date('Y-m-d', strtotime($this->input->post("txt_valid_till"))),
						"offer_url"                  => $this->input->post("txt_offer_url"),
						"tnc"                        => $this->input->post("txt_tnc"),
						"imp_tnc"                    => $this->input->post("txt_imp_tnc"),
						"offer_content"              => $this->input->post("txt_offer_content"),
						"applicable_across_category" => $offer_category_final_val,
						"week_days"                  => $offer_weekdays_val,
						"latitude"                   => $lat,
						"longtitude"                 => $long,
						"city"                 		 => $locat[$i],
						"specific_location_exists"   => '1',
						"manually_updated"   		 => '1'
					);
					// echo $address.'<br>Lat: '.$lat.'\tLong: '.$long.'<br>';

					$this->db->insert('offers', $upd_data_offers);
				}
			}
		} else {
			$upd_data_offers = array(
				"establishment_id"           => $esta_id,
				"card_name"                  => $this->input->post("txt_card_name"),
				"offer"                      => $this->input->post("txt_offer"),
				"offer_type"                 => $this->input->post("txt_offer_type"),
				"amount"                     => $this->input->post("txt_amount"),
				"offer_category"           	 => $this->input->post("txt_category"),
				"offer_subcategory"  		 => $this->input->post("txt_offer_subcategory"),
				"valid_till"                 => date('Y-m-d', strtotime($this->input->post("txt_valid_till"))),
				"offer_url"                  => $this->input->post("txt_offer_url"),
				"tnc"                        => $this->input->post("txt_tnc"),
				"imp_tnc"                    => $this->input->post("txt_imp_tnc"),
				"offer_content"              => $this->input->post("txt_offer_content"),
				"applicable_across_category" => $offer_category_final_val,
				"week_days"                  => $offer_weekdays_val,
				"city"                 		 => $this->input->post("txt_location"),
				"specific_location_exists"   => '0',
				"manually_updated"   		 => '1'
			);

			$this->db->insert('offers', $upd_data_offers);
		}
		redirect("add_form/add_offers");
	}

	public function get_sub_category(){
		$this->db->where("category_id", $this->input->post("txt_category"));
		$sub_categories = $this->db->get("subcategories_master")->result_array();
		$this->output->set_content_type('application/json')->set_output(json_encode($sub_categories));
	}

	// public function created_ids(){
	// 	$data = $this->db->get('subcategories_master');
	// 	$val = 11;
	// 	foreach ($data->result() as $value) {
	// 		$this->db->set('applicable_category_id', $val);
	// 		$this->db->where('id', $value->id);
	// 		$this->db->update('subcategories_master');
	// 		$val += 1;
	// 	}
	// }

}

	// public function dashboard1(){
	// 	$this->load->view('admin/dashboard1');
	// }

	// function readxl(){
 //        if (@$_FILES[csv][size] > 0) { 
	// 	    $file = @$_FILES[csv][tmp_name]; 
	// 	    $handle = fopen($file,"r"); 

	// 	    do {
	// 	    	$data = explode('";"', @$data_csv[0]); 
	// 	        if (@$data[0]) { 
	// 				$data1 = array(
 //   						'description' => addslashes($data[0]),
	// 					'zipsave_category' => addslashes($data[1]),
	// 					'zipsave_subcategory_1' => addslashes($data[2]),
	// 					'offline_online' => addslashes($data[3]),
	// 					'city' => addslashes($data[4]),
	// 					'establishment' => addslashes($data[5]),
	// 					'brand' => addslashes($data[6]),
	// 					'any_additional_info' => addslashes($data[7]),
	// 				);
	// 				$this->db->insert('rules', $data1);

	// 	        } 
	// 	    } while (@$data_csv = fgetcsv($handle,1000,';','"')); 
	// 	}		
	// }