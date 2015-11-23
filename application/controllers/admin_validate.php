<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_validate extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
		$this->load->view('admin/dashboard');
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


		public function save_est_form(){
		//print_r($_POST);
		$est_name = explode(",", $this->input->post("txt_establishment"));
		$upd_data_est = array(
			"establishment"     => $est_name[0],
			"url"               => $this->input->post("txt_url"),
			"class"             => $this->input->post("txt_class"),
			"location"          => $this->input->post("txt_location"),
			"category"          => $this->input->post("txt_category"),
			"offer_subcategory" => $this->input->post("txt_offer_subcategory"),
			"latitude"          => $this->input->post("txt_latitude"),
			"longtitude"        => $this->input->post("txt_longtitude")
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
			"offer_url"                  => $this->input->post("txt_offer_url"),
			"tnc"                        => $this->input->post("txt_tnc"),
			"imp_tnc"                    => $this->input->post("txt_imp_tnc"),
			"offer_content"              => $this->input->post("txt_offer_content"),
			"applicable_across_category" => $this->input->post("txt_applicable_across_category"),
			"week_days"                  => $this->input->post("txt_week_days"),
			"latitude"                   => $this->input->post("txt_latitude"),
			"longtitude"                 => $this->input->post("txt_longtitude"),
			"specific_location_exists"   => $specific_location_exists,
			"manually_updated"   => '2'
		);

		$this->db->where("id", $this->input->post("txt_offer_id"));
		$this->db->update("offers", $upd_data_offers);

		$next_id = $this->db->query("select * from offers where id > ".$this->input->post("txt_offer_id")."")->row();
		redirect("admin/est_form/".$next_id->id);
	}
}