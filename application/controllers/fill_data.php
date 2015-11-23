<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fill_data extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        //Do your magic here
    }

    public function index(){
        $data = '';

        $card = '123472';
        $obj = json_decode($data);
        $i = 0; 
        $a = 0;
        foreach ($obj as $value) {
            foreach ($value as $d) {
                while ($i < count($d)){
                    if (count($d[$i]->merchantList[0]->merchantAddress) == 0) {
                        $data = array(
                            'offer_id' => $d[$i]->offerId,
                            'card_name' => $card,
                            'keywords' => $d[$i]->categorySubcategoryList[0]->value,
                            'offer' => $d[$i]->offerTitle,
                            'establishment' => $d[$i]->merchantList[0]->merchant,
                            'offer_content' => $d[$i]->offerTitle.', '.$d[$i]->offerShortDescription->text.', '.$d[0]->offerShortDescription->text,
                            'valid_till' => explode(" ", $d[$i]->validityToDate)[0],
                            'offer_url' => 'http://www.visa.co.in/platinum/offers/index.shtml',
                            'scrapper_log_url' => $card.'/'.$d[$i]->offerTitle.'/http://www.visa.co.in/platinum/offers/index.shtml/fill_data/added_from_json_using_charles/2462015',
                            'manually_updated' => '0',
                        );
                        print_r($data);
                        // $this->db->insert('offers', $data);
                    } else {
                        while ($a < count($d[$i]->merchantList[0]->merchantAddress)){
                            $add = $d[$i]->merchantList[0]->merchantAddress[$a]->address1.', '.$d[$i]->merchantList[0]->merchantAddress[$a]->address2.'<br>';
                            $country =  $d[$i]->merchantList[0]->merchantAddress[$a]->countryName;
                            if($d[$i]->merchantList[0]->merchantAddress[$a]->countryName == 'India'){
                                $data = array(
                                    'offer_id' => $d[$i]->offerId,
                                    'card_name' => $card,
                                    'keywords' => $d[$i]->categorySubcategoryList[0]->value,
                                    'offer' => $d[$i]->offerTitle,
                                    'establishment' => $d[$i]->merchantList[0]->merchant.', '.$add.', '.$d[$i]->merchantList[0]->merchantAddress[$a]->countryName,
                                    'offer_content' => $d[$i]->offerTitle.', '.$d[$i]->offerShortDescription->text.', '.$d[0]->offerShortDescription->text,
                                    'valid_till' => explode(" ", $d[$i]->validityToDate)[0],
                                    'offer_url' => 'http://www.visa.co.in/platinum/offers/index.shtml',
                                    'scrapper_log_url' => $card.'/'.$d[$i]->offerTitle.'/http://www.visa.co.in/platinum/offers/index.shtml/fill_data/added_from_json_using_charles/2462015',
                                    'manually_updated' => '0',
                                );
                                print_r($data);
                                // $this->db->insert('offers', $data);
                            }
                            $a = $a + 1;
                        }
                    }
                $i = $i + 1;
                }
            }
        }
    }
}

        // <--### CODE FOR citibank privileges CARD WEBSITES ###-->
        // <--### CODE FOR citibank privileges CARD WEBSITES ###-->
        // <--### CODE FOR citibank privileges CARD WEBSITES ###-->
        // <--### CODE FOR citibank privileges CARD WEBSITES ###-->
        // <--### CODE FOR citibank privileges CARD WEBSITES ###-->
        // <--### CODE FOR citibank privileges CARD WEBSITES ###-->


     // // $base_url = "http://www.citiworldprivileges.com/search/?act=loadMoreOffers&lastIndex=12&%E2%80%A6ntry=IN&city=&offer_type=4&offer_sub_type=&keyword=&sb=recent&top10Offers=";
     //    // $base_url = 'http://www.citiworldprivileges.com/in/top10-offers/?act=getTop10Offers';
     //    $page_data = true;
     //    $offer_id = 0;
     //    // $base_url = '';
     //    // $i = 156;
     //    $i = 0;
     //    // while ($i <= 436) {
     //        // $base_url = "http://www.citiworldprivileges.com/search/?act=loadMoreOffers&lastIndex=".$i."&country=&city=&offer_type=36&offer_sub_type=&keyword=&sb=recent&top10Offers=";
     //        $base_url = 'http://www.citiworldprivileges.com/search/?act=getOfferBySearch&country=IN&city=&offer_type=48&offer_sub_type=&keyword=&sb=recent&top10Offers=';
     //        $json = file_get_contents($base_url);
     //        $obj = json_decode($json);
     //        foreach ($obj as $value){
     //        // print_r($value);
     //            $a = 0;
     //            while ($a < count($value->merchant_location)) {
     //                if ($value->merchant_location[$a]->location_country == 'India') {
     //                    $data = array(
     //                            'offer_id' => $value->offer_id,
     //                            'card_name' => '123467',
     //                            'offer' => $value->offer_desc,
     //                            'keywords' => $value->OTName,
     //                            'establishment' => $value->merchant_location[$a]->lang_cont->location_postal_address.', '.$value->merchant_location[$a]->lang_cont->location_city.', '.$value->merchant_location[$a]->location_country,
     //                            'valid_till' => $value->valid_to,
     //                            'offer_url' => 'http://www.citiworldprivileges.com/in/offer-detail/'.$value->offer_id,
     //                            'offer_content' => $value->display_offer_name.' '.$value->offer_desc.' '.$value->terms_conditions,
     //                            'latitude' => $value->merchant_location[$a]->latitude,
     //                            'longtitude' => $value->merchant_location[$a]->longtitude,
     //                        );
     //                        // $this->db->insert('offers', $data);
     //                print_r($data);
     //                }
     //                $a = $a + 1;
     //            }
     //        }
     //    // $i = $i + 12;
     //    // }



        // <--### CODE FOR VISA CARD WEBSITES ###-->
        // <--### CODE FOR VISA CARD WEBSITES ###-->
        // <--### CODE FOR VISA CARD WEBSITES ###-->
        // <--### CODE FOR VISA CARD WEBSITES ###-->
        // <--### CODE FOR VISA CARD WEBSITES ###-->
        // <--### CODE FOR VISA CARD WEBSITES ###-->



        // $data = '';

        // $card = '123472';
        // $obj = json_decode($data);
        // $i = 0; 
        // $a = 0;
        // foreach ($obj as $value) {
        //     foreach ($value as $d) {
        //         while ($i < count($d)){
        //             if (count($d[$i]->merchantList[0]->merchantAddress) == 0) {
        //                 $data = array(
        //                     'offer_id' => $d[$i]->offerId,
        //                     'card_name' => $card,
        //                     'keywords' => $d[$i]->categorySubcategoryList[0]->value,
        //                     'offer' => $d[$i]->offerTitle,
        //                     'establishment' => $d[$i]->merchantList[0]->merchant,
        //                     'offer_content' => $d[$i]->offerTitle.', '.$d[$i]->offerShortDescription->text.', '.$d[0]->offerShortDescription->text,
        //                     'valid_till' => explode(" ", $d[$i]->validityToDate)[0],
        //                     'offer_url' => 'http://www.visa.co.in/platinum/offers/index.shtml',
        //                     'scrapper_log_url' => $card.'/'.$d[$i]->offerTitle.'/http://www.visa.co.in/platinum/offers/index.shtml/fill_data/added_from_json_using_charles/2462015',
        //                     'manually_updated' => '0',
        //                 );
        //                 print_r($data);
        //                 // $this->db->insert('offers', $data);
        //             } else {
        //                 while ($a < count($d[$i]->merchantList[0]->merchantAddress)){
        //                     $add = $d[$i]->merchantList[0]->merchantAddress[$a]->address1.', '.$d[$i]->merchantList[0]->merchantAddress[$a]->address2.'<br>';
        //                     $country =  $d[$i]->merchantList[0]->merchantAddress[$a]->countryName;
        //                     if($d[$i]->merchantList[0]->merchantAddress[$a]->countryName == 'India'){
        //                         $data = array(
        //                             'offer_id' => $d[$i]->offerId,
        //                             'card_name' => $card,
        //                             'keywords' => $d[$i]->categorySubcategoryList[0]->value,
        //                             'offer' => $d[$i]->offerTitle,
        //                             'establishment' => $d[$i]->merchantList[0]->merchant.', '.$add.', '.$d[$i]->merchantList[0]->merchantAddress[$a]->countryName,
        //                             'offer_content' => $d[$i]->offerTitle.', '.$d[$i]->offerShortDescription->text.', '.$d[0]->offerShortDescription->text,
        //                             'valid_till' => explode(" ", $d[$i]->validityToDate)[0],
        //                             'offer_url' => 'http://www.visa.co.in/platinum/offers/index.shtml',
        //                             'scrapper_log_url' => $card.'/'.$d[$i]->offerTitle.'/http://www.visa.co.in/platinum/offers/index.shtml/fill_data/added_from_json_using_charles/2462015',
        //                             'manually_updated' => '0',
        //                         );
        //                         print_r($data);
        //                         // $this->db->insert('offers', $data);
        //                     }
        //                     $a = $a + 1;
        //                 }
        //             }
        //         $i = $i + 1;
        //         }
        //     }
        // }


    //  set_time_limit(0);
    //  // $base_url = "http://www.citiworldprivileges.com/search/?act=getOfferBySearch&country=IN&city=&offer_type=48&offer_sub_type=&keyword=&sb=recent&top10Offers=";
    //  // $base_url = "https://www.citiworldprivileges.com/in/search/?ot_page=&country=IN&city=&offer_type=4&offer_sub_type=&keyword=&act=loadMoreOffers&lastIndex=";

    //  // $base_url = "http://www.citiworldprivileges.com/search/?act=getOfferBySearch&country=IN&city=&offer_type=36&offer_sub_type=&keyword=&sb=recent&top10Offers=";
    //  // $base_url = "http://www.citiworldprivileges.com/in/top10-offers/?act=getTop10Offers";
    //  // $base_url = "http://www.citiworldprivileges.com/search/?act=getOfferBySearch&country=IN&city=&offer_type=4&offer_sub_type=&keyword=&sb=recent&top10Offers=";
    //  // $base_url = "http://www.citiworldprivileges.com/search/?act=getOfferBySearch&country=IN&city=&offer_type=4&offer_sub_type=&keyword=&sb=recent&top10Offers=";
    //  // $base_url = "http://www.citiworldprivileges.com/search/?act=loadMoreOffers&lastIndex=12&%E2%80%A6try=IN&city=&offer_type=48&offer_sub_type=&keyword=&sb=recent&top10Offers=";
    // // public function get_data(){
    // //   $this->load->view('get_data');
    // // }

/* End of file feed_pull.php */
/* Location: ./application/controllers/feed_pull.php */