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
		$this->load->view('admin/dashboard');
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

	public function get_sub_category(){
		$this->db->where("category_id", $this->input->post("txt_category"));
		$sub_categories = $this->db->get("subcategories_master")->result_array();
		$this->output->set_content_type('application/json')->set_output(json_encode($sub_categories));
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


	public function get_sub_categories($cat_id){

		$this->db->where('category_id', $cat_id);
		$sub_cat = $this->db->get('subcategories_master')->result();

		foreach ($sub_cat as $c) {;
            echo "<option value='{$c->id}' >{$c->category}</option>";
		}
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
	    $crud->set_table('offers');
		$crud->set_subject('Users Data');
		// $crud->columns('id', 'card_name', 'offer');

		// $crud->set_relation('card_name', 'card', 'card_name');
		// $crud->set_relation('establishment', 'establishment', 'establishment');

		$crud->unset_columns('created_date');
		$crud->unset_add_fields('created_date');
		$crud->unset_edit_fields('created_date');
		
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
		$crud->columns('id','establishment','url','establishment_logo','status');
		$crud->order_by('establishment','asc');

		$crud->set_field_upload('establishment_logo','assets/uploads');

		$crud->unset_columns('created_date');
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

		$crud->unset_columns('created_date');
		$crud->unset_add_fields('created_date');
		$crud->unset_edit_fields('created_date');
		$data = $crud->render();
		$this->load->view('admin/crud_view',$data);
	}
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