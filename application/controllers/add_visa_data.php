<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add_visa_data extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		//Do your magic here
	}

	public function index()
	{

		set_time_limit(0);
		$page_data = true;
		$offer_id = 0;
		$base_url = '';
			$base_url = "http://casaestilo.in/scrapper/example/signature1.php";

			// $json = file_get_contents($base_url);
			$obj = json_decode($base_url);
			foreach ($obj as $value){
				// echo $value->offer_id;
				foreach ($value->offersList as $loca) {
					if ($offer_id != $value->offer_id){
						$data = array(
								'offer_id' => $value->offer_id,
								'card_name' => '123467',
								'offer' => $value->offer_name,
								'keywords' => $value->search_keywords,
								'establishment' => $value->display_merchant_name,
								'offer_type' => $value->OTName,
								'amount' => '',
								'valid_till' => $value->valid_to,
								'offer_url' => $loca->website_url,
								'tnc_url' => $value->offer_name,
								'offer_content' => $value->display_offer_name.' '.$value->offer_desc.' '.$value->terms_conditions,
								'latitude' => $loca->latitude,
								'longtitude' => $loca->longtitude,
							);
						// echo $value->offer_id.'<br>';
						// $this->db->insert('offers', $data);
					}

					$offer_id = $value->offer_id;
					// $offer_id = $value->offer_id;
					// print_r($data);

					print_r($data);
				}
			}

	// public function get_data(){
	// 	$this->load->view('get_data');
	}

}

/* End of file feed_pull.php */
/* Location: ./application/controllers/feed_pull.php */