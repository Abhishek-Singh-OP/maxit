<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login');
		}
		$this->load->library('image_CRUD');
	}

	public function index()
	{
		$data['cardcount'] = $this->db->query("SELECT Count(*) as totalcards from card")->row();
		$data['establishmentcount'] = $this->db->query("SELECT Count(*) as totalest from establishment")->row();
		$data['offerscount'] = $this->db->query("SELECT Count(*) as totaloffers from offers")->row();
		$this->load->view('admin/dashboard',$data);
	}

	// public function take_backup(){
	// 	$offer_data = $this->db->get('offers');

	// 	foreach ($offer_data->result() as $value) {
	// 		$copy_data = array(
	// 			"offers_old_id"				 	 => $value->id,
	// 			"offer_id"                   	 => $value->offer_id,
	// 			"card_name"                  	 => $value->card_name,
	// 			"offer"                      	 => $value->offer,
	// 			"offer_category"           		 => $value->offer_category,
	// 			"offer_subcategory"  		 	 => $value->offer_subcategory,
	// 			"establishment"          	 	 => $value->establishment_id,
	// 			"offer_type"                 	 => $value->offer_type,
	// 			"amount"                     	 => $value->amount,
	// 			"offer_url"                  	 => $value->offer_url,
	// 			"tnc"                        	 => $value->tnc,
	// 			"imp_tnc"                    	 => $value->imp_tnc,
	// 			"offer_content"              	 => $value->offer_content,
	// 			"latitude"                   	 => $value->latitude,
	// 			"longtitude"                 	 => $value->longtitude,
	// 			"specific_location_exists"   	 => $value->specific_location_exists,
	// 			"applicable_across_category" 	 => $value->applicable_across_category,
	// 			"week_days"                  	 => $value->week_days,
	// 			"created_date"                   => $value->created_date,
	// 		);

	// 		$this->db->insert('offers_test', $copy_data);
	// 	}
	// }

	public function add_est_form(){

		if($this->input->post("txt_establishment") == ''){
			$esta_id = '';
		} else {

			$est_name = explode(",", $this->input->post("txt_establishment"));

			$status = 'Offline';
			if($this->input->post("txt_url") != ''){
				$status = 'Online';
			}

			$class = 'Regular';
			if($this->input->post("txt_class") != ''){
				$class = $this->input->post("txt_class");
			}

			$esta_id = 0;

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
					"location"           => $this->input->post("txt_location"),
					"category"           => $this->input->post("txt_category"),
					"offer_subcategory"  => $this->input->post("txt_offer_subcategory"),
					"latitude"           => $this->input->post("txt_latitude"),
					"longtitude"         => $this->input->post("txt_longtitude")
				);

				$this->db->insert('establishment', $upd_data_est);
				$esta_id = $this->db->insert_id();
			}
		}

		$specific_location_exists = "no";
		if($this->input->post("txt_latitude") != "" && $this->input->post("txt_longtitude") != ""){
			$specific_location_exists = "yes";
		}

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
			"applicable_across_category" => $this->input->post("txt_applicable_across_category"),
			"week_days"                  => $this->input->post("txt_week_days"),
			"latitude"                   => $this->input->post("txt_latitude"),
			"longtitude"                 => $this->input->post("txt_longtitude"),
			"city"                 		 => $this->input->post("txt_location"),
			"specific_location_exists"   => $this->input->post("txt_specific_location_exists"),
			"manually_updated"   => '1'
		);

		$this->db->insert('offers', $upd_data_offers);

		redirect("admin/add_offers");
	}

	public function add_new_offers(){
		$offer = $this->input->post('txt_offer');
		$type = $this->input->post('txt_type');
		if($type=="1"){
			$points ="";
			$vcode = "";
			$cardno = $this->input->post('selectedcards');
			$card = $this->input->post('txt_cards');
			$affilationcat = $this->input->post('txt_affilation_category');
			$affilation = $this->input->post('txt_affilation');
			$bankname = $this->input->post('txt_bank_name');
		}
		else if($type=="2"){
			$points = $this->input->post('txt_points');
			$vcode = $this->input->post('txt_vcode');
			$card = "";
			$cardno = "";
			$affilationcat = "";
			$affiliation = "";
			$bankname = "";
		}
		else if($type=="3"){
			$points ="";
			$vcode = $this->input->post('txt_vcode');
			$card = "";
			$cardno = "";
			$affilationcat = "";
			$affiliation = "";
			$bankname = "";
		}
		/*if($card!="" || ($bankname == "" && $affilationcat == "" && $affilationcat == "" && $card == "")){
			$cardno = $card;
		}
		else{
			$query = "SELECT GROUP_CONCAT(identity_no) as id_no FROM card where id!=''";	
			if($bankname!=""){
				$query .=" AND issuing_organization='".$bankname."'";
			}
			if($affilation!=""){
			 	$query .=" AND affiliation='".$affilation."'";
			}
			if($affilationcat!=""){
				$query .=" AND affiliation_category='".$affilationcat."'";
			}
			$result = $this->db->query($query)->result();
			$cardno = $result[0]->id_no;
		}*/
		/*if($card==""){
			if($affilationcat==""){
				if($affilation==""){
					$result = $this->db->query("SELECT GROUP_CONCAT(identity_no) as id_no FROM card where issuing_organization='".$bankname."'")->result();
					$cardno = $result[0]->id_no;
				}
				else{
					$result = $this->db->query("SELECT GROUP_CONCAT(identity_no) as id_no FROM card where affiliation='".$affilation."' AND issuing_organization='".$bankname."'")->result();
					$cardno = $result[0]->id_no;
				}
			}
			else{
				$result = $this->db->query("SELECT GROUP_CONCAT(identity_no) as id_no FROM card where affiliation_category='".$affilationcat."' AND affiliation='".$affilation."' And issuing_organization='".$bankname."'")->result();
				$cardno = $result[0]->id_no;
			}
		}
		else{
			$cardno = $card;
		}*/

		$offer_cat = $this->input->post('txt_category');
		$offer_sub_cat = $this->input->post('txt_offer_subcategory');
		$offer_type = $this->input->post('txt_offer_type');
		$amount = $this->input->post('txt_amount');
		$valid_till = $this->input->post('txt_valid_till');
		$offer_url = $this->input->post('txt_offer_url');
		$tnc = $this->input->post('txt_tnc');
		$imp_tnc = $this->input->post('txt_imp_tnc');
		//$offer_content = $this->input->post('txt_offer_content');
		$week_days_str = $this->input->post('txt_week_days');
		if($week_days_str!=''){
			$week_days = implode(",", $week_days_str);
		}
		else{
			$week_days = '';
		}
		if(!isset($_POST['txt_establishment_existing'])){
			$establishment_id = "";
			$applicable_across_category_arr = $this->input->post('txt_applicable_across_category');
			$applicable_across_category = implode(",",$applicable_across_category_arr);
		}
		else{
			$existingestablisment = $this->input->post('txt_establishment_existing');
			if($existingestablisment=="new"){
				$establishment_status = $this->input->post('txt_est_status');
				$newestablisment = $this->input->post('txt_establishment');
				$url = $this->input->post('txt_url');
				$address = $this->input->post('txt_address');
				$class = $this->input->post('txt_class');
				$establishment_arr = array(
					 "establishment" => $newestablisment,
					 "address" => $address,
					 "url" => $url,
					 "status" => $establishment_status,
					 "class" => $class,
					 "location" => $address,
					 "category" => $offer_cat,
					 "offer_subcategory" => $offer_sub_cat,
					 "establishment_logo" => "",
				);
				$this->db->insert('establishment', $establishment_arr);
				$establishment_id = $this->db->insert_id();
				$applicable_across_category = "";
			}
			else{
				$newestablisment = $existingestablisment;
				$establishment_id = $existingestablisment;
				$applicable_across_category = "";	
			}
		}
		/*$existingestablisment = $this->input->post('txt_establishment_existing');
		if($existingestablisment=="new"){
			$establishment_status = $this->input->post('txt_est_status');
			$newestablisment = $this->input->post('txt_establishment');
			$url = $this->input->post('txt_url');
			$address = $this->input->post('txt_address');
			$class = $this->input->post('txt_class');
			$establishment_arr = array(
				 "establishment" => $newestablisment,
				 "address" => $address,
				 "url" => $url,
				 "status" => $establishment_status,
				 "class" => $class,
				 "location" => $address,
				 "category" => $offer_cat,
				 "offer_subcategory" => $offer_sub_cat,
				 "establishment_logo" => "",
			);
			$this->db->insert('establishment', $establishment_arr);
			$establishment_id = $this->db->insert_id();
			$applicable_across_category = "";
		}
		else if($existingestablisment==""){
			$establishment_id = "";
			$applicable_across_category = $this->input->post('txt_applicable_across_category');
		}
		else{
			$establishment_id = $existingestablisment;
			$applicable_across_category = "";	
		}*/
		$offer_specified_cities_arr = $this->input->post('txt_location');
		if($offer_specified_cities_arr!=''){
			$offer_specified_cities = implode(",",$offer_specified_cities_arr);
		}
		else{
			$offer_specified_cities = '';		
		}
		$specific_location_exists = $this->input->post('txt_specific_location_exists');
		if($specific_location_exists=="1"){
			$location_exist="Yes";
			$address = 
			$lat = $this->input->post('txt_latitude');
			$long = $this->input->post('txt_longtitude');
		}
		else{
			$location_exist="No";
			$lat = "";
			$long = "";
		}
		$offers_arr = array(
		  "offer_id" => "",
		  "card_name" => $cardno,
		  "offer" => $offer,
		  "offer_category" => $offer_cat,
		  "offer_subcategory" => $offer_sub_cat,
		  "establishment_id" => $establishment_id,
		  "offer_type" => $offer_type,
		  "amount" => $amount,
		  "valid_till" => $valid_till,
		  "offer_url" => $offer_url,
		  "tnc" => $tnc,
		  "imp_tnc" => $imp_tnc,
		  // "offer_content" => $offer_content,
		  "latitude" => $lat,
		  "longtitude" => $long,
		  "specific_location_exists" => $location_exist,
		  "applicable_across_category" => $applicable_across_category,
		  "type" => $type,
		  "points" => $points,
		  "voucher_code" => $vcode,
		  "week_days" => $week_days,
		  "city" => $offer_specified_cities
		 );
		if($this->db->insert('offers', $offers_arr))
		{
			$this->session->set_flashdata('msg', 'success');
		}
		else
		{
			$this->session->set_flashdata('msg', 'error');
		}
		redirect("admin/temp_add_offers");
	}



	public function save_est_form(){
		//print_r($_POST);
		$est_name = explode(",", $this->input->post("txt_establishment"));

		$status = 'Offline';
		if($this->input->post("txt_url") != ''){
			$status = 'Online';
		}

		$class = 'Regular';
		if($this->input->post("txt_class") != ''){
			$class = $this->input->post("txt_class");
		}

		$upd_data_est = array(
			"establishment"      => $est_name[0],
			"url"                => $this->input->post("txt_url"),
			"status"             => $status,
			"class"              => $class,
			"location"           => $this->input->post("txt_location"),
			"category"           => $this->input->post("txt_category"),
			"offer_subcategory"  => $this->input->post("txt_offer_subcategory"),
			// "latitude"           => $this->input->post("txt_latitude"),
			// "longtitude"         => $this->input->post("txt_longtitude")
		);
		
		$this->db->where("id", $this->input->post("txt_establishment_id"));
		$this->db->update("establishment", $upd_data_est);
		
		$specific_location_exists = "no";
		if($this->input->post("txt_latitude") != "" && $this->input->post("txt_longtitude") != ""){
			$specific_location_exists = "yes";
		}

		$upd_data_offers = array(
			"establishment_id"           => $this->input->post("txt_establishment_id"),
			"card_name"                  => $this->input->post("txt_card_name"),
			"offer"                      => $this->input->post("txt_offer"),
			"offer_type"                 => $this->input->post("txt_offer_type"),
			"amount"                     => $this->input->post("txt_amount"),
			"offer_category"             => $this->input->post("txt_category"),
			"offer_subcategory"  		 => $this->input->post("txt_offer_subcategory"),
			"tnc"                        => $this->input->post("txt_tnc"),
			"imp_tnc"                    => $this->input->post("txt_imp_tnc"),
			"offer_content"              => $this->input->post("txt_offer_content"),
			"applicable_across_category" => $this->input->post("txt_applicable_across_category"),
			"week_days"                  => $this->input->post("txt_week_days"),
			"latitude"                   => $this->input->post("txt_latitude"),
			"longtitude"                 => $this->input->post("txt_longtitude"),
			"specific_location_exists"   => $this->input->post("txt_specific_location_exists"),
			"manually_updated"   => '2'
		);

		$this->db->where("id", $this->input->post("txt_offer_id"));
		$this->db->update("offers", $upd_data_offers);

		$next_id = $this->db->query("select * from offers where id > ".$this->input->post("txt_offer_id")."")->row();
		redirect("admin/est_form/".$next_id->id);			

	}

	public function add_offers(){

		$data["categories"] = $this->db->get("categories_master")->result();

		$data["subcategories"] = $this->db->get("subcategories_master")->result();

		$this->load->view('admin/est_form_add', $data);
	}

	public function mark_verify($id){
		$upd_data_offers = array(
			"manually_updated"   => '3'
		);

		$this->db->where("id", $id);
		$this->db->update("offers", $upd_data_offers);

		$next_id = $this->db->query("select * from offers where id > ".$id."")->row();
		redirect("admin/est_form/".$next_id->id);
	}

	public function est_form($id=null){
		//get data from offers table.
		$this->db->where("id", $id);
		$data["offer_data"] = $this->db->get("offers")->row();

		$data["categories"] = $this->db->get("categories_master")->result();

		//get data from establishment table.
		$this->db->where("id", $data["offer_data"]->establishment_id);
		$data["esta_data"] = $this->db->get("establishment")->row();

		//get subcategories to display initially.
		$this->db->where("category_id", $data["esta_data"]->category);
		$data["subcategories"] = $this->db->get("subcategories_master")->result();

		$this->load->view('admin/est_form', $data);
	}


	public function map_establishment(){
		$establishment = $this->db->get('establishment');

		foreach ($establishment->result() as $value) {
			$data = $this->db->query("SELECT establishment_id FROM offers WHERE establishment_id LIKE '%".$value->establishment."%' AND offer_category = '".$value->category."' AND offer_subcategory = '".$value->offer_subcategory."'");
			$this->db->query("UPDATE offers SET establishment_id = ".$value->id." WHERE establishment_id LIKE '%".$value->establishment."%' AND offer_category = '".$value->category."' AND offer_subcategory = '".$value->offer_subcategory."'");

			// $this->db->query("UPDATE offers SET establishment_id = ".$value->id." WHERE establishment_id LIKE '%".$establishment."%'");
			foreach ($data->result() as $val) {
				echo $val->establishment_id.' replaced by'.$value->establishment.'<br>';
			}
		}
	}


	public function editoffers($id = 2000) {

		$data['offers'] = $this->db->query('SELECT * FROM offers WHERE id = '.$id)->result();
		$data['categories'] = $this->db->get('categories_master')->result();
		$data['prev_link'] = $this->db->query('SELECT id FROM offers where id <'.$id.' ORDER BY id DESC LIMIT 1')->result();
		$data['nxt_link'] = $this->db->query('SELECT id FROM offers where id >'.$id.' ORDER BY id ASC LIMIT 1')->result();

		$this->load->view('admin/editoffers', $data);
	}

	public function ultimate_card(){
		$this->load->view('admin/ultimate_card');
	}	

	public function get_establishments_data(){
		$establishment_data = $this->db->get('establishment')->result_array();
		$this->output->set_content_type('application/json')->set_output(json_encode($establishment_data));
	}



	public function update_offer(){


		// $offer_category_val       = $this->input->post('offer_category');
		// $offer_category_final_val = "";

		// foreach($offer_category_val as $vals){
		// 	$offer_category_final_val .= $vals.",";
		// }

		// $offer_sub_category_val       = $this->input->post('offer_subcategory');
		// $offer_sub_category_final_val = "";

		// foreach($offer_sub_category_val as $vals1){
		// 	$offer_sub_category_final_val .= $vals1."|";
		// }
		//echo $offer_category_final_val;
		// $amount           = $this->input->post('amount');
		// $offer_type       = $this->input->post('module');
		// $offer_type       = $this->input->post('module1');
		// $offer_category   = $offer_category_final_val;
		// $id               = $this->input->post('id');
		// $tnc              = $this->input->post('tnc');
		// $tnc              = $this->input->post('city');
		// $establishment    = $this->input->post('establishment');
		// $manually_updated = 1;

		$id = $this->input->post('id');

		$res = array(
				'offer' 	    			  => $this->input->post('offer'),
				'offer_content' 			  => $this->input->post('fname'),
				'tnc' 	        			  => $this->input->post('tnc'),
				'establishment_id' 			  => $this->input->post('establishment'),
				'offer_type' 			  	  => $this->input->post('offer_type'),
				'applicable_across_category'  =>  $this->input->post('category'),
				'week_days' 				  => $this->input->post('week_days'),
				'imp_tnc' 				  => $this->input->post('need_to_know'),
				'amount' 				  	  => $this->input->post('amount'),
				'city' 				  	  	  => $this->input->post('city'),
				'specific_location_exists' 	  => $this->input->post('module1'),
			);

		$this->db->where('id', $this->input->post('id'));
		$this->db->update('offers', $res);


		$data['offers'] = $this->db->query('SELECT * FROM offers WHERE id = '.$id)->result();
		$data['prev_link'] = $this->db->query('SELECT id FROM offers where id <'.$id.' ORDER BY id DESC LIMIT 1')->result();
		$data['nxt_link'] = $this->db->query('SELECT id FROM offers where id >'.$id.' ORDER BY id ASC LIMIT 1')->result();

		$this->load->view('admin/editoffers', $data);
	}

	// Sellers Section
	public function offers()
	{
		$crud = new grocery_CRUD();
		//$crud->set_theme('datatables');
	    $crud->set_table('offers');
		$crud->set_subject('Users Data');
		$crud->columns('id','card_name','offer','offer_category','offer_subcategory','establishment_id', 'offer_type', 'amount','valid_till', 'offer_url', 'tnc', 'imp_tnc','latitude', 'longtitude', 'specific_location_exists', 'applicable_across_category', 'week_days', 'city','created_date');

		// $crud->columns('id', 'card_name', 'offer');

		// $crud->set_relation('card_name', 'card', 'card_name');
		$crud->set_field_upload('offer_logo','assets/uploads/offers_logo');
		$crud->set_relation('offer_category', 'categories_master', 'category');
		$crud->set_relation('offer_subcategory', 'subcategories_master', 'category');
		$crud->set_relation('establishment_id', 'establishment', 'establishment');

		//$crud->unset_columns('created_date');
		$crud->unset_add_fields('created_date');
		$crud->unset_edit_fields('created_date');
		
		$data = $crud->render();
		$this->load->view('admin/crud_view',$data);
	}

	public function expired_offers()
	{
		$crud = new grocery_CRUD();
		//$crud->set_theme('datatables');
		$dt = new DateTime();
		$now = $dt->format('Y-m-d');
		$crud->where('valid_till <',$now);
	    $crud->set_table('offers');
		$crud->set_subject('Users Data');
		$crud->columns('id','card_name','offer','offer_category','offer_subcategory','establishment_id', 'offer_type', 'amount','valid_till', 'offer_url', 'tnc', 'imp_tnc','latitude', 'longtitude', 'specific_location_exists', 'applicable_across_category', 'week_days', 'city');

		// $crud->columns('id', 'card_name', 'offer');

		// $crud->set_relation('card_name', 'card', 'card_name');
		$crud->set_field_upload('offer_logo','assets/uploads/offers_logo');
		$crud->set_relation('offer_category', 'categories_master', 'category');
		$crud->set_relation('offer_subcategory', 'subcategories_master', 'category');
		$crud->set_relation('establishment_id', 'establishment', 'establishment');

		$crud->unset_columns('created_date');
		$crud->unset_add_fields('created_date');
		$crud->unset_edit_fields('created_date');
		$crud->unset_add();
		$crud->unset_edit();
		$crud->unset_delete();
		
		$data = $crud->render();
		$this->load->view('admin/crud_view',$data);
	}

	// Categories Section
	// public function card()
	// {
	// 	$crud = new grocery_CRUD();
	//     $crud->set_table('card');
	// 	$crud->set_subject('Card');
		
	// 	$crud->set_relation('card_owner', 'users', 'username');

	// 	$crud->unset_columns('created_date');
	// 	$crud->unset_add_fields('created_date');
	// 	$crud->unset_edit_fields('created_date');

	// 	$data = $crud->render();
	// 	$this->load->view('admin/crud_view',$data);
	// }

	//Auction Section
	public function establishment()
	{
		$crud = new grocery_CRUD('default');
	    $crud->set_table('establishment');
		$crud->set_subject('establishment');
		$crud->columns('id', 'establishment', 'address', 'url', 'pincode', 'status', 'class', 'location', 'specific_location_exists', 'category', 'offer_subcategory', 'latitude', 'longtitude', 'establishment_logo', 'ultimate_card', 'best_card', 'created_date');
		$crud->order_by('establishment','asc');

		$crud->set_field_upload('establishment_logo','assets/uploads');

		//$crud->unset_columns('created_date');
		$crud->unset_add_fields('created_date');
		$crud->unset_edit_fields('created_date');
		$data = $crud->render();
		$this->load->view('admin/crud_view',$data);
	}

	public function demo(){
		// $address = "Media Mart (T3), Indira Gandhi International Airport, Airport Rd, New Delhi, India";
		// $url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=India";
		// $ch = curl_init();
		// curl_setopt($ch, CURLOPT_URL, $url);
		// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
		// curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		// $response = curl_exec($ch);
		// curl_close($ch);
		// $response_a = json_decode($response);
		// echo $lat = $response_a->results[0]->geometry->location->lat;
		// echo "<br />";
		// echo $long = $response_a->results[0]->geometry->location->lng;
		$address = '201 S. Division St., Ann Arbor, MI 48104'; // Google HQ
		$prepAddr = str_replace(' ','+',$address);
		 
		$geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
		 
		$output= json_decode($geocode);
		 
		$lat = $output->results[0]->geometry->location->lat;
		$long = $output->results[0]->geometry->location->lng;
		 
		echo $address.'<br>Lat: '.$lat.'<br>Long: '.$long;
	}

	// public function wallet()
	// {
	// 	$crud = new grocery_CRUD('default'); 
	//     $crud->set_table('wallets');
	// 	$crud->set_subject('wallets');

	// 	$crud->unset_columns('created_date');
	// 	$crud->unset_add_fields('created_date');
	// 	$crud->unset_edit_fields('created_date');
	// 	$data = $crud->render();
	// 	$this->load->view('admin/crud_view',$data);
	// }

	public function cards()
	{
		$crud = new grocery_CRUD('default'); 
	    $crud->set_table('card');
		$crud->set_subject('Card');
		$crud->set_field_upload('iss_org_logo','assets/uploads');
		$crud->columns('id', 'identity_no', 'card_name', 'issuing_organization', 'iss_org_logo', 'iss_org_url', 'card_type', 'card_category', 'affiliation', 'affiliation_category', 'reward_points_value_on_spending', 'country', 'country_code', 'contact_no', 'color', 'created_date');
		$crud->display_as('reward_points_value_on_spending','Worth of reward points in Rs.')->display_as('no_of_rewards','No of rewards point/Rs.100');
		$crud->callback_add_field('color_code', function () {
				return '<input type="color" maxlength="20" name="color_code">';
		});
		$crud->callback_add_field('issuing_organization',function(){
			$output = $this->db->query("SELECT DISTINCT(Bank_Name) as bank from issuing_organization")->result();
			$options = '<select name="issuing_organization">';
			foreach ($output as $value) {
				$options .='<option value="'.$value->bank.'">'.$value->bank.'</option>';
			}
			$options .='</select>';
			return $options;
		});
		$crud->set_rules('no_of_rewards','No of rewards','numeric');
		//$crud->callback_column('color',array($this,'callback_color_picker'));
		//$crud->unset_columns('created_date');
		$crud->unset_add_fields('created_date');
		$crud->unset_edit_fields('created_date');
		$data = $crud->render();
		$this->load->view('admin/crud_view',$data);
	}

	public function category()
	{
		$crud = new grocery_CRUD('default'); 
	    $crud->set_table('categories_master');
		$crud->set_subject('Category');
		$crud->unset_add_fields('flag','created_date');
		$crud->unset_edit_fields('flag','created_date');
		$crud->unset_columns('applicable_category_id','flag','created_date');
		$crud->field_type('applicable_category_id','invisible');
		//$crud->unset_add();
		//$crud->unset_edit();
		//$crud->unset_delete();
		$crud->callback_before_insert(array($this, 'callback_getmax_app_cat_id'));
		$data = $crud->render();
		$this->load->view('admin/crud_view',$data);
	}

	public function issuing_organization()
	{
		$crud = new grocery_CRUD('default'); 
	    $crud->set_table('issuing_organization');
		$crud->set_subject('Issuing Organization');
		$crud->unique_fields('Bank_Name');
		$crud->unset_add_fields('created_date');
		$crud->unset_edit_fields('created_date');
		$crud->unset_columns('created_date');
		$data = $crud->render();
		$this->load->view('admin/crud_view',$data);
	}

	public function callback_getmax_app_cat_id($post_array)
	{
		$maxcatobj = $this->db->query("SELECT MAX(applicable_category_id) as maxcat from categories_master")->row();
		$maxcat_id = $maxcatobj->maxcat;
		$maxsubcatobj = $this->db->query("SELECT MAX(applicable_category_id) as maxsubcat from subcategories_master")->row();
		$maxsubcat_id = $maxsubcatobj->maxsubcat;
		if($maxcat_id>$maxsubcat_id){
			$post_array['applicable_category_id'] = $maxcat_id+1;
		}
		else{
			$post_array['applicable_category_id'] = $maxsubcat_id+1;
		}
  		return $post_array;
	}

	public function sub_Category()
	{
		$crud = new grocery_CRUD('default'); 
	    $crud->set_table('subcategories_master');
		$crud->set_subject('SubCategory');
		$crud->display_as('category','SubCategory')->display_as('category_id','Select Category');
		$crud->unset_add_fields('flag','created_date');
		$crud->unset_edit_fields('flag','created_date');
		$crud->callback_before_insert(array($this, 'callback_getmax_app_cat_id'));
		$crud->unset_columns('applicable_category_id','flag','created_date');
		$crud->set_relation('category_id', 'categories_master','category');
		$crud->field_type('applicable_category_id','invisible');
		//$crud->unset_add();
		//$crud->unset_edit();
		//$crud->unset_delete();
		$data = $crud->render();
		$this->load->view('admin/crud_view',$data);
	}

	function callback_color_picker($value, $row){
		return "true";
		// return "<div class='input-group colorpickeradmin'><input type='text' value=' class='form-control' name='color' /><span class='input-group-addon'><i></i></span></div>";
	}

	function cadilla_offers()
	{
		$data['methodname'] = "offer_file";
		$this->load->view('admin/cadila_cards',$data);
	}

	function cadilla_establishment()
	{
		$data['methodname'] = "establishment_file";
		$this->load->view('admin/cadila_cards',$data);
	}

	function cadilla_cards()
	{
		$data['methodname'] = "cards_file";
		$this->load->view('admin/cadila_cards',$data);
	}

	/*public function tempcities()
	{
		$datas = $_POST['jsondata'];
		// print_r($datas);
		foreach ($datas as $city) {
			$this->db->insert('cities', array('city' => $city));
		}
		echo "done";
	}*/
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
