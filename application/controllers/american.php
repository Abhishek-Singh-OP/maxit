<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class American extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        //Do your magic here
    }

    public function index(){
        $data = '[
    {
        "Offer_Details": {
        "Terms_Conditions": ["To receive this offer, purchase must be charged in full to any American Express® Card.", "American Express and the business establishment reserve the right to change the terms and conditions at any time without prior notice.", "Beverages not included.", "Black-out dates may apply.", "Offer cannot be combined with other promotions or offers.", "Rates are payable in local currency.", "Subject to Availability.", "Valid at Participating locations.", "<span style=\"font-size: 9pt;\"><span style=\"font-family: arial,sans-serif;\"><span style=\"color: black;\">The Selects Dining Offer is open to all American Express Cardmembers whose accounts are valid and in good standing. An American Express Cardmember (&quot;Cardmember&quot;) for the purpose of this Offer means a person holding a Card, issued either by American Express® or a third party bearing the name or trademark or service mark or logo of American Express (“Card”).<br>This Offer is being offered by the Participating Service Establishments (“Establishment(s)”) and shall be valid for offer period as mentioned against each Establishment. (you may refer to www.amexnetwork.com/selects/in for more details.<br>.This Offer is being made purely on a “best effort” basis. Cardmembers are not bound in any manner to participate in this Offer and any such participation is purely voluntary<br>This Offer is subject to availability and prior reservations through phone. Black-out dates apply<br>American Express is neither responsible for nor guarantees the quality of the goods / services and is not liable for any defect or deficiency of goods or services so obtained / availed of by the Cardmembers under this Offer<br>American Express reserves its absolute right to withdraw and / or alter any of the terms and conditions of the Offer at any time without prior notice.<br>Nothing expressed or implied in the Offer shall in any way waive or amend any of the terms and conditions of the existing Cardmember agreement with the Card issuer.<br>Any disputes arising out of and in connection with this Offer shall be subject to the exclusive jurisdiction of the courts in the state of Delhi only.</span></span></span><br> "],
        "Start_Date": "2015-07-07",
        "Redemption_Type": [{
            "Type": "In-store",
            "Redemption_URL": "http://",
            "Print_Offer": true,
            "Merchant_URL": "http://",
            "Merchant_Store_Locator_URL": null,
            "Merchant_Phone": null,
            "Merchant_Email": null,
            "Description": "Please ask for the offer before the bill is generated",
            "Code": null,
            "Barcode": null
        }],
        "Offer_Tier_Level": null,
        "Offer_id": "OF-0163738",
        "Name": "Cafe Lounge - Regenta Central Jaipur - Jaipur",
        "Logo_Image_Alt_Text": null,
        "Logo_Image": null,
        "Locations": [{
            "Longitude": null,
            "Location_Phone": null,
            "Latitude": null,
            "Address": "Regenta Central Jaipur, Opposite Jal Market Amer Road, Jaipur"
        }],
        "Images_URL": null,
        "Headline": "Save 15% on Food Bill",
        "End_Date": "2016-02-28",
        "Doc_Link": null,
        "Description": "Save 15% on Food Bill when making a purchase using your American Express card.",
        "Amex_Share_Offer_Message": null
    }
    }
]';

        $i = 0;
        $obj = json_decode($data);
        foreach ($obj as $value){

            // print_r($value->Offer_Details->Name);
            // echo "<br>";
            // print_r($value->Offer_Details->End_Date);
            // echo "<br>";
            // print_r($value->Offer_Details->Description);
            // echo "<br>";
            // print_r($value->Offer_Details->Headline);
            // echo "<br>";

            // while ($i < $value->Offer_Details->Page_Offers_Limit) {
                $data = array(
                        'card_name'      => '123480, 123481, 123482, 123483, 123573, 123673, 123674, 123712, 123713, 123714',
                        'offer'          => $value->Offer_Details->Headline,
                        'offer_category'          => 3,
                        'offer_subcategory'          => 12,
                        'offer_type'          => 'Discount percentage',
                        'amount'          => 15,
                        'establishment_id'          => $value->Offer_Details->Name,
                        'offer_content'  => $value->Offer_Details->Description,
                        'valid_till'     => $value->Offer_Details->End_Date,
                        'offer_url'      => 'http://offers.amexnetwork.com/gvp?campaignID=Cam-0000512&lang=en-us&category=&categoryLanding=false#&offerId=OF-0163927',
                    );

                // $i = $i + 1;
                // $this->db->insert('offers', $data);
                // print_r($data);
        }
    }
}




