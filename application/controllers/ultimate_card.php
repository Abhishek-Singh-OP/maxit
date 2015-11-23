<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ultimate_card extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->logged_in()){
		}
	}

	public function index(){
		$esta = $this->db->query('SELECT * FROM establishment WHERE ultimate_card = 0');
		foreach ($esta->result() as $v) {
			$data = $this->db->query("select * from offers where establishment_id = '".$v->id."' AND offer_type IN ('Discount Percentage', 'Discount', 'Cashback Percentage', 'Cashback', 'Reward Points', 'Reward Point Multiplier');");
			if ($data->num_rows() > 0 ){
				$cards_val = array();
				foreach($data->result() as $data_row){
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
				}

				print_r($cards_val);

				$maxs = array_search(max($cards_val),$cards_val);
				// $maxs = array_keys($cards_val, max($cards_val));
				// echo "Card Identity : ".$maxs;
				// echo "<hr />";

				$card_data = array(
						"ultimate_card" => $maxs,
					);

				$this->db->where('id', $v->id);
				$this->db->update('establishment', $card_data);
			}
		}
	}
}