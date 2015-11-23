<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Api extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index(){
		$this->render_json();
	}	

	public function get_bin($bin = 0){

		if( strlen($bin) > 6 || strlen($bin) < 6 || !is_numeric($bin)){
			$data['error'] = 'Invalid input.';
			$this->render_json($data,1);
			return false;
		}

		// get data from existing database
		get_data:
		$this->db->where('identity_no', $bin);
		$q = $this->db->get('card');

		if ($q->num_rows() > 0){
			$data = $q->result_array()[0];
			$this->render_json($data,1);
		}
		else {
			// get data from external api, feed into database and display back
			//http://www.binlist.net/json/431940
			$url = "http://www.binlist.net/json/".$bin;
			$data = @json_decode(file_get_contents($url),TRUE);

			if(!$data){
				$data['error'] = 'Bin not found.';
				$this->render_json($data,1);
				return false;
			}

			$bin_data_to_db = array(
					'identity_no'          => $data['bin'],
					'card_name'            => $data['brand'],
					'issuing_organization' => $data['bank'],
					'card_type'            => $data['card_type'],
					'card_category'        => $data['sub_brand'],
					'card_category'        => $data['sub_brand'],
					'affiliation'          => $data['brand'],
					'affiliation'          => $data['brand'],
					'country'              => $data['country_name'],
					'country_code'         => $data['country_code']
				);
			$this->db->insert('card',$bin_data_to_db);
			goto get_data; // I really was lazy. so GOTO.
		}
	}

	public function get_banks(){
		$this->db->select('issuing_organization,iss_org_logo,iss_org_url');
		$this->db->group_by('issuing_organization');
		$q = $this->db->get('card');
		$data = $q->result_array();
		$this->render_json($data,1);
	}

	public function get_establishments(){
		$q = $this->db->get('establishment');
		$data = $q->result_array();
		$this->render_json($data,1);
	}

	function get_offers(){

		$query = 	"SELECT offers.id, 
							card.card_name, 
							offers.keywords, 
							establishment.establishment, 
							offers.amount, 
							offers.offer_type, 
							offers.offer_content, 
							card.issuing_organization 
					FROM offers JOIN card 
					ON offers.card_name = card.id JOIN establishment 
					ON offers.establishment = establishment.id";

		$q = $this->db->query($query);
		$data = $q->result();
		$this->render_json($data,1);
	}	

	function get_card_offers($card_id = null){

		if (!$card_id){
			$this->render_json();
			return false;
		}

		$query = 	"SELECT offers.id, 
							card.card_name, 
							offers.keywords, 
							establishment.establishment, 
							offers.amount, 
							offers.offer_type, 
							offers.offer_content, 
							card.issuing_organization 
					FROM offers JOIN card 
					ON offers.card_name = card.id JOIN establishment 
					ON offers.establishment = establishment.id 
					AND offers.card_name = '{$card_id}' ";

		$q = $this->db->query($query);

		$data = $q->result();
		$this->render_json($data,1);
	}	

	function get_bank_offers($bank = null){

		$bank = urldecode($bank);
		if (!$bank){
			$this->render_json();
			return false;
		}

		$query = 	"SELECT offers.id,
							card.card_name, 
							offers.keywords, 
							establishment.establishment, 
							offers.amount, 
							offers.offer_type, 
							offers.offer_content, 
							card.issuing_organization 
					FROM offers 
					JOIN card ON offers.card_name = card.id Join establishment 
							ON offers.establishment = establishment.id AND card.issuing_organization = '{$bank}'";

		$q = $this->db->query($query);

		$data = $q->result();
		$this->render_json($data,1);
	}



	function get_establishment_offers($est = null){

		$est = urldecode($est);
		if (!$est){
			$this->render_json();
			return false;
		}

		$query = 	"SELECT offers.id,
							card.card_name, 
							offers.keywords, 
							establishment.establishment, 
							offers.amount, 
							offers.offer_type, 
							offers.offer_content, 
							card.issuing_organization 
					FROM offers 
					JOIN card ON offers.card_name = card.id Join establishment 
							ON offers.establishment = establishment.id AND establishment.establishment = '{$est}'";

		$q = $this->db->query($query);

		$data = $q->result();
		$this->render_json($data,1);
	}

	function get_offers_all($orgnization = null, $location = null, $card = null){

		$orgnization = urldecode($orgnization);
		$location = urldecode($location);
		$card = urldecode($card);
		// $orgnization = urldecode($orgnization);
		// $location = 'www.irctc.co.in';
		// $card = '122465';

		$str = '';

		if(!$orgnization) {
			if (!$location) {
				if (!$card) {
					//organization and location and card is null
					// $str = '';
					$this->render_json();
					return false;
				} else {
					//card exists
					$str = " LIKE offers.card_name = '%{$card}%'";
				}
			}   elseif (!$card) {
					//organization and card is null
					$str = " AND establishment.location = '{$location}'";
				} else {
					//location and card exists
					$str = "  LIKE offers.card_name = '%{$card}%'
							AND establishment.location = '{$location}'";
				}
		} else {
			if (!$location) {
				if (!$card) {
					$str = " AND card.issuing_organization = '{$orgnization}'";
				} else {
					//organization and location and card exists
					$str = " AND card.issuing_organization = '{$orgnization}'
							 LIKE offers.card_name = '%{$card}%'";
				}
			} else {
				if (!$card) {
					//organization and location exists
					$str = " AND card.issuing_organization = '{$orgnization}'
							AND establishment.location = '{$location}'";
				} else {
					//organization and location and card exists
					$str = " AND card.issuing_organization = '{$orgnization}'
							AND establishment.location = '{$location}'
							 LIKE offers.card_name = '%{$card}%'";
				}
			}
		}

		$query = 	"SELECT offers.id,
							card.card_name, 
							offers.keywords, 
							establishment.establishment, 
							offers.amount, 
							offers.offer_type, 
							offers.offer_content, 
							card.issuing_organization 
					FROM offers 
					JOIN card ON offers.card_name = card.id Join establishment 
							ON offers.establishment = establishment.id".$str;

		$q = $this->db->query($query);

		$data = $q->result();

		$this->render_json($data,1);
	}


	public function render_json($data = null,$pretty_print = null){
		
		if(!$data){
			$o['result'] = $data;
			$o['error'] = 'No Data Found';
		}

		$o['result'] = $data;
		$o['query_time'] = time();
		$o['error'] = null;

		if($pretty_print){
			header('Content-Type: application/json');
			echo json_encode($o, JSON_PRETTY_PRINT);
		}
		else {
			header('Content-Type: application/json');
			echo json_encode($o);
		}
	}
}