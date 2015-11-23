<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feed_pull extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function index()
	{

		$query = 'SELECT establishments FROM offers GROUP BY establishments';
		$data = $this->db->query($query)->result();

		print_r($data);

		// set_time_limit(0);
		// $base_url = "https://www.citiworldprivileges.com/in/search/?ot_page=&country=IN&city=&offer_type=4&offer_sub_type=&keyword=&act=loadMoreOffers&lastIndex=";
		// $increment = 100;
		// $page_count = 2;
		// $page_data = true;


		// while($page_count < 100){
		// 	$json = file_get_contents($base_url.$page_count);
		// 	$obj = json_decode($json);
		// 	foreach ($obj as $value){
		// 		foreach ($value->merchant_location as $loca) {

		// 			$data = array(
		// 					'offer_id' => $value->offer_id,
		// 					'card_name' => '122465, 122466, 122467, 122468, 122469, 122470, 122471, 122472, 122473, 122474, 122475, 122476, 122477, 122478, 122479, 122480, 122481, 122482, 122483, 122484',
		// 					'offer' => $value->offer_name,
		// 					'keywords' => $value->search_keywords,
		// 					'establishment' => $value->display_merchant_name,
		// 					'offer_type' => $value->OTName,
		// 					'amount' => '',
		// 					'valid_till' => $value->valid_to,
		// 					'offer_url' => $loca->website_url,
		// 					'tnc_url' => $value->offer_name,
		// 					'offer_content' => $value->display_offer_name.' '.$value->offer_desc.' '.$value->terms_conditions,
		// 					'latitude' => $loca->latitude,
		// 					'longtitude' => $loca->longtitude,
		// 				);

		// 			if (!count($data)){
		// 				break;
		// 			}

		// 			print_r($data);
		// 			// $this->db->insert('offers', $data); 
		// 			// print_r($data);

		// 		}
		// 	}

		// 	$page_count = $page_count + 1;
		// 	// $merchant_location = $value['merchant_location'];
		// 	// echo '<br>';
		// }

		// while(true){
		// 	$data = json_decode($base_url);


		// 	print_r($page_data);

		// }
	}

	// public function get_data(){
	// 	$this->load->view('get_data');
	// }

}

/* End of file feed_pull.php */
/* Location: ./application/controllers/feed_pull.php */