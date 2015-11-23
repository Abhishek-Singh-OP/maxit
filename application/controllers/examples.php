<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Examples extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');

		$this->load->library('grocery_CRUD');
	}
	public function check_category_subcategory(){
		$count = 0;
		$offers_res = $this->db->get("offers")->result();
		foreach($offers_res as $offers_res_row){
			$offer_cat = $offers_res_row->offer_category;
			$this->db->where("category_id", $offer_cat);
			$cat_ids = $this->db->get("subcategories_master")->result();

			$is_valid = 0;
			foreach($cat_ids as $cat_ids_row){
				if($offers_res_row->offer_subcategory == $cat_ids_row->id){
					$is_valid = 1;
				}
			}
			if($is_valid == 0){
				$count++;
				echo "Offer ID: ".$offers_res_row->id;
				echo "<br>";

				//offer_id, cat_id, cat = Others
				$this->db->where("category", "Others");
				$this->db->where("category_id", $offer_cat);
				$sub_cat_id = $this->db->get("subcategories_master")->row();
				if(count($sub_cat_id) < 1){
					// echo "No Others Sub cat found for Offer ID: ".$offers_res_row->id;
					// echo "<br>";
				}else{
					$ud_data = array(
						"offer_subcategory" => $sub_cat_id->id
					);
					$this->db->where("id", $offers_res_row->id);
					$this->db->update("offers", $ud_data);
				}
			}
		}
		// echo "<hr>";
		// echo "Count: ".$count;
	}
	public function check_cards(){
		// $haystack = "I am a Web Developer.";
		// $needle = "developer";
		// if(stristr($haystack, $needle)){
		// 	echo "Found";
		// }else{
		// 	echo "Not FOund.";
		// }
		// exit;

		$offers_res = $this->db->get("offers")->result();
		foreach($offers_res as $offers_res_row){
			$card_id_list = $offers_res_row->card_name;
			$card_id_arr = explode(",", $card_id_list);
			foreach($card_id_arr as $card_id){
				$this->db->where("identity_no", $card_id);
				$card_name = $this->db->get("card")->row();
				//echo $card_name->card_name;
				if(stristr($offers_res_row->offer_url, $card_name->affiliation)){
					// echo "Found.";
					// echo "<br>";
				}else{
					echo "Not Found:        ".$offers_res_row->id;
					echo "<br>";
					echo "Card ID:          ".$card_id;
					echo "<br>";
					echo "Card Afiliation: ".$card_name->affiliation;
					echo "<br>";
					echo "Offer URL:       ".$offers_res_row->offer_url;
					echo "<hr>";
				}
			}
		}
	}
	public function move_entry_to_est(){
		$this->db->where("establishment !=", "");
		$all_offers = $this->db->get("offers")->result();
		foreach($all_offers as $all_offers_row){
			
			$this->db->where("establishment", $all_offers_row->establishment);
			$this->db->where("latitude", $all_offers_row->latitude);
			$this->db->where("longtitude", $all_offers_row->longtitude);
			$is_exist = count($this->db->get("establishment")->result());

			$flag = 0;
			
			//combination of est name and lat long should be unique.
			if($is_exist < 1){
				//if lat long is present then do not check with google map.
				if($all_offers_row->latitude == "" && $all_offers_row->longtitude == ""){
					$est_name_google_res_json = $this->google_places2($all_offers_row->establishment);
					$est_name_google_res = json_decode($est_name_google_res_json);

					foreach($est_name_google_res->predictions as $est_name_google_res_row){
						$est_full_name = $est_name_google_res_row->description;
						$est_name = explode(",", $est_full_name);
						if(strtolower($all_offers_row->establishment) == strtolower($est_name[0])){
							$flag = 1;
						}
					}
				}

				$lat = $all_offers_row->latitude;
				$lng = $all_offers_row->longtitude;

				$ins_data = array(
					"establishment" => $all_offers_row->establishment,
					"url" => $all_offers_row->offer_url,
					"location" => $all_offers_row->city,
					"offer_category" => $all_offers_row->offer_category,
					"offer_subcategory" => $all_offers_row->offer_subcategory,
					"latitude" => $lat,
					"longtitude" => $lng,
					"specific_location_exists" => $flag,
					"address" => "",
					"pincode" => "0",
					"category" => "",
					"establishment_logo" => "",
					"ultimate_card" => 0
				);
				$this->db->insert("establishment", $ins_data);
			}
		}
	}
	public function move_entry_to_est_old(){
		$all_offers = $this->db->get("offers")->result();
		foreach($all_offers as $all_offers_row){
			
			$this->db->where("establishment", $all_offers_row->establishment);
			$this->db->where("latitude", $all_offers_row->latitude);
			$this->db->where("longtitude", $all_offers_row->longtitude);
			$is_exist = count($this->db->get("establishment")->result());

			$flag = 0;
			$lat = 0;
			$lng = 0;

			//combination of est name and lat long should be unique.
			if($is_exist < 1){
				//if lat long is present then do not check with google map.
				if($all_offers_row->latitude == "" && $all_offers_row->longtitude == ""){
					$est_name_google_res_json = $this->google_places2($all_offers_row->establishment);
					$est_name_google_res = json_decode($est_name_google_res_json);

					foreach($est_name_google_res->predictions as $est_name_google_res_row){
						$est_full_name = $est_name_google_res_row->description;
						$est_name = explode(",", $est_full_name);
						if(strtolower($all_offers_row->establishment) == strtolower($est_name[0])){
							$lat_lng_json = $this->google_lat_lng($est_full_name);
							$lat_lng = json_decode($lat_lng_json);
							$lat = @$lat_lng->results[0]->geometry->location->lat==""?0:@$lat_lng->results[0]->geometry->location->lat;
							$lng = @$lat_lng->results[0]->geometry->location->lng==""?0:@$lat_lng->results[0]->geometry->location->lng;
							$flag = 1;
						}else{
							$lat = $all_offers_row->latitude;
							$lng = $all_offers_row->longtitude;
						}
					}
				}else{
					$lat = $all_offers_row->latitude;
					$lng = $all_offers_row->longtitude;
				}

				$ins_data = array(
					"establishment" => $all_offers_row->establishment,
					"url" => $all_offers_row->offer_url,
					"location" => $all_offers_row->city,
					"offer_category" => $all_offers_row->offer_category,
					"offer_subcategory" => $all_offers_row->offer_subcategory,
					"latitude" => $lat,
					"longtitude" => $lng,
					"flag" => $flag,
					"address" => "",
					"pincode" => "0",
					"category" => "",
					"establishment_logo" => "",
					"ultimate_card" => 0
				);
				$this->db->insert("establishment", $ins_data);
			}
		}
	}

	public function google_lat_lng($address){
		if(!function_exists('curl_init')){print ("cURL library cannot be found. Make sure it is installed."); exit;}
		$agent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.4) Gecko/20030624 Netscape/7.1 (ax)";
		$ch = curl_init();
		//curl_setopt($ch, CURLOPT_URL,"https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode("McDonald's, Andheri - Kurla Road, Andheri East, Mumbai, Maharashtra")."&key=AIzaSyB098uZbKtIb39zl4W4o7tBxnwvKxE9xlk&types=establishment");
		curl_setopt($ch, CURLOPT_URL,"https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($address)."&key=AIzaSyB098uZbKtIb39zl4W4o7tBxnwvKxE9xlk&types=establishment");
		curl_setopt($ch, CURLOPT_USERAGENT, $agent);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		$returned = curl_exec($ch);
		curl_close($ch);
		return $returned;
		// $data = json_decode($returned);
		// print_r($data->results[0]->geometry->location->lat);
		// echo "    ";
		// print_r($data->results[0]->geometry->location->lng);
	}

	public function google_places2($establishment){
			if(!function_exists('curl_init')){print ("cURL library cannot be found. Make sure it is installed."); exit;}
			$agent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.4) Gecko/20030624 Netscape/7.1 (ax)";
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,"https://maps.googleapis.com/maps/api/place/autocomplete/json?input=".urlencode($establishment)."&key=AIzaSyB098uZbKtIb39zl4W4o7tBxnwvKxE9xlk&types=establishment");
			curl_setopt($ch, CURLOPT_USERAGENT, $agent);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			$returned=curl_exec ($ch);
			curl_close ($ch);
			return $returned;
	}

	public function google_places(){
		$all_est = $this->db->get("establishment")->result();
		foreach($all_est as $all_est_row){
			if(!function_exists('curl_init')){print ("cURL library cannot be found. Make sure it is installed."); exit;}
			$agent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.4) Gecko/20030624 Netscape/7.1 (ax)";
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,"https://maps.googleapis.com/maps/api/place/autocomplete/json?input=".urlencode($all_est_row->establishment)."&key=AIzaSyB098uZbKtIb39zl4W4o7tBxnwvKxE9xlk&types=establishment");
			curl_setopt($ch, CURLOPT_USERAGENT, $agent);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			$returned=curl_exec ($ch);
			if($returned==null){
				echo "Your cURL does not allow https protocol. Make sure OpenSSL is installed.<br/>Details Error :<br/><b>".curl_error($ch)."</b>";
			}else{
				$est_name_google_arr = json_decode($returned);
				if(count($est_name_google_arr->predictions) == 0){
					$this->db->where("id", $all_est_row->id);
					$this->db->update("establishment", array("flag" => 0));
				}else{
					foreach($est_name_google_arr->predictions as $est_name_google_arr_row){
						$est_full_name = $est_name_google_arr_row->description;
						$est_name = explode(",", $est_full_name);
						echo "Est name Google : ".$est_name[0]."   ";
						echo "Est name DB : ".$all_est_row->establishment."   ";
						echo "<br/><br/>";
						if($all_est_row->establishment == $est_name[0]){
							$this->db->where("id", $all_est_row->id);
							$this->db->update("establishment", array("flag" => 1));
						}
					}
					
				}
			}
			curl_close ($ch);
		}
	}
	public function gen(){
		$res = $this->db->query("select * from offers_bak where id between 1 and 3353;")->result();
		foreach($res as $res_row){
			//update offers_test set ofer_type = {val1} where id = {val2}
			echo "update offers set offer_type = '".$res_row->offer_type."' where id = ".$res_row->id.";<br />";
		}
	}

	public function best_card($est_name=null){
		$est_data = $this->db->query("SELECT * FROM establishment WHERE best_card = ''");
		foreach ($est_data->result() as $val) {
			$data = $this->db->query("select * from offers where establishment_id = '".$val->id."' AND offer_type IN ('Discount Percentage', 'Discount', 'Cashback Percentage', 'Cashback', 'Reward Points', 'Reward Point Multiplier');");
			$cards_val = array();
			$best_card = '';
			$inc = 0;
			if($est_data->num_rows() > 0){
				foreach($data->result() as $data_row){
					echo "<h4>Est ID: ".$val->establishment."</h4>";
					$cards_arr = explode(",", $data_row->card_name);
					$cards_count = count($cards_arr);
					for($i = 0;$i < $cards_count; $i++){
						$disc_per = $this->db->query("select * from offers where establishment_id = '".addslashes($data_row->establishment_id)."' AND card_name like '%,".$cards_arr[$i].",%' AND offer_type = 'Discount Percentage';")->row();
						$disc = $this->db->query("select * from offers where establishment_id = '".addslashes($data_row->establishment_id)."' AND card_name like '%,".$cards_arr[$i].",%' AND offer_type = 'Discount';")->row();
						$cashback_per = $this->db->query("select * from offers where establishment_id = '".addslashes($data_row->establishment_id)."' AND card_name like '%,".$cards_arr[$i].",%' AND offer_type = 'Cashback Percentage';")->row();
						$cashback = $this->db->query("select * from offers where establishment_id = '".addslashes($data_row->establishment_id)."' AND card_name like '%,".$cards_arr[$i].",%' AND offer_type = 'Cashback';")->row();
						$reward_pt = $this->db->query("select * from offers where establishment_id = '".addslashes($data_row->establishment_id)."' AND card_name like '%,".$cards_arr[$i].",%' AND offer_type = 'Reward Points';")->row();
						$reward_pt_mul = $this->db->query("select * from offers where establishment_id = '".addslashes($data_row->establishment_id)."' AND card_name like '%,".$cards_arr[$i].",%' AND offer_type = 'Reward Point Multiplier';")->row();

						$value = @$disc_per->amount + @$disc->amount + @$cashback_per->amount + @$cashback->amount + @$reward_pt->amount + @$reward_pt_mul->amount;

						$cards_val[$cards_arr[$i]] = $value;
					}

					arsort($cards_val);
					// print_r($cards_val);

					foreach($cards_val as $key => $cards_val_row){
						$best_card = $best_card.", ".$key;
					}
					echo $best_card;
					$best = array(
							'best_card' => $best_card,
						);

					$this->db->where('id', $val->id);
					$this->db->update('establishment', $best);
				}
			}
			echo "<hr />";
		}
	}


	// public function best_cards($est_name=null){
	// 	//Get estname, card and offertype => get amount
	// 	// if($est_name == null){
	// 	// 	$data = $this->db->query("select * from offers where establishment_id != '' AND offer_type IN ('Discount Percentage', 'Discount', 'Cashback Percentage', 'Cashback', 'Reward Points', 'Reward Point Multiplier');")->result();
	// 	// }else{

	// 	// $est_data = $this->db->get('establishment');

	// 	// foreach ($est_data->result() as $val) {
	// 		// $data = $this->db->query("select * from offers where establishment_id = '".$value->id."' AND offer_type IN ('Discount Percentage', 'Discount', 'Cashback Percentage', 'Cashback', 'Reward Points', 'Reward Point Multiplier');");

	// 		$data = $this->db->query("select * from offers where establishment_id = '".$est_name."' AND offer_type IN ('Discount Percentage', 'Discount', 'Cashback Percentage', 'Cashback', 'Reward Points', 'Reward Point Multiplier');");
	// 		$cards_val = array();
	// 		$best_card = '';
	// 		if($est_data->num_rows() > 0){
	// 			foreach($data->result() as $data_row){
	// 				// echo "<h4>Est ID: ".$val->establishment."</h4>";
	// 				$cards_arr = explode(",", $data_row->card_name);
	// 				$cards_count = count($cards_arr);
	// 				for($i = 0;$i < $cards_count; $i++){
	// 					$disc_per = $this->db->query("select * from offers where establishment_id = '".addslashes($data_row->establishment_id)."' AND card_name like '%,".$cards_arr[$i].",%' AND offer_type = 'Discount Percentage';")->row();
	// 					$disc = $this->db->query("select * from offers where establishment_id = '".addslashes($data_row->establishment_id)."' AND card_name like '%,".$cards_arr[$i].",%' AND offer_type = 'Discount';")->row();
	// 					$cashback_per = $this->db->query("select * from offers where establishment_id = '".addslashes($data_row->establishment_id)."' AND card_name like '%,".$cards_arr[$i].",%' AND offer_type = 'Cashback Percentage';")->row();
	// 					$cashback = $this->db->query("select * from offers where establishment_id = '".addslashes($data_row->establishment_id)."' AND card_name like '%,".$cards_arr[$i].",%' AND offer_type = 'Cashback';")->row();
	// 					$reward_pt = $this->db->query("select * from offers where establishment_id = '".addslashes($data_row->establishment_id)."' AND card_name like '%,".$cards_arr[$i].",%' AND offer_type = 'Reward Points';")->row();
	// 					$reward_pt_mul = $this->db->query("select * from offers where establishment_id = '".addslashes($data_row->establishment_id)."' AND card_name like '%,".$cards_arr[$i].",%' AND offer_type = 'Reward Point Multiplier';")->row();

	// 					$value = @$disc_per->amount + @$disc->amount + @$cashback_per->amount + @$cashback->amount + @$reward_pt->amount + @$reward_pt_mul->amount;

	// 					$cards_val[$cards_arr[$i]] = $value;
	// 				}
	// 				rsort($cards_val);
	// 				foreach($cards_val as $key => $cards_val_row){
	// 					// echo "Card ID: ".$key;
	// 					// echo "<br/>";
	// 					// echo "Value: ".$cards_val_row;
	// 					// echo "<br/>";
	// 					$best_card = $best_card.", ".$cards_val_row;
	// 				}
	// 				// echo $best_card;
	// 				$this->db->where('id', $est_name);
	// 				$this->db->update('establishment', $best_card);
	// 			}
	// 		}

	// 		echo "<hr />";

	// 	}
	// }

	// public function ultimate_cards($est_name=null){
	// 	$est_name = $this->input->post("txt_category")
	// 	//Get estname, card and offertype => get amount.
	// 	$data = $this->db->query("select * from offers where establishment_id = '".$est_name."' AND offer_type IN ('Discount Percentage', 'Discount', 'Cashback Percentage', 'Cashback', 'Reward Points', 'Reward Point Multiplier');");
	// 	if ($data->num_rows() > 0 ){
	// 		$cards_val = array();
	// 		foreach($data->result() as $data_row){
	// 			$cards_arr = explode(",", $data_row->card_name);
	// 			$cards_count = count($cards_arr);
	// 			for($i = 0;$i < $cards_count; $i++){
	// 				$disc_per = $this->db->query("select * from offers where establishment_id = '".addslashes($data_row->establishment_id)."' AND card_name like '%,".$cards_arr[$i].",%' AND offer_type = 'Discount Percentage';")->row();
	// 				$disc = $this->db->query("select * from offers where establishment_id = '".addslashes($data_row->establishment_id)."' AND card_name like '%,".$cards_arr[$i].",%' AND offer_type = 'Discount';")->row();
	// 				$cashback_per = $this->db->query("select * from offers where establishment_id = '".addslashes($data_row->establishment_id)."' AND card_name like '%,".$cards_arr[$i].",%' AND offer_type = 'Cashback Percentage';")->row();
	// 				$cashback = $this->db->query("select * from offers where establishment_id = '".addslashes($data_row->establishment_id)."' AND card_name like '%,".$cards_arr[$i].",%' AND offer_type = 'Cashback';")->row();
	// 				$reward_pt = $this->db->query("select * from offers where establishment_id = '".addslashes($data_row->establishment_id)."' AND card_name like '%,".$cards_arr[$i].",%' AND offer_type = 'Reward Points';")->row();
	// 				$reward_pt_mul = $this->db->query("select * from offers where establishment_id = '".addslashes($data_row->establishment_id)."' AND card_name like '%,".$cards_arr[$i].",%' AND offer_type = 'Reward Point Multiplier';")->row();

	// 				$value = @$disc_per->amount + @$disc->amount + @$cashback_per->amount + @$cashback->amount + @$reward_pt->amount + @$reward_pt_mul->amount;

	// 				$cards_val[$cards_arr[$i]] = $value;
	// 			}
	// 		}

	// 		$maxs = array_search(max($cards_val),$cards_val);
	// 		//$maxs = array_keys($cards_val, max($cards_val));
	// 		// echo "Card Identity : ".$maxs;
	// 		// echo "<br/>";
	// 		// echo "Value : ".max($cards_val);
	// 		// echo "<hr />";

	// 		$card_data = array(
	// 				"ultimate_card" => $maxs,
	// 			);

	// 		$this->db->where('id', $est_name);
	// 		$this->db->update('establishment', $card_data);
	// 	}
	// }

	public function export_csv(){
		// $list = array (
		//     array('aaa', 'bbb', 'ccc', 'dddd'),
		//     array('123', '456', '789'),
		//     array('"aaa"', '"bbb"')
		// );

		$all_tables = $this->db->query("show tables from zipsave")->result();

		foreach($all_tables as $all_tables_row){
			$query = "select * from ".$all_tables_row->Tables_in_zipsave;
			$list = $this->db->query($query)->result_array();
			$fp = fopen('assets/csv/'.date("Y-m-d H:i:s").'-'.$all_tables_row->Tables_in_zipsave.'-SQL_Dump.csv', 'w');

			foreach ($list as $fields) {
			    fputcsv($fp, $fields);
			}

			fclose($fp);
		}
	}

	public function _example_output($output = null)
	{
		$this->load->view('example.php',$output);
	}

	public function offices()
	{
		$output = $this->grocery_crud->render();

		$this->_example_output($output);
	}

	public function index()
	{
		$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}

	public function offices_management()
	{
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('offices');
			$crud->set_subject('Office');
			$crud->required_fields('city');
			$crud->columns('city','country','phone','addressLine1','postalCode');

			$output = $crud->render();

			$this->_example_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}

	public function employees_management()
	{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('employees');
			$crud->set_relation('officeCode','offices','city');
			$crud->display_as('officeCode','Office City');
			$crud->set_subject('Employee');

			$crud->required_fields('lastName');

			$crud->set_field_upload('file_url','assets/uploads/files');

			$output = $crud->render();

			$this->_example_output($output);
	}

	public function customers_management()
	{
			$crud = new grocery_CRUD();

			$crud->set_table('customers');
			$crud->columns('customerName','contactLastName','phone','city','country','salesRepEmployeeNumber','creditLimit');
			$crud->display_as('salesRepEmployeeNumber','from Employeer')
				 ->display_as('customerName','Name')
				 ->display_as('contactLastName','Last Name');
			$crud->set_subject('Customer');
			$crud->set_relation('salesRepEmployeeNumber','employees','lastName');

			$output = $crud->render();

			$this->_example_output($output);
	}

	public function orders_management()
	{
			$crud = new grocery_CRUD();

			$crud->set_relation('customerNumber','customers','{contactLastName} {contactFirstName}');
			$crud->display_as('customerNumber','Customer');
			$crud->set_table('orders');
			$crud->set_subject('Order');
			$crud->unset_add();
			$crud->unset_delete();

			$output = $crud->render();

			$this->_example_output($output);
	}

	public function products_management()
	{
			$crud = new grocery_CRUD();

			$crud->set_table('products');
			$crud->set_subject('Product');
			$crud->unset_columns('productDescription');
			$crud->callback_column('buyPrice',array($this,'valueToEuro'));

			$output = $crud->render();

			$this->_example_output($output);
	}

	public function valueToEuro($value, $row)
	{
		return $value.' &euro;';
	}

	public function film_management()
	{
		$crud = new grocery_CRUD();

		$crud->set_table('film');
		$crud->set_relation_n_n('actors', 'film_actor', 'actor', 'film_id', 'actor_id', 'fullname','priority');
		$crud->set_relation_n_n('category', 'film_category', 'category', 'film_id', 'category_id', 'name');
		$crud->unset_columns('special_features','description','actors');

		$crud->fields('title', 'description', 'actors' ,  'category' ,'release_year', 'rental_duration', 'rental_rate', 'length', 'replacement_cost', 'rating', 'special_features');

		$output = $crud->render();

		$this->_example_output($output);
	}

	public function film_management_twitter_bootstrap()
	{
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('twitter-bootstrap');
			$crud->set_table('film');
			$crud->set_relation_n_n('actors', 'film_actor', 'actor', 'film_id', 'actor_id', 'fullname','priority');
			$crud->set_relation_n_n('category', 'film_category', 'category', 'film_id', 'category_id', 'name');
			$crud->unset_columns('special_features','description','actors');

			$crud->fields('title', 'description', 'actors' ,  'category' ,'release_year', 'rental_duration', 'rental_rate', 'length', 'replacement_cost', 'rating', 'special_features');

			$output = $crud->render();
			$this->_example_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}

	function multigrids()
	{
		$this->config->load('grocery_crud');
		$this->config->set_item('grocery_crud_dialog_forms',true);
		$this->config->set_item('grocery_crud_default_per_page',10);

		$output1 = $this->offices_management2();

		$output2 = $this->employees_management2();

		$output3 = $this->customers_management2();

		$js_files = $output1->js_files + $output2->js_files + $output3->js_files;
		$css_files = $output1->css_files + $output2->css_files + $output3->css_files;
		$output = "<h1>List 1</h1>".$output1->output."<h1>List 2</h1>".$output2->output."<h1>List 3</h1>".$output3->output;

		$this->_example_output((object)array(
				'js_files' => $js_files,
				'css_files' => $css_files,
				'output'	=> $output
		));
	}

	public function offices_management2()
	{
		$crud = new grocery_CRUD();
		$crud->set_table('offices');
		$crud->set_subject('Office');

		$crud->set_crud_url_path(site_url(strtolower(__CLASS__."/".__FUNCTION__)),site_url(strtolower(__CLASS__."/multigrids")));

		$output = $crud->render();

		if($crud->getState() != 'list') {
			$this->_example_output($output);
		} else {
			return $output;
		}
	}

	public function employees_management2()
	{
		$crud = new grocery_CRUD();

		$crud->set_theme('datatables');
		$crud->set_table('employees');
		$crud->set_relation('officeCode','offices','city');
		$crud->display_as('officeCode','Office City');
		$crud->set_subject('Employee');

		$crud->required_fields('lastName');

		$crud->set_field_upload('file_url','assets/uploads/files');

		$crud->set_crud_url_path(site_url(strtolower(__CLASS__."/".__FUNCTION__)),site_url(strtolower(__CLASS__."/multigrids")));

		$output = $crud->render();

		if($crud->getState() != 'list') {
			$this->_example_output($output);
		} else {
			return $output;
		}
	}

	public function customers_management2()
	{

		$crud = new grocery_CRUD();

		$crud->set_table('customers');
		$crud->columns('customerName','contactLastName','phone','city','country','salesRepEmployeeNumber','creditLimit');
		$crud->display_as('salesRepEmployeeNumber','from Employeer')
			 ->display_as('customerName','Name')
			 ->display_as('contactLastName','Last Name');
		$crud->set_subject('Customer');
		$crud->set_relation('salesRepEmployeeNumber','employees','lastName');

		$crud->set_crud_url_path(site_url(strtolower(__CLASS__."/".__FUNCTION__)),site_url(strtolower(__CLASS__."/multigrids")));

		$output = $crud->render();

		if($crud->getState() != 'list') {
			$this->_example_output($output);
		} else {
			return $output;
		}
	}

}