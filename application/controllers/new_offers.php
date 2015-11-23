<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class new_offers extends CI_Controller {

	public function index()
	{
		$data['cities'] = $this->db->get("cities")->result();
		$data["categories"] = $this->db->get("categories_master")->result();
		$data["subcategories"] = $this->db->get("subcategories_master")->result();
		$data["app_categories"] = $this->db->query("SELECT * FROM categories_master LIMIT 9")->result();
		$data["app_subcategories"] = $this->db->query("SELECT * FROM subcategories_master GROUP BY category")->result();
		$data["establishments"] = $this->db->query("SELECT * from establishment")->result();
		$data["banks"] = $this->db->query("SELECT DISTINCT(issuing_organization) FROM card")->result();
		$data["affilations"] = $this->db->query("SELECT DISTINCT(affiliation) FROM card")->result();
		$this->load->view('admin/temp_est_form_add', $data);
	}

	public function scrape_offers(){
		for ($i=41; $i <=41 ; $i++) { 
			echo "Page ".$i."<br>";
			$url = "http://offers.smartbuy.hdfcbank.com/fiesta_list?page=".$i."&city=1&segment=1";
			$agent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.4) Gecko/20030624 Netscape/7.1 (ax)";
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_USERAGENT, $agent);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			$html = curl_exec($ch);
			/*echo $html;
			exit;*/

			if (!$html) {
				echo "
				cURL error number: " .curl_errno($ch) . " on URL: " . $url ."
				" .
					 "
				cURL error: " . curl_error($ch) . "
				";
			}

			curl_close($ch);

			$dom = new DOMDocument();
			@$dom->loadHtml($html);

			$xpath = new DOMXPath($dom);///html/body/div[@id='yourTagIdHere']
			//$articleList = $xpath->query("//div[@class='widget']/ul/li");
			$articleList = $xpath->query("//div[@id='Online_Shopping']/div[@class='clearfix']");
			foreach ($articleList as $value) {
				$establishment = $value->getElementsByTagName('p')->item(1)->nodeValue;
				$atags = $value->getElementsByTagName('a');
				foreach ($atags as $atag) {
					$detailurl = $atag->getAttribute( 'href' );
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL,$detailurl);
					curl_setopt($ch, CURLOPT_USERAGENT, $agent);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
					curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
					$detailhtml = curl_exec($ch);
					curl_close($ch);
					$dom = new DOMDocument();
					@$dom->loadHtml($detailhtml);
					$detailxpath = new DOMXPath($dom);///html/body/div[@id='yourTagIdHere']
					$imgs = $detailxpath->query("//div[@id='box2']");
					$offerimgurl='';
					foreach ($imgs as $img) {
						$offerimgurl = $img->getElementsByTagName('img')->item(0)->getAttribute('src');
					}
					$title = $detailxpath->query("//p[@id='text']")->item(0)->nodeValue;
					$address='';
					$adds = $detailxpath->query("//div[@id='box6']/p[@id='Address']");
					foreach ($adds as $add) {
						if($address==''){
							$address = $add->nodeValue;
						}
						else{
							$address .= ';'.$add->nodeValue;	
						}
					}
					//$address = str_replace($establishment.',', '', $adres);
					$offers = array(
						'offer' => trim(strip_tags($title)),
						'offer_category' => '3',
						'offer_subcategory' => '12',
						'establishment_id' => trim(strip_tags($establishment)),
						'offer_url' => trim(strip_tags($detailurl)),
						'offer_logo' => trim(strip_tags($offerimgurl)),
						'tnc' => '1.        All HDFC Credit cards, Debit cards and Pre-paid cards are accepted.
								2.        The offer cannot be clubbed with any other offer.
								3.        The offer is valid only at dine in restaurants, not applicable for online (except Dominos).
								4.        The offer is valid only at select outlets that are mentioned.
								5.        The offer is applicable on the net amount( excluding taxes)',
						'city' => trim(strip_tags($address)),
					 );
					//$this->db->insert('offersfetched', $offers);
					echo "<br><hr>";
					exit;
				}
			}
		}
	}

	public function scrape_offers1(){
		ini_set('MAX_EXECUTION_TIME', -1);
		$recordno=402;
		for ($i=91; $i <=93; $i++) { 
			echo "Page ".$i."<br>";
			$url = "http://offers.smartbuy.hdfcbank.com/dealsandfiesta?page=".$i."&city=&area=&category=";
			$agent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.4) Gecko/20030624 Netscape/7.1 (ax)";
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_USERAGENT, $agent);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			$html = curl_exec($ch);
			/*echo $html;
			exit;*/

			if (!$html) {
				echo "
				cURL error number: " .curl_errno($ch) . " on URL: " . $url ."
				" .
					 "
				cURL error: " . curl_error($ch) . "
				";
			}

			curl_close($ch);

			$dom = new DOMDocument();
			@$dom->loadHtml($html);

			$xpath = new DOMXPath($dom);///html/body/div[@id='yourTagIdHere']
			//$articleList = $xpath->query("//div[@class='widget']/ul/li");
			$articleList = $xpath->query("//div[@id='Online_Shopping']/div[@class='clearfix']");
			foreach ($articleList as $value) {
				$atags = $value->getElementsByTagName('a');
				foreach ($atags as $atag) {
					$offerflag = 'false';
					$detailurl = $atag->getAttribute( 'href' );
					$offerdetails='';
					$expiry = '';
					$offercat='';
					$offersubcat='';
					if (strpos($detailurl,'offer_details') !== false) {
						$detailurl = "http://offers.smartbuy.hdfcbank.com/".$detailurl;
						$expiry = $value->getElementsByTagName('p')->item(1)->nodeValue;
						$expiry = str_replace('Expires ','',$expiry);
						$offerflag = 'true';
					}
					else{
						$offercat='3';
						$offersubcat='12';
						$establishment = $value->getElementsByTagName('p')->item(1)->nodeValue;
						$offerflag = 'false';
					}
					//$detailurl = 'http://offers.smartbuy.hdfcbank.com/offer_details/45078/cc';
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL,trim($detailurl));
					curl_setopt($ch, CURLOPT_USERAGENT, $agent);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
					curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
					$detailhtml = curl_exec($ch);
					curl_close($ch);
					/*echo $detailhtml;
					exit;*/
					$dom = new DOMDocument();
					@$dom->loadHtml($detailhtml);
					$detailxpath = new DOMXPath($dom);///html/body/div[@id='yourTagIdHere']
					$imgs = $detailxpath->query("//div[@id='box2']");
					$offerimgurl='';
					/*print_r($imgs->item(0));
					echo "<br>";*/
					foreach ($imgs as $img) {
						$imgtemp = $img->getElementsByTagName('img');
						if($imgtemp->length != 0){
							$offerimgurl = $imgtemp->item(0)->getAttribute('src');
						}
					}
					if($offerflag == 'true'){
						$title = $detailxpath->query("//p[@id='text']")->item(0)->childNodes->item(3)->wholeText;
						$establishment = $detailxpath->query("//p[@id='text']")->item(0)->firstChild->wholeText;
						$tnc = $detailxpath->query("//div[@class='hpadding20']")->item(2)->textContent;
						// print_r($detailxpath->query("//div[@class='hpadding20']")->item(0));
						$offerdetails = $detailxpath->query("//div[@class='hpadding20']")->item(0)->textContent;
					}
					else{
						$tnc = '1.        All HDFC Credit cards, Debit cards and Pre-paid cards are accepted.
								2.        The offer cannot be clubbed with any other offer.
								3.        The offer is valid only at dine in restaurants, not applicable for online (except Dominos).
								4.        The offer is valid only at select outlets that are mentioned.
								5.        The offer is applicable on the net amount( excluding taxes)';
						$tnc='';
						$title = $detailxpath->query("//p[@id='text']")->item(0)->nodeValue;
					}

					$address='';
					$adds = $detailxpath->query("//div[@id='box6']/p[@id='Address']");
					foreach ($adds as $add) {
						if($address==''){
							$address = $add->nodeValue;
						}
						else{
							$address .= ';'.$add->nodeValue;	
						}
					}
					
					//$address = str_replace($establishment.',', '', $adres);
					$offers = array(
						'offer' => trim(strip_tags($title)),
						'offer_category' => $offercat,
						'offer_subcategory' => $offersubcat,
						'establishment_id' => trim(strip_tags($establishment)),
						'offer_url' => trim(strip_tags($detailurl)),
						'offer_logo' => trim(strip_tags($offerimgurl)),
						'offer_content' =>trim(strip_tags($offerdetails)),
						'tnc' => trim(strip_tags($tnc)),
						'city' => trim(strip_tags($address)),
						'valid_till' => $expiry
					 );
					$this->db->insert('offersfetchednew', $offers);
					$recordno++;
					//echo $recordno."<br>";
					//print_r($offers);
					//exit;
					///echo "<br><hr>";
				}
			}
		}
	}

	public function scrapeaxis(){
		ini_set('MAX_EXECUTION_TIME', -1);
		$url = "http://diningdelights.in/Offer.aspx?id=16";
		$agent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.4) Gecko/20030624 Netscape/7.1 (ax)";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		//curl_setopt($ch, CURLOPT_USERAGENT, $agent);
		//curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		$fields = array(
			'ScriptManager1' => 'UpdatePanel1|lnkBtnNext', 
			'hdncount' => '3', 
			'hdnaddress' => '', 
			'hdnlinkedin' => '', 
			'txtrestaurant_search' => '', 
			'wtrFullName_ClientState' => '', 
			'hdnrestaurant_search' => '', 
			'txtlocalityname_search' => '', 
			'TextBoxWatermarkExtender1_ClientState' => '', 
			'hdnlocalityname_search' => '', 
			'hdnLatitude' => '19.166327499999998', 
			'hdnLongitude' => '72.8485311', 
			'ddlcity1' => '16', 
			'hdEmpID' => '', 
			'RptOfferDetails$ctl01$hdnRest' => 'Noodle King – SP Info city', 
			'RptOfferDetails$ctl01$hdnflipbox' => '1', 
			'RptOfferDetails$ctl01$Child_RptOfferDetails$ctl00$HdnLocalityName' => 'Salai', 
			'RptOfferDetails$ctl01$Parent_RptLocalityDetails$ctl00$HdnLoc' => 'Salai', 
			'RptOfferDetails$ctl01$Parent_RptLocalityDetails$ctl00$Child_RptLocalityDetails$ctl00$HdnRestaurantName' => 'Noodle King – SP Info city', 
			'RptOfferDetails$ctl01$Parent_RptLocalityDetails$ctl00$Child_RptLocalityDetails$ctl00$HdnLocality' => 'Salai', 
			'hiddenInputToUpdateATBuffer_CommonToolkitScripts' => '1', 
			'__EVENTTARGET' => 'lnkBtnNext', 
			'hdnPageALLData' => '1', 
			'hdnPageSearch' => '1', 
			'__VIEWSTATE' => '/wEPDwUKMTQ5MjE3MTAzOQ9kFgICAw9kFgICCQ9kFgJmD2QWDAIBDxYCHgdWaXNpYmxlaGQCAw8WAh8AaBYCAgMPEA8WBh4NRGF0YVRleHRGaWVsZAUIQ2l0eU5hbWUeDkRhdGFWYWx1ZUZpZWxkBQZDaXR5SWQeC18hRGF0YUJvdW5kZ2QQFbECC1NlbGVjdCBDaXR5CUFobWVkYWJhZAlCYW5nYWxvcmUKQ2hhbmRpZ2FyaAdDaGVubmFpBURlbGhpCUh5ZGVyYWJhZAZKYWlwdXIHS29sa2F0YQZNdW1iYWkEUHVuZUYtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tCEFnYXJ0YWxhBEFncmEKQWhtZWRuYWdhcgVBam1lcghBbGFwdXpoYQdBbGlnYXJoCUFsbGFoYWJhZAdBbGxlcGV5BUFsd2FyCUFtYXJhdmF0aQZBbWJhamkGQW1iYWxhCEFtcmF2YXRpCEFtcml0c2FyBUFuYW5kCkFua2xlc2h3YXIHQXNhbnNvbApBdXJhbmdhYmFkCUJhZ2VzaHdhcglCYWxhY2hhdXIIQmFsYWNodXIFQmFsaWEGQmFyZGV6CEJhcmVpbGx5BkJhcm9kYQhCYXRoaW5kYQhCZWFudWxpbQRCZWFzB0JlbGdhdW0HQmVsbGFyeQZCZWxsdXIHQmhhcnVjaAhCaGF0aW5kYQlCaGF2bmFnYXIGQmhpbGFpB0JoaW10YWwHQmhpd2FkaQZCaG9wYWwLQmh1YmFuZXN3YXIEQmh1agdCaWthbmVyCEJpbGFzcHVyCEJpbGltb3JhBkJva2FybwhDYWJhY29uYQdDYWxpY3V0CENhbmRvbGltC0NoYW5kcmFnaXJpCkNoYW5kcmFwdXIPQ2hhbm5hcmF5YVBhdG5hC0NoZW5nYXBhbGxpC0NoaWttYWdhbHVyC0NoaXRyYWR1cmdhB0NoaXR0b3ILQ2hpdHRvcmdhcmgGQ29jaGluCkNvaW1iYXRvcmUHQ29vbm9vcgdDdXR0YWNrBURhaGVqBURhbWFuBERhbmcKRGFyamVlbGluZwZEYXN1eWEJRGF2YW5nZXJlCERlaHJhZHVuBURoYWthB0RoYW5iYWQLRGhhcmFtc2hhbGEHRGhhcndhZAlEaWJydWdhcmgHRGltYXB1cghEaW5kdWdhbAhEdXJnYXB1cgZEd2Fya2EORWFzdCBNZWRpbmlwdXIFRXJvZGUJRmFyaWRhYmFkCEZlcm96cHVyCEdhanJhdWxhC0dhbmRoaW5hZ2FyB0dhbmd0b2sER2F5YQlHaGF6aWFiYWQDR29hCEdvcGFscHVyCUdvcmFraHB1cg1HcmVhdGVyIE5vaWRhCUd1bmR1bHBldAZHdW50dXIHR3VyZ2FvbghHdXdhaGF0aQdHd2FsaW9yCEhhbGR3YW5pCkhhbmFta29uZGEISGFyaWR3YXIGSGlzc2FyBkhvb2dseQpIb3NoaWFycHVyBUhvc3VyBkhvd3JhaAVIdWJsaQZJbmRvcmUISmFiYWxwdXIJSmFpc2FsbWVyCUphbGFuZGhhcgpKYWxwYWlndXJpBUphbW11D0phbW11ICYgS2FzaG1pcghKYW1uYWdhcgpKYW1zaGVkcHVyCUpoYXJraGFuZAdKb2RocHVyBkpvcmhhdAhKdW5hZ2FkaAZLYWRhcGEIS2Fra2FuYWQJS2FsaW1wb25nC0thbmNoaXB1cmFtBkthbmdyYQZLYW5udXIGS2FucHVyCkthcmltbmFnYXIGS2FybmFsBUthcnVyCEthc2FyZ29kB0thc2F1bGkJS2F0aG1hbmR1BUthdHJhBktlcmFsYQlLaGFyYWdwdXIGS2hhcmFyCEtoYXJnaGFyCEtoYXRhdWxpB0toYXRpYXIFS29jaGkKS29kYWlrYW5hbAZLb2hpbWEFS29sYXIIS29saGFwdXIGS29sbGFtBEtvdGEIS290dGl5YW0MS3VsbHUgTWFuYWxpBkt1bWJsYQtLdXJ1a2VzaHRyYQxLdXNoYWxhbmFnYXIFS3V0Y2gGTGF2YXNhCkxlaC1MYWRha2gHTGVra2lkaQhMb25hdmFsYQRMb25pB0x1Y2tub3cITHVkaGlhbmEMTWFjbGVvZCBHYW5qBk1hZGR1cgdNYWR1cmFpDU1haGFiYWxlc2h3YXINTWFoYWJhbGlwdXJhbQVNYWxkYQtNYWxsZXN3YXJhbQZNYW5hbGkGTWFuZGxhBk1hbmR5YQlNYW5nYWxvcmUHTWFuZ2FvbgdNYW5pcGFsCU1hbnN1cnB1cgdNYXJhZ2FvCE1hcmNodWxhB01hdGh1cmEKTUNMRU9ER0FOSgZNZWVydXQETW9nYQZNb2hhbGkJTU9SQURBQkFECU1vdW50IEFidQhNdXNzb3JpZQZNeXNvcmUGTmFkaWFkBk5hZ2FvbgZOYWdhdXIJTmFnZXJjb2lsBk5hZ3B1cghOYWluaXRhbAhOYWxnb25kYQZOYXNoaWsLTmF2aSBNdW1iYWkHTmF2c2FyaQlOYXdhbGdhcmgKTmF3YW5zaGFocghOZWVtcmFuYQdOZWxsb3JlB05pbGdyaXMFTm9pZGEET290eQlQYWNobWFyaGkIUGFsYWtrYWQJUGFsYW0gUHVyBFBhbGkGUGFsd2FsCVBhbmNoa3VsYQdQYW5pcGF0CFBhcmFncHVyCFBhcmdhbmFzCVBhdGhhbmtvdAdQYXRpYWxhBVBhdG5hCFBoYWd3YXJhBlBpbXByaQtQb25kaWNoZXJyeQlQb3JiYW5kZXIKUG9ydCBCbGFpcgZQdW5qYWIEUHVyaQZSYWlnYWQGUmFpcHVyBlJhamtvdAdSYWpwdXJhBlJhanVsYQdSYW1nYXJoBlJhbmNoaQhSYW5pa2hldAlSYXRuYWdpcmkJUmlzaGlrZXNoBlJvaHRhawdSb29ya2VlCFJvdXJrZWxhCFJVREFSUFVSCVJ1cGFuYWdhcgpTYWhhcmFucHVyB1NhbGNldGUFU2FsZW0GU2FuZ2xpCFNhcHV0YXJhBlNhdGFyYQ5TYXdhaSBNYWRodXB1cgxTZWN1bmRlcmFiYWQFU2VvbmkLU2hhaGFyYW5wdXIJU2hhaWJhYmFkCFNoaWxsb25nBlNoaW1sYQZTaGlyZGkMU2hpdmtoZWRhcHVyBlNpZGt1bAdTaWxjaGFyCFNpbGlndXJpCFNpbHZhc3NhBVNvbGFuB1NvbGFwdXIHU29tbmF0aAdTb25pcGF0CFNyaW5hZ2FyDVNyaXBlcnVtYnVkdXIFU3VyYXQNU3VyZW5kcmFuYWdhcghTdXJ5YXBldAVUYW5kYQVUZWhyaQlUaGFsYXNlcnkFVGhhbmULVGhpbmRpdmFuYW0IVGhpcnVwdXIRVGhpcnV2YW5hdGhhcHVyYW0IVGlydXBhdGkHVGlydXB1cg5UaXJ1dmFubmFtYWxhaQlUaXRpY29yaW4KVG9vdGhpa3VkaQdUcmljaHVyBlRyaWNoeQdUcmlwdXJhBlR1bWt1cgdVZGFpcHVyBlVKSkFJTgpVbHVuZGVycGV0BlVtYXJpYQhWYWRvZGFyYQRWYXBpCFZhcmFuYXNpB1Zhc3RyYWwHVmVsbG9yZQpWaWpheWF3YWRhClZpbGxpcHVyYW0NVmlzYWtoYXBhdG5hbQVWaXphZwhXYXJhbmdhbAxZYW11bmEgTmFnYXIHWWVyY2FuZAZZZXJtYWwIWmlyYWtwdXIVsQIAAjE0ATcCMTICMTYDMTQyAjE1AjExATkBOAIxMAADMTIzAjc4AzE0MQIzMAMyODUDMTk2AzE5NwI4NwMyNjYDMjMwAjMxAzE2MQMxNDMCODACMzICMzMDMTI0AzIzMQI5NwMyNTQDMTcxAzMwNAI3OQMxOTgCMzQDMTcyAzI2MwMxNzMCMzUCMzYDMjEwAjM3AzI5MgIzOAMxMzgCOTgDMTU0AjM5AzEyMAI0MAMyMzMCODIDMjM1AzI0NAMzMDADMjIyAzI2NAMxMzACOTkDMjExAzIwMwMyMTIDMjU2AzEzMQMzMDUCNDECNjEDMjI2AzEyMQI2NQMyMzYCNjYDMTI1AzE3NAMyMTMDMTkyAzIzOQMxMTYDMzE1AzI0MgMxMTMCNDMDMTAwAzEyNgMyMTcDMTAxAzIwNAE0AzE3NQMxOTkDMTg4AjU4AzI2NQE1AjE4AzMwMgMyNjcBNgMyMTQCNDQDMTQ0AzExNAMxMzkDMTU5AjQ1AjI5AzMxOAMxMjcDMTc2AjIxAzI5NQMyMTUCOTYDMTQwAzI0MQMxNzcDMjcxAzE2OAI2NwI0NgMxMTcDMjUyAjgxAzI3MwI2OAMyODMDMjg2AzI3MgMyMDUDMzIxAjQ3AzIwMAMyODEDMTQ2AzI4OAMyOTcDMjYyAjY5AzE2OQMyMzcDMTI4AzI5MwMxNDUDMjkxAzI3NAMyNTcDMjA2AjQ4AzIyOAMxNDcDMjc2AjQ5AzEwMgI4OAMyMjMDMTYyAzIxNgI3MAMxNDgDMzEwAzIyNAI4OQMxNTACNTACODMDMTY0AzIxOAI1MQI5MAMyMDcDMjY4AzI5OQMxNjUDMTAzAzIxOQI1OQMyMjkCOTEDMjUwAjk0AzMwNgMxNTcDMjQ1AzE1OAMxNzgDMTc5AzI0NgI1MgMxOTMCMjICNTMDMTA0AzMxNgMyNTgCMTcCMjgDMTMyAzExMQMyMzICNTQDMzE3AzE4MAMzMTQDMTMzAzEwNQEzAzIyNwMzMDcCNzEDMTY2AzMxMQMxNDkCMTMDMTUxAzMwOAMxMDYDMTgxAzE4MgMxMTUDMTgzAzI0MwMyMDICNTUDMjcwAzI4NAMxMjIDMTUzAjg2AjU2AzE4NQI3MgMzMjADMTE4AzMxMgMyNjkDMTk0AzE1MgMxOTUDMzAzAzI0NwMxODYDMTkwAzMwMQMyOTADMTU1AjczAzE1NgMzMTMDMTA3AzEwOAMyNDkDMjk0Ajg1AzEwOQI3NAMxODQDMTYwAzI5NgMxMjkCNzUDMTY3AjI3Ajc2AzI3OQMxNzACOTUCNTcDMTkxAzEzNQMxODcDMTEwAzI5OAI2MgMyNzgDMjA4AzIyNQIyNAMyNzcDMjU5AzI2MAMyODkDMjc1AzI4NwMyNTMDMjIwAjYzAzI0OAMyMDkDMzA5Ajc3AjkzAzIwMQI2NAIyNQIyNgMyODADMjU1AzEzNwMyODIDMTYzAzI2MQMyMjEDMTg5FCsDsQJnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZxYBZmQCBw8QDxYGHwEFC2N1c2luZXNOYW1lHwIFBUN1c0lEHwNnZBAVUgdBZmdoYW5pCEFtZXJpY2FuBkFuZGhyYQdBcmFiaWFuBUFzaWFuCEFzc2FtZXNlCUF1dGhlbnRpYwZBd2FkaGkGQmFrZXJ5C0JCUSBDdWlzaW5lB0JlbmdhbGkIQmV2ZXJhZ2UJQmV2ZXJhZ2VzB0JpcnlhbmkKQnJhemlsbGlhbgdCcml0aXNoCEJ1a2hhYXJpBUNhZsOpCUNoZXR0aW5hZAdDaGluZXNlC0NvbnRpbmVudGFsCERlc3NlcnRzC0V1cm8gQnJpc3RvCEV1cm9wZWFuCUZhc3QgRm9vZAtGaW5nZXIgRm9vZAZGcmVuY2gLRnVzaW9uIEZvb2QGR2VybWFuBEdvYW4FR3JlZWsIR3VqYXJhdGkKSHlkZXJhYmFkaQlJY2UgQ3JlYW0GSW5kaWFuCkluZG9uZXNpYW4VSW50ZXJuYXRpb25hbCBDdWlzaW5lB0l0YWxpYW4JSmFpbiBGb29kCEphcGFuZXNlB0phcGVuc2UIS2FzaG1pcmkGS2VyYWxhBktvcmVhbghMZWJhbmVzZQhMdWNrbm93aQ1NYWhhcmFzaHRyaWFuCU1hbGF5c2lhbgdNYWx3YW5pC01hbmdhbG9yZWFuDU1lZGl0ZXJyYW5lYW4HTWV4aWNhbg5NaWRkbGUgRWFzdGVybghNb3JvY2NhbgdNdWdobGFpBE5hZ2EMTm9ydGggSW5kaWFuBE9kaWEIT3JpZW50YWwJUGFraXN0YW5pCVBhbiBBc2lhbgVQYXJzaQdQZXJzaWFuCVBlc2hhd2FyaQVQaXp6YQpQb3J0dWd1ZXNlB1B1bmphYmkKUmFqYXN0aGFuaQVSb21hbghTZWEgRm9vZAhTaXp6bGVycwZTbmFja3MMU291dGggSW5kaWFuB1NwYW5pc2gLU3RyZWV0IEZvb2QIVGFuZG9vcmkHVGV4IE1leAdUZXgtTWV4BFRoYWkIVGliZXRpYW4HVHVya2lzaApWaWV0bmFtZXNlFVICNDgCMTACNTICMTEBOAI3MAMxMDACMjgCNjIDMTAyAjQ2AjUwAjg5AjI5AjkyAjU0Ajc1AjQ3AjczATYBNwIxMwMxMDUCMTQCMTUCMTYCMTcCNzgCMzkCNzYCMzACNjECNDACODcCMTgCNDMDMTA0ATICMzECMzICODgCNzECNDkCMTkBNQIzNwI2MAIzNgI3NwI1MQIyMAE0AjIxAjMzAjIyAjY5ATMCNzkCMzQCMjMCOTgCNjMCNDECNzQCMjQCOTcDMTAzAjM1AjgyAjI1AjcyAjgzAjQyAjY4AjUzAjQ0Ajg1AjQ1ATkCODQCMjcCMzgUKwNSZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2RkAhsPFgIeC18hSXRlbUNvdW50AgEWAmYPZBYGAgEPFgIeA3NyYwVUL2ltYWdlcy9tYW5hZ2VPZmZlcnMvQmFubmVySW1hZ2UvSW1hZ2VfRGluaW5nRGVsaWdodHNfYmFubmVyMV8wODEwMjAxNV8xMjA3MzlfUE0uanBnZAIDDxYCHwUFVC9pbWFnZXMvbWFuYWdlT2ZmZXJzL0Jhbm5lckltYWdlL0ltYWdlX0RpbmluZ0RlbGlnaHRzX2Jhbm5lcjJfMDgxMDIwMTVfMTIwNzM5X1BNLmpwZ2QCBQ8WAh8FBVQvaW1hZ2VzL21hbmFnZU9mZmVycy9CYW5uZXJJbWFnZS9JbWFnZV9EaW5pbmdEZWxpZ2h0c19iYW5uZXIzXzA4MTAyMDE1XzEyMDczOV9QTS5qcGdkAh8PEA8WBh8BBQhDaXR5TmFtZR8CBQZDaXR5SWQfA2dkEBWxAgtTZWxlY3QgQ2l0eQlBaG1lZGFiYWQJQmFuZ2Fsb3JlCkNoYW5kaWdhcmgHQ2hlbm5haQVEZWxoaQlIeWRlcmFiYWQGSmFpcHVyB0tvbGthdGEGTXVtYmFpBFB1bmVGLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQhBZ2FydGFsYQRBZ3JhCkFobWVkbmFnYXIFQWptZXIIQWxhcHV6aGEHQWxpZ2FyaAlBbGxhaGFiYWQHQWxsZXBleQVBbHdhcglBbWFyYXZhdGkGQW1iYWppBkFtYmFsYQhBbXJhdmF0aQhBbXJpdHNhcgVBbmFuZApBbmtsZXNod2FyB0FzYW5zb2wKQXVyYW5nYWJhZAlCYWdlc2h3YXIJQmFsYWNoYXVyCEJhbGFjaHVyBUJhbGlhBkJhcmRleghCYXJlaWxseQZCYXJvZGEIQmF0aGluZGEIQmVhbnVsaW0EQmVhcwdCZWxnYXVtB0JlbGxhcnkGQmVsbHVyB0JoYXJ1Y2gIQmhhdGluZGEJQmhhdm5hZ2FyBkJoaWxhaQdCaGltdGFsB0JoaXdhZGkGQmhvcGFsC0JodWJhbmVzd2FyBEJodWoHQmlrYW5lcghCaWxhc3B1cghCaWxpbW9yYQZCb2thcm8IQ2FiYWNvbmEHQ2FsaWN1dAhDYW5kb2xpbQtDaGFuZHJhZ2lyaQpDaGFuZHJhcHVyD0NoYW5uYXJheWFQYXRuYQtDaGVuZ2FwYWxsaQtDaGlrbWFnYWx1cgtDaGl0cmFkdXJnYQdDaGl0dG9yC0NoaXR0b3JnYXJoBkNvY2hpbgpDb2ltYmF0b3JlB0Nvb25vb3IHQ3V0dGFjawVEYWhlagVEYW1hbgREYW5nCkRhcmplZWxpbmcGRGFzdXlhCURhdmFuZ2VyZQhEZWhyYWR1bgVEaGFrYQdEaGFuYmFkC0RoYXJhbXNoYWxhB0RoYXJ3YWQJRGlicnVnYXJoB0RpbWFwdXIIRGluZHVnYWwIRHVyZ2FwdXIGRHdhcmthDkVhc3QgTWVkaW5pcHVyBUVyb2RlCUZhcmlkYWJhZAhGZXJvenB1cghHYWpyYXVsYQtHYW5kaGluYWdhcgdHYW5ndG9rBEdheWEJR2hhemlhYmFkA0dvYQhHb3BhbHB1cglHb3Jha2hwdXINR3JlYXRlciBOb2lkYQlHdW5kdWxwZXQGR3VudHVyB0d1cmdhb24IR3V3YWhhdGkHR3dhbGlvcghIYWxkd2FuaQpIYW5hbWtvbmRhCEhhcmlkd2FyBkhpc3NhcgZIb29nbHkKSG9zaGlhcnB1cgVIb3N1cgZIb3dyYWgFSHVibGkGSW5kb3JlCEphYmFscHVyCUphaXNhbG1lcglKYWxhbmRoYXIKSmFscGFpZ3VyaQVKYW1tdQ9KYW1tdSAmIEthc2htaXIISmFtbmFnYXIKSmFtc2hlZHB1cglKaGFya2hhbmQHSm9kaHB1cgZKb3JoYXQISnVuYWdhZGgGS2FkYXBhCEtha2thbmFkCUthbGltcG9uZwtLYW5jaGlwdXJhbQZLYW5ncmEGS2FubnVyBkthbnB1cgpLYXJpbW5hZ2FyBkthcm5hbAVLYXJ1cghLYXNhcmdvZAdLYXNhdWxpCUthdGhtYW5kdQVLYXRyYQZLZXJhbGEJS2hhcmFncHVyBktoYXJhcghLaGFyZ2hhcghLaGF0YXVsaQdLaGF0aWFyBUtvY2hpCktvZGFpa2FuYWwGS29oaW1hBUtvbGFyCEtvbGhhcHVyBktvbGxhbQRLb3RhCEtvdHRpeWFtDEt1bGx1IE1hbmFsaQZLdW1ibGELS3VydWtlc2h0cmEMS3VzaGFsYW5hZ2FyBUt1dGNoBkxhdmFzYQpMZWgtTGFkYWtoB0xla2tpZGkITG9uYXZhbGEETG9uaQdMdWNrbm93CEx1ZGhpYW5hDE1hY2xlb2QgR2FuagZNYWRkdXIHTWFkdXJhaQ1NYWhhYmFsZXNod2FyDU1haGFiYWxpcHVyYW0FTWFsZGELTWFsbGVzd2FyYW0GTWFuYWxpBk1hbmRsYQZNYW5keWEJTWFuZ2Fsb3JlB01hbmdhb24HTWFuaXBhbAlNYW5zdXJwdXIHTWFyYWdhbwhNYXJjaHVsYQdNYXRodXJhCk1DTEVPREdBTkoGTWVlcnV0BE1vZ2EGTW9oYWxpCU1PUkFEQUJBRAlNb3VudCBBYnUITXVzc29yaWUGTXlzb3JlBk5hZGlhZAZOYWdhb24GTmFnYXVyCU5hZ2VyY29pbAZOYWdwdXIITmFpbml0YWwITmFsZ29uZGEGTmFzaGlrC05hdmkgTXVtYmFpB05hdnNhcmkJTmF3YWxnYXJoCk5hd2Fuc2hhaHIITmVlbXJhbmEHTmVsbG9yZQdOaWxncmlzBU5vaWRhBE9vdHkJUGFjaG1hcmhpCFBhbGFra2FkCVBhbGFtIFB1cgRQYWxpBlBhbHdhbAlQYW5jaGt1bGEHUGFuaXBhdAhQYXJhZ3B1cghQYXJnYW5hcwlQYXRoYW5rb3QHUGF0aWFsYQVQYXRuYQhQaGFnd2FyYQZQaW1wcmkLUG9uZGljaGVycnkJUG9yYmFuZGVyClBvcnQgQmxhaXIGUHVuamFiBFB1cmkGUmFpZ2FkBlJhaXB1cgZSYWprb3QHUmFqcHVyYQZSYWp1bGEHUmFtZ2FyaAZSYW5jaGkIUmFuaWtoZXQJUmF0bmFnaXJpCVJpc2hpa2VzaAZSb2h0YWsHUm9vcmtlZQhSb3Vya2VsYQhSVURBUlBVUglSdXBhbmFnYXIKU2FoYXJhbnB1cgdTYWxjZXRlBVNhbGVtBlNhbmdsaQhTYXB1dGFyYQZTYXRhcmEOU2F3YWkgTWFkaHVwdXIMU2VjdW5kZXJhYmFkBVNlb25pC1NoYWhhcmFucHVyCVNoYWliYWJhZAhTaGlsbG9uZwZTaGltbGEGU2hpcmRpDFNoaXZraGVkYXB1cgZTaWRrdWwHU2lsY2hhcghTaWxpZ3VyaQhTaWx2YXNzYQVTb2xhbgdTb2xhcHVyB1NvbW5hdGgHU29uaXBhdAhTcmluYWdhcg1TcmlwZXJ1bWJ1ZHVyBVN1cmF0DVN1cmVuZHJhbmFnYXIIU3VyeWFwZXQFVGFuZGEFVGVocmkJVGhhbGFzZXJ5BVRoYW5lC1RoaW5kaXZhbmFtCFRoaXJ1cHVyEVRoaXJ1dmFuYXRoYXB1cmFtCFRpcnVwYXRpB1RpcnVwdXIOVGlydXZhbm5hbWFsYWkJVGl0aWNvcmluClRvb3RoaWt1ZGkHVHJpY2h1cgZUcmljaHkHVHJpcHVyYQZUdW1rdXIHVWRhaXB1cgZVSkpBSU4KVWx1bmRlcnBldAZVbWFyaWEIVmFkb2RhcmEEVmFwaQhWYXJhbmFzaQdWYXN0cmFsB1ZlbGxvcmUKVmlqYXlhd2FkYQpWaWxsaXB1cmFtDVZpc2FraGFwYXRuYW0FVml6YWcIV2FyYW5nYWwMWWFtdW5hIE5hZ2FyB1llcmNhbmQGWWVybWFsCFppcmFrcHVyFbECAAIxNAE3AjEyAjE2AzE0MgIxNQIxMQE5ATgCMTAAAzEyMwI3OAMxNDECMzADMjg1AzE5NgMxOTcCODcDMjY2AzIzMAIzMQMxNjEDMTQzAjgwAjMyAjMzAzEyNAMyMzECOTcDMjU0AzE3MQMzMDQCNzkDMTk4AjM0AzE3MgMyNjMDMTczAjM1AjM2AzIxMAIzNwMyOTICMzgDMTM4Ajk4AzE1NAIzOQMxMjACNDADMjMzAjgyAzIzNQMyNDQDMzAwAzIyMgMyNjQDMTMwAjk5AzIxMQMyMDMDMjEyAzI1NgMxMzEDMzA1AjQxAjYxAzIyNgMxMjECNjUDMjM2AjY2AzEyNQMxNzQDMjEzAzE5MgMyMzkDMTE2AzMxNQMyNDIDMTEzAjQzAzEwMAMxMjYDMjE3AzEwMQMyMDQBNAMxNzUDMTk5AzE4OAI1OAMyNjUBNQIxOAMzMDIDMjY3ATYDMjE0AjQ0AzE0NAMxMTQDMTM5AzE1OQI0NQIyOQMzMTgDMTI3AzE3NgIyMQMyOTUDMjE1Ajk2AzE0MAMyNDEDMTc3AzI3MQMxNjgCNjcCNDYDMTE3AzI1MgI4MQMyNzMCNjgDMjgzAzI4NgMyNzIDMjA1AzMyMQI0NwMyMDADMjgxAzE0NgMyODgDMjk3AzI2MgI2OQMxNjkDMjM3AzEyOAMyOTMDMTQ1AzI5MQMyNzQDMjU3AzIwNgI0OAMyMjgDMTQ3AzI3NgI0OQMxMDICODgDMjIzAzE2MgMyMTYCNzADMTQ4AzMxMAMyMjQCODkDMTUwAjUwAjgzAzE2NAMyMTgCNTECOTADMjA3AzI2OAMyOTkDMTY1AzEwMwMyMTkCNTkDMjI5AjkxAzI1MAI5NAMzMDYDMTU3AzI0NQMxNTgDMTc4AzE3OQMyNDYCNTIDMTkzAjIyAjUzAzEwNAMzMTYDMjU4AjE3AjI4AzEzMgMxMTEDMjMyAjU0AzMxNwMxODADMzE0AzEzMwMxMDUBMwMyMjcDMzA3AjcxAzE2NgMzMTEDMTQ5AjEzAzE1MQMzMDgDMTA2AzE4MQMxODIDMTE1AzE4MwMyNDMDMjAyAjU1AzI3MAMyODQDMTIyAzE1MwI4NgI1NgMxODUCNzIDMzIwAzExOAMzMTIDMjY5AzE5NAMxNTIDMTk1AzMwMwMyNDcDMTg2AzE5MAMzMDEDMjkwAzE1NQI3MwMxNTYDMzEzAzEwNwMxMDgDMjQ5AzI5NAI4NQMxMDkCNzQDMTg0AzE2MAMyOTYDMTI5Ajc1AzE2NwIyNwI3NgMyNzkDMTcwAjk1AjU3AzE5MQMxMzUDMTg3AzExMAMyOTgCNjIDMjc4AzIwOAMyMjUCMjQDMjc3AzI1OQMyNjADMjg5AzI3NQMyODcDMjUzAzIyMAI2MwMyNDgDMjA5AzMwOQI3NwI5MwMyMDECNjQCMjUCMjYDMjgwAzI1NQMxMzcDMjgyAzE2MwMyNjEDMjIxAzE4ORQrA7ECZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2cWAQIEZAInD2QWBAIBDxYCHwQCDxYeAgEPZBYCAgEPZBYIZg8VAQEwZAIFD2QWAgIBDxYCHwQCARYCZg9kFgpmDxUND2NsYXNzPSdwYXJraW5nJwxjbGFzcz0nd2lmaScLY2xhc3M9J3ZlZycNY2xhc3M9J2dyaWxsJwtjbGFzcz0nYmFyJwAxL2ltYWdlcy9tYW5hZ2VPZmZlcnMvUmVzdGF1cmFudEltYWdlL2tpbmcgbmV3LnBuZwMxNSUQT2ZmIE9uIEZvb2QgQmlsbBxOb29kbGUgS2luZyDigJMgU1AgSW5mbyBjaXR5B0NoaW5lc2UoU1AgSW5mbyBDaXR5IE5vIOKAkyA0MCxNR1IgU2FsYWksQ2hlbm5haQozMS8wMy8yMDE2ZAIBDxYCHwBoZAICDxUDDDA0NCAzMjAwNDE0MQwwNDQgMzIwMDQxNDEOMTEgQU0gdG8gMTEgUE1kAgQPFQFXTm90IFZhbGlkIG9uICBBbGNvaG9saWMgJiBOb24gQWxjb2hvbGljIEJldmVyYWdlcyBvbiBNaW5pbXVtIEJpbGwgb2YgUnMuIDUwMC4wMCAmIEFib3ZlZAIGDxUDYkVuam95IG1pbmltdW0gMTUlIG9mZiBhdCBvdmVyIDEsNTAwIHJlc3RhdXJhbnRzIGFjcm9zcyBJbmRpYSB3aXRoICNBeGlzQmFuayBDYXJkcyEgI0RpbmluZ0RlbGlnaHRzSUkgZm91bmQgYSBncmVhdCBvZmZlciBhdCBOb29kbGUgS2luZyDigJMgU1AgSW5mbyBjaXR5IG9uIEF4aXMgQmFuayBDYXJkcyFCSSBqdXN0IGRpc2NvdmVyZWQgYSBncmVhdCBvZmZlciBhdCBOb29kbGUgS2luZyBvbiBBeGlzIEJhbmsgQ2FyZHMhZAIGDxUBHE5vb2RsZSBLaW5nIOKAkyBTUCBJbmZvIGNpdHlkAgcPFgIfBAIBFgJmD2QWBAIBDw8WAh4EVGV4dAUFU2FsYWlkZAIFDxYCHwQCARYCZg9kFgICAQ8QDxYCHwYFKFNQIEluZm8gQ2l0eSBObyDigJMgNDAsTUdSIFNhbGFpLENoZW5uYWlkZGRkAgIPZBYCAgEPZBYIZg8VAQExZAIFD2QWAgIBDxYCHwQCARYCZg9kFgpmDxUND2NsYXNzPSdwYXJraW5nJwxjbGFzcz0nd2lmaScLY2xhc3M9J3ZlZycNY2xhc3M9J2dyaWxsJwtjbGFzcz0nYmFyJwAxL2ltYWdlcy9tYW5hZ2VPZmZlcnMvUmVzdGF1cmFudEltYWdlL2tpbmcgbmV3LnBuZwMxNSUQT2ZmIE9uIEZvb2QgQmlsbCBOb29kbGUgS2luZyDigJMgQ29yb21hbmRlbCBQbGF6YQdDaGluZXNlOkNvcm9tYW5kZWwgUGxhemEsKDR0aCBmbG9vcilPbGQgTWFoYWJhbGlwdXJhbSBSb2FkLENoZW5uYWkKMzEvMDMvMjAxNmQCAQ8WAh8AaGQCAg8VAwwwNDQgNDMzMDUxNTEMMDQ0IDQzMzA1MTUxDjExIEFNIHRvIDExIFBNZAIEDxUBV05vdCBWYWxpZCBvbiAgQWxjb2hvbGljICYgTm9uIEFsY29ob2xpYyBCZXZlcmFnZXMgb24gTWluaW11bSBCaWxsIG9mIFJzLiA1MDAuMDAgJiBBYm92ZWQCBg8VA2JFbmpveSBtaW5pbXVtIDE1JSBvZmYgYXQgb3ZlciAxLDUwMCByZXN0YXVyYW50cyBhY3Jvc3MgSW5kaWEgd2l0aCAjQXhpc0JhbmsgQ2FyZHMhICNEaW5pbmdEZWxpZ2h0c01JIGZvdW5kIGEgZ3JlYXQgb2ZmZXIgYXQgTm9vZGxlIEtpbmcg4oCTIENvcm9tYW5kZWwgUGxhemEgb24gQXhpcyBCYW5rIENhcmRzIUJJIGp1c3QgZGlzY292ZXJlZCBhIGdyZWF0IG9mZmVyIGF0IE5vb2RsZSBLaW5nIG9uIEF4aXMgQmFuayBDYXJkcyFkAgYPFQEgTm9vZGxlIEtpbmcg4oCTIENvcm9tYW5kZWwgUGxhemFkAgcPFgIfBAIBFgJmD2QWBAIBDw8WAh8GBQ1NYWhhYmFsaXB1cmFtZGQCBQ8WAh8EAgEWAmYPZBYCAgEPEA8WAh8GBTpDb3JvbWFuZGVsIFBsYXphLCg0dGggZmxvb3IpT2xkIE1haGFiYWxpcHVyYW0gUm9hZCxDaGVubmFpZGRkZAIDD2QWAgIBD2QWCGYPFQEBMmQCBQ9kFgICAQ8WAh8EAgEWAmYPZBYIZg8VDQ9jbGFzcz0ncGFya2luZycTY2xhc3M9J3dpZmkgYWN0aXZlJxJjbGFzcz0ndmVnIGFjdGl2ZScNY2xhc3M9J2dyaWxsJwtjbGFzcz0nYmFyJwA5L2ltYWdlcy9tYW5hZ2VPZmZlcnMvUmVzdGF1cmFudEltYWdlL25ldyBiYXJpc3RhIGxvZ28uanBnAzE1JRFPZmYgb24gVG90YWwgQmlsbAdCYXJpc3RhBUNhZsOpNkJsb2NrIDlBJkIsIDh0aCBGbG9vciwgRExGIElUIFBhcmssIFJhbWFwdXJhbSwgQ2hlbm5haQoyMy8wNi8yMDE2ZAICDxUDDDAxMSA0OTM2MDkxMQwwMTEgNDkzNjA5MTENOCBBTSB0byAxMSBQTWQCBA8VAThPbiBNaW5pbXVtLiBCaWxsIG9mIFJzLiAyNTAuICYgQWJvdmUgb24gRm9vZCAmIEJldmVyYWdlc2QCBg8VA2JFbmpveSBtaW5pbXVtIDE1JSBvZmYgYXQgb3ZlciA0LDAwMCByZXN0YXVyYW50cyBhY3Jvc3MgSW5kaWEgd2l0aCAjQXhpc0JhbmsgQ2FyZHMhICNEaW5pbmdEZWxpZ2h0czRJIGZvdW5kIGEgZ3JlYXQgb2ZmZXIgYXQgQmFyaXN0YSBvbiBBeGlzIEJhbmsgQ2FyZHMhPkkganVzdCBkaXNjb3ZlcmVkIGEgZ3JlYXQgb2ZmZXIgYXQgQmFyaXN0YSBvbiBBeGlzIEJhbmsgQ2FyZHMhZAIGDxUBB0JhcmlzdGFkAgcPFgIfBAIDFgZmD2QWBAIBDw8WAh8GBQxCZXNhbnQgTmFnYXJkZAIFDxYCHwQC/////w9kAgEPZBYEAgEPDxYCHwYFE0V4cHJlc3MgQXZlbnVlIE1hbGxkZAIFDxYCHwQC/////w9kAgIPZBYEAgEPDxYCHwYFCVJhbWFwdXJhbWRkAgUPFgIfBAIBFgJmD2QWAgIBDxAPFgIfBgU2QmxvY2sgOUEmQiwgOHRoIEZsb29yLCBETEYgSVQgUGFyaywgUmFtYXB1cmFtLCBDaGVubmFpZGRkZAIED2QWAgIBD2QWCGYPFQEBM2QCBQ9kFgICAQ8WAh8EAgEWAmYPZBYKZg8VDQ9jbGFzcz0ncGFya2luZycMY2xhc3M9J3dpZmknC2NsYXNzPSd2ZWcnDWNsYXNzPSdncmlsbCcSY2xhc3M9J2JhciBhY3RpdmUnADEvaW1hZ2VzL21hbmFnZU9mZmVycy9SZXN0YXVyYW50SW1hZ2UvQmFyIENvZGUuanBnAzE1JRBPZmYgb24gRm9vZCBCaWxsCEJhciBDb2RlADFUaGUgS2luZ3MgSG90ZWwsIDMyLCBIYWxscyBSb2FkLMKgRWdtb3JlLCBDaGVubmFpCjMxLzA1LzIwMTZkAgEPFgIfAGhkAgIPFQMMMDQ0IDI4MTkyODE5DDA0NCAyODE5MjgxOQ4xMSBBTSB0byAxMSBQTWQCBA8VATFOb3QgVmFsaWQgb24gIEFsY29ob2xpYyAmIE5vbiBBbGNvaG9saWMgQmV2ZXJhZ2VzZAIGDxUDYkVuam95IG1pbmltdW0gMTUlIG9mZiBhdCBvdmVyIDQsMDAwIHJlc3RhdXJhbnRzIGFjcm9zcyBJbmRpYSB3aXRoICNBeGlzQmFuayBDYXJkcyEgI0RpbmluZ0RlbGlnaHRzNUkgZm91bmQgYSBncmVhdCBvZmZlciBhdCBCYXIgQ29kZSBvbiBBeGlzIEJhbmsgQ2FyZHMhP0kganVzdCBkaXNjb3ZlcmVkIGEgZ3JlYXQgb2ZmZXIgYXQgQmFyIENvZGUgb24gQXhpcyBCYW5rIENhcmRzIWQCBg8VAQhCYXIgQ29kZWQCBw8WAh8EAgEWAmYPZBYEAgEPDxYCHwYFBkVnbW9yZWRkAgUPFgIfBAIBFgJmD2QWAgIBDxAPFgIfBgUxVGhlIEtpbmdzIEhvdGVsLCAzMiwgSGFsbHMgUm9hZCzCoEVnbW9yZSwgQ2hlbm5haWRkZGQCBQ9kFgICAQ9kFghmDxUBATRkAgUPZBYCAgEPFgIfBAIBFgJmD2QWCmYPFQ0PY2xhc3M9J3BhcmtpbmcnE2NsYXNzPSd3aWZpIGFjdGl2ZScLY2xhc3M9J3ZlZycNY2xhc3M9J2dyaWxsJxJjbGFzcz0nYmFyIGFjdGl2ZScAMC9pbWFnZXMvbWFuYWdlT2ZmZXJzL1Jlc3RhdXJhbnRJbWFnZS9Bbnl0aW1lLmpwZwMxNSURT2ZmIG9uIFRvdGFsIEJpbGwHQW55dGltZRxDaGluZXNlLCBDb250aW5lbnRhbCwgSW5kaWFuKTEyMCwgU0lSLCBUaGFnYXJ1YSBSb2FkLCBUIE5hZ2FyLCBDaGVubmFpCjMxLzA1LzIwMTZkAgEPFgIfAGhkAgIPFQMMMDQ0IDI4MTUwNTAwDDA0NCAyODE1MDUwMBQxMSBBTSB0byAxMiBNaWRuaWdodGQCBA8VAQBkAgYPFQNiRW5qb3kgbWluaW11bSAxNSUgb2ZmIGF0IG92ZXIgNCwwMDAgcmVzdGF1cmFudHMgYWNyb3NzIEluZGlhIHdpdGggI0F4aXNCYW5rIENhcmRzISAjRGluaW5nRGVsaWdodHM0SSBmb3VuZCBhIGdyZWF0IG9mZmVyIGF0IEFueXRpbWUgb24gQXhpcyBCYW5rIENhcmRzIT5JIGp1c3QgZGlzY292ZXJlZCBhIGdyZWF0IG9mZmVyIGF0IEFueXRpbWUgb24gQXhpcyBCYW5rIENhcmRzIWQCBg8VAQdBbnl0aW1lZAIHDxYCHwQCARYCZg9kFgQCAQ8PFgIfBgUHVCBOYWdhcmRkAgUPFgIfBAIBFgJmD2QWAgIBDxAPFgIfBgUpMTIwLCBTSVIsIFRoYWdhcnVhIFJvYWQsIFQgTmFnYXIsIENoZW5uYWlkZGRkAgYPZBYCAgEPZBYIZg8VAQE1ZAIFD2QWAgIBDxYCHwQCARYCZg9kFgpmDxUND2NsYXNzPSdwYXJraW5nJxNjbGFzcz0nd2lmaSBhY3RpdmUnC2NsYXNzPSd2ZWcnDWNsYXNzPSdncmlsbCcSY2xhc3M9J2JhciBhY3RpdmUnADAvaW1hZ2VzL21hbmFnZU9mZmVycy9SZXN0YXVyYW50SW1hZ2UvQW55dGltZS5qcGcDMTUlEU9mZiBvbiBUb3RhbCBCaWxsBkF6dWxpYRxDaGluZXNlLCBDb250aW5lbnRhbCwgSW5kaWFuKTEyMCwgU0lSLCBUaGFnYXJ1YSBSb2FkLCBUIE5hZ2FyLCBDaGVubmFpCjMxLzA1LzIwMTZkAgEPFgIfAGhkAgIPFQMMMDQ0IDI4MTUwNTAwDDA0NCAyODE1MDUwMBQxMSBBTSB0byAxMiBNaWRuaWdodGQCBA8VAQBkAgYPFQNiRW5qb3kgbWluaW11bSAxNSUgb2ZmIGF0IG92ZXIgNCwwMDAgcmVzdGF1cmFudHMgYWNyb3NzIEluZGlhIHdpdGggI0F4aXNCYW5rIENhcmRzISAjRGluaW5nRGVsaWdodHMzSSBmb3VuZCBhIGdyZWF0IG9mZmVyIGF0IEF6dWxpYSBvbiBBeGlzIEJhbmsgQ2FyZHMhPUkganVzdCBkaXNjb3ZlcmVkIGEgZ3JlYXQgb2ZmZXIgYXQgQXp1bGlhIG9uIEF4aXMgQmFuayBDYXJkcyFkAgYPFQEGQXp1bGlhZAIHDxYCHwQCARYCZg9kFgQCAQ8PFgIfBgUHVCBOYWdhcmRkAgUPFgIfBAIBFgJmD2QWAgIBDxAPFgIfBgUpMTIwLCBTSVIsIFRoYWdhcnVhIFJvYWQsIFQgTmFnYXIsIENoZW5uYWlkZGRkAgcPZBYCAgEPZBYIZg8VAQE2ZAIFD2QWAgIBDxYCHwQCARYCZg9kFgpmDxUND2NsYXNzPSdwYXJraW5nJxNjbGFzcz0nd2lmaSBhY3RpdmUnC2NsYXNzPSd2ZWcnDWNsYXNzPSdncmlsbCcSY2xhc3M9J2JhciBhY3RpdmUnADAvaW1hZ2VzL21hbmFnZU9mZmVycy9SZXN0YXVyYW50SW1hZ2UvQW55dGltZS5qcGcDMTUlEU9mZiBvbiBUb3RhbCBCaWxsDENvcHBlciBQb2ludBxDaGluZXNlLCBDb250aW5lbnRhbCwgSW5kaWFuKTEyMCwgU0lSLCBUaGFnYXJ1YSBSb2FkLCBUIE5hZ2FyLCBDaGVubmFpCjMxLzA1LzIwMTZkAgEPFgIfAGhkAgIPFQMMMDQ0IDI4MTUwNTAwDDA0NCAyODE1MDUwMBQxMSBBTSB0byAxMiBNaWRuaWdodGQCBA8VAQBkAgYPFQNiRW5qb3kgbWluaW11bSAxNSUgb2ZmIGF0IG92ZXIgNCwwMDAgcmVzdGF1cmFudHMgYWNyb3NzIEluZGlhIHdpdGggI0F4aXNCYW5rIENhcmRzISAjRGluaW5nRGVsaWdodHM5SSBmb3VuZCBhIGdyZWF0IG9mZmVyIGF0IENvcHBlciBQb2ludCBvbiBBeGlzIEJhbmsgQ2FyZHMhQ0kganVzdCBkaXNjb3ZlcmVkIGEgZ3JlYXQgb2ZmZXIgYXQgQ29wcGVyIFBvaW50IG9uIEF4aXMgQmFuayBDYXJkcyFkAgYPFQEMQ29wcGVyIFBvaW50ZAIHDxYCHwQCARYCZg9kFgQCAQ8PFgIfBgUHVCBOYWdhcmRkAgUPFgIfBAIBFgJmD2QWAgIBDxAPFgIfBgUpMTIwLCBTSVIsIFRoYWdhcnVhIFJvYWQsIFQgTmFnYXIsIENoZW5uYWlkZGRkAggPZBYCAgEPZBYIZg8VAQE3ZAIFD2QWAgIBDxYCHwQCARYCZg9kFgpmDxUND2NsYXNzPSdwYXJraW5nJxNjbGFzcz0nd2lmaSBhY3RpdmUnC2NsYXNzPSd2ZWcnDWNsYXNzPSdncmlsbCcSY2xhc3M9J2JhciBhY3RpdmUnADAvaW1hZ2VzL21hbmFnZU9mZmVycy9SZXN0YXVyYW50SW1hZ2UvQW55dGltZS5qcGcDMTUlEU9mZiBvbiBUb3RhbCBCaWxsFUhpZ2ggVGltZSAtIEdSVCBHcmFuZBxDaGluZXNlLCBDb250aW5lbnRhbCwgSW5kaWFuKTEyMCwgU0lSLCBUaGFnYXJ1YSBSb2FkLCBUIE5hZ2FyLCBDaGVubmFpCjMxLzA1LzIwMTZkAgEPFgIfAGhkAgIPFQMMMDQ0IDI4MTUwNTAwDDA0NCAyODE1MDUwMBQxMSBBTSB0byAxMiBNaWRuaWdodGQCBA8VAQBkAgYPFQNiRW5qb3kgbWluaW11bSAxNSUgb2ZmIGF0IG92ZXIgNCwwMDAgcmVzdGF1cmFudHMgYWNyb3NzIEluZGlhIHdpdGggI0F4aXNCYW5rIENhcmRzISAjRGluaW5nRGVsaWdodHM2SSBmb3VuZCBhIGdyZWF0IG9mZmVyIGF0IEhpZ2ggVGltZSBvbiBBeGlzIEJhbmsgQ2FyZHMhQEkganVzdCBkaXNjb3ZlcmVkIGEgZ3JlYXQgb2ZmZXIgYXQgSGlnaCBUaW1lIG9uIEF4aXMgQmFuayBDYXJkcyFkAgYPFQEVSGlnaCBUaW1lIC0gR1JUIEdyYW5kZAIHDxYCHwQCARYCZg9kFgQCAQ8PFgIfBgUHVCBOYWdhcmRkAgUPFgIfBAIBFgJmD2QWAgIBDxAPFgIfBgUpMTIwLCBTSVIsIFRoYWdhcnVhIFJvYWQsIFQgTmFnYXIsIENoZW5uYWlkZGRkAgkPZBYCAgEPZBYIZg8VAQE4ZAIFD2QWAgIBDxYCHwQCARYCZg9kFgpmDxUND2NsYXNzPSdwYXJraW5nJxNjbGFzcz0nd2lmaSBhY3RpdmUnC2NsYXNzPSd2ZWcnDWNsYXNzPSdncmlsbCcSY2xhc3M9J2JhciBhY3RpdmUnADsvaW1hZ2VzL21hbmFnZU9mZmVycy9SZXN0YXVyYW50SW1hZ2UvSG90ZWwgQmx1ZSBEaWFtb25kLnBuZwMxNSUQT2ZmIG9uIEZvb2QgQmlsbBJIb3RlbCBCbHVlIERpYW1vbmQoTm9ydGggSW5kaWFuLCBDaGluZXNlLCBTZWEgRm9vZCwgQmlyeWFuaT1Ib3RlbCBCbHVlIERpYW1vbmQsIDkzNCwgRVZSIFBlcml5YXIgU2FsYWkswqBLaWxwYXVrLCBDaGVubmFpCjMxLzA1LzIwMTZkAgEPFgIfAGhkAgIPFQMMMDQ0IDI2NDEyMjQ0DDA0NCAyNjQxMjI0NBM3OjMwIEFNIHRvIDExOjMwIFBNZAIEDxUBMU5vdCBWYWxpZCBvbiAgQWxjb2hvbGljICYgTm9uIEFsY29ob2xpYyBCZXZlcmFnZXNkAgYPFQNiRW5qb3kgbWluaW11bSAxNSUgb2ZmIGF0IG92ZXIgNCwwMDAgcmVzdGF1cmFudHMgYWNyb3NzIEluZGlhIHdpdGggI0F4aXNCYW5rIENhcmRzISAjRGluaW5nRGVsaWdodHM/SSBmb3VuZCBhIGdyZWF0IG9mZmVyIGF0IEhvdGVsIEJsdWUgRGlhbW9uZCBvbiBBeGlzIEJhbmsgQ2FyZHMhSUkganVzdCBkaXNjb3ZlcmVkIGEgZ3JlYXQgb2ZmZXIgYXQgSG90ZWwgQmx1ZSBEaWFtb25kIG9uIEF4aXMgQmFuayBDYXJkcyFkAgYPFQESSG90ZWwgQmx1ZSBEaWFtb25kZAIHDxYCHwQCARYCZg9kFgQCAQ8PFgIfBgUHS2lscGF1a2RkAgUPFgIfBAIBFgJmD2QWAgIBDxAPFgIfBgU9SG90ZWwgQmx1ZSBEaWFtb25kLCA5MzQsIEVWUiBQZXJpeWFyIFNhbGFpLMKgS2lscGF1aywgQ2hlbm5haWRkZGQCCg9kFgICAQ9kFghmDxUBATlkAgUPZBYCAgEPFgIfBAIBFgJmD2QWCmYPFQ0PY2xhc3M9J3BhcmtpbmcnDGNsYXNzPSd3aWZpJwtjbGFzcz0ndmVnJw1jbGFzcz0nZ3JpbGwnC2NsYXNzPSdiYXInAEgvaW1hZ2VzL21hbmFnZU9mZmVycy9SZXN0YXVyYW50SW1hZ2UvUmVuZGV6dm91cyAtIFF1YWxpdHkgSW5uIFNhYmFyaS5qcGcDMTUlEE9mZiBvbiBGb29kIEJpbGwfUmVuZGV6dm91cyAtIFF1YWxpdHkgSW5uIFNhYmFyaQtGaW5nZXIgRm9vZEJRdWFsaXR5IElubiBTYWJhcmksIDI5LCBUaGlydW1hbGFpIFBpbGxhaSBSb2FkLMKgVC4gTmFnYXIsIENoZW5uYWkKMzEvMDUvMjAxNmQCAQ8WAh8AaGQCAg8VAwwwNDQgNDkwNDMwMzAMMDQ0IDQ5MDQzMDMwFDExIEFNIHRvIDEyIE1pZG5pZ2h0ZAIEDxUBMU5vdCBWYWxpZCBvbiAgQWxjb2hvbGljICYgTm9uIEFsY29ob2xpYyBCZXZlcmFnZXNkAgYPFQNiRW5qb3kgbWluaW11bSAxNSUgb2ZmIGF0IG92ZXIgNCwwMDAgcmVzdGF1cmFudHMgYWNyb3NzIEluZGlhIHdpdGggI0F4aXNCYW5rIENhcmRzISAjRGluaW5nRGVsaWdodHM3SSBmb3VuZCBhIGdyZWF0IG9mZmVyIGF0IFJlbmRlenZvdXMgb24gQXhpcyBCYW5rIENhcmRzIUFJIGp1c3QgZGlzY292ZXJlZCBhIGdyZWF0IG9mZmVyIGF0IFJlbmRlenZvdXMgb24gQXhpcyBCYW5rIENhcmRzIWQCBg8VAR9SZW5kZXp2b3VzIC0gUXVhbGl0eSBJbm4gU2FiYXJpZAIHDxYCHwQCARYCZg9kFgQCAQ8PFgIfBgUHVCBOYWdhcmRkAgUPFgIfBAIBFgJmD2QWAgIBDxAPFgIfBgVCUXVhbGl0eSBJbm4gU2FiYXJpLCAyOSwgVGhpcnVtYWxhaSBQaWxsYWkgUm9hZCzCoFQuIE5hZ2FyLCBDaGVubmFpZGRkZAILD2QWAgIBD2QWCGYPFQECMTBkAgUPZBYCAgEPFgIfBAIBFgJmD2QWCmYPFQ0PY2xhc3M9J3BhcmtpbmcnDGNsYXNzPSd3aWZpJwtjbGFzcz0ndmVnJw1jbGFzcz0nZ3JpbGwnEmNsYXNzPSdiYXIgYWN0aXZlJwA3L2ltYWdlcy9tYW5hZ2VPZmZlcnMvUmVzdGF1cmFudEltYWdlL0hvdGVsIFZpY3RvcmlhLnBuZwMxNSUQT2ZmIG9uIEZvb2QgQmlsbBlTZWFzb25zICAtIEhvdGVsIFZpY3RvcmlhC0ZpbmdlciBGb29kLkhvdGVsIFZpY3RvcmlhLCAzLCBLZW5uZXQgTGFuZSxFZ21vcmUsIENoZW5uYWkKMzEvMDUvMjAxNmQCAQ8WAh8AaGQCAg8VAwwwNDQgMjgxOTM2MzgMMDQ0IDI4MTkzNjM4DjExIEFNIHRvIDExIFBNZAIEDxUBEE9mZiBvbiBGb29kIEJpbGxkAgYPFQNiRW5qb3kgbWluaW11bSAxNSUgb2ZmIGF0IG92ZXIgNCwwMDAgcmVzdGF1cmFudHMgYWNyb3NzIEluZGlhIHdpdGggI0F4aXNCYW5rIENhcmRzISAjRGluaW5nRGVsaWdodHM0SSBmb3VuZCBhIGdyZWF0IG9mZmVyIGF0IFNlYXNvbnMgb24gQXhpcyBCYW5rIENhcmRzIT5JIGp1c3QgZGlzY292ZXJlZCBhIGdyZWF0IG9mZmVyIGF0IFNlYXNvbnMgb24gQXhpcyBCYW5rIENhcmRzIWQCBg8VARlTZWFzb25zICAtIEhvdGVsIFZpY3RvcmlhZAIHDxYCHwQCARYCZg9kFgQCAQ8PFgIfBgUGRWdtb3JlZGQCBQ8WAh8EAgEWAmYPZBYCAgEPEA8WAh8GBS5Ib3RlbCBWaWN0b3JpYSwgMywgS2VubmV0IExhbmUsRWdtb3JlLCBDaGVubmFpZGRkZAIMD2QWAgIBD2QWCGYPFQECMTFkAgUPZBYCAgEPFgIfBAIBFgJmD2QWCmYPFQ0PY2xhc3M9J3BhcmtpbmcnDGNsYXNzPSd3aWZpJwtjbGFzcz0ndmVnJw1jbGFzcz0nZ3JpbGwnEmNsYXNzPSdiYXIgYWN0aXZlJwA3L2ltYWdlcy9tYW5hZ2VPZmZlcnMvUmVzdGF1cmFudEltYWdlL0hvdGVsIFZpY3RvcmlhLnBuZwMxNSUQT2ZmIG9uIEZvb2QgQmlsbB5Ucm9waWNhbmEgQmFyIC0gSG90ZWwgVmljdG9yaWELRmluZ2VyIEZvb2QuSG90ZWwgVmljdG9yaWEsIDMsIEtlbm5ldCBMYW5lLEVnbW9yZSwgQ2hlbm5haQozMS8wNS8yMDE2ZAIBDxYCHwBoZAICDxUDDDA0NCAyODE5MzYzOAwwNDQgMjgxOTM2MzgOMTEgQU0gdG8gMTEgUE1kAgQPFQExTm90IFZhbGlkIG9uICBBbGNvaG9saWMgJiBOb24gQWxjb2hvbGljIEJldmVyYWdlc2QCBg8VA2JFbmpveSBtaW5pbXVtIDE1JSBvZmYgYXQgb3ZlciA0LDAwMCByZXN0YXVyYW50cyBhY3Jvc3MgSW5kaWEgd2l0aCAjQXhpc0JhbmsgQ2FyZHMhICNEaW5pbmdEZWxpZ2h0czpJIGZvdW5kIGEgZ3JlYXQgb2ZmZXIgYXQgVHJvcGljYW5hIEJhciBvbiBBeGlzIEJhbmsgQ2FyZHMhREkganVzdCBkaXNjb3ZlcmVkIGEgZ3JlYXQgb2ZmZXIgYXQgVHJvcGljYW5hIEJhciBvbiBBeGlzIEJhbmsgQ2FyZHMhZAIGDxUBHlRyb3BpY2FuYSBCYXIgLSBIb3RlbCBWaWN0b3JpYWQCBw8WAh8EAgEWAmYPZBYEAgEPDxYCHwYFBkVnbW9yZWRkAgUPFgIfBAIBFgJmD2QWAgIBDxAPFgIfBgUuSG90ZWwgVmljdG9yaWEsIDMsIEtlbm5ldCBMYW5lLEVnbW9yZSwgQ2hlbm5haWRkZGQCDQ9kFgICAQ9kFghmDxUBAjEyZAIFD2QWAgIBDxYCHwQCARYCZg9kFgpmDxUND2NsYXNzPSdwYXJraW5nJxNjbGFzcz0nd2lmaSBhY3RpdmUnC2NsYXNzPSd2ZWcnDWNsYXNzPSdncmlsbCcSY2xhc3M9J2JhciBhY3RpdmUnAEgvaW1hZ2VzL21hbmFnZU9mZmVycy9SZXN0YXVyYW50SW1hZ2UvUmVuZGV6dm91cyAtIFF1YWxpdHkgSW5uIFNhYmFyaS5qcGcDMTUlEE9mZiBvbiBGb29kIEJpbGwgWmVybyBEZWdyZWUgLSBRdWFsaXR5IElubiBTYWJhcmkLRmluZ2VyIEZvb2RCUXVhbGl0eSBJbm4gU2FiYXJpLCAyOSwgVGhpcnVtYWxhaSBQaWxsYWkgUm9hZCzCoFQuIE5hZ2FyLCBDaGVubmFpCjMxLzA1LzIwMTZkAgEPFgIfAGhkAgIPFQMMMDQ0IDQ5MDQzMDMwDDA0NCA0OTA0MzAzMBQxMSBBTSB0byAxMiBNaWRuaWdodGQCBA8VATFOb3QgVmFsaWQgb24gIEFsY29ob2xpYyAmIE5vbiBBbGNvaG9saWMgQmV2ZXJhZ2VzZAIGDxUDYkVuam95IG1pbmltdW0gMTUlIG9mZiBhdCBvdmVyIDQsMDAwIHJlc3RhdXJhbnRzIGFjcm9zcyBJbmRpYSB3aXRoICNBeGlzQmFuayBDYXJkcyEgI0RpbmluZ0RlbGlnaHRzOEkgZm91bmQgYSBncmVhdCBvZmZlciBhdCBaZXJvIERlZ3JlZSBvbiBBeGlzIEJhbmsgQ2FyZHMhQkkganVzdCBkaXNjb3ZlcmVkIGEgZ3JlYXQgb2ZmZXIgYXQgWmVybyBEZWdyZWUgb24gQXhpcyBCYW5rIENhcmRzIWQCBg8VASBaZXJvIERlZ3JlZSAtIFF1YWxpdHkgSW5uIFNhYmFyaWQCBw8WAh8EAgEWAmYPZBYEAgEPDxYCHwYFB1QgTmFnYXJkZAIFDxYCHwQCARYCZg9kFgICAQ8QDxYCHwYFQlF1YWxpdHkgSW5uIFNhYmFyaSwgMjksIFRoaXJ1bWFsYWkgUGlsbGFpIFJvYWQswqBULiBOYWdhciwgQ2hlbm5haWRkZGQCDg9kFgICAQ9kFghmDxUBAjEzZAIFD2QWAgIBDxYCHwQCARYCZg9kFgpmDxUND2NsYXNzPSdwYXJraW5nJxNjbGFzcz0nd2lmaSBhY3RpdmUnC2NsYXNzPSd2ZWcnFGNsYXNzPSdncmlsbCBhY3RpdmUnEmNsYXNzPSdiYXIgYWN0aXZlJwA0L2ltYWdlcy9tYW5hZ2VPZmZlcnMvUmVzdGF1cmFudEltYWdlL1RoZSBLaXRjaGVuLmdpZgMxNSUcT2ZmIG9uIEZvb2QgJiBTb2Z0IEJldmVyYWdlcx1UaGUgS2l0Y2hlbiAtIFJhaW50cmVlIEhvdGVscxxDaGluZXNlLCBDb250aW5lbnRhbCwgSW5kaWFuFzYzNiwgVGV5bmFtcGV0LCBDaGVubmFpCjMwLzA2LzIwMTZkAgEPFgIfAGhkAgIPFQMLIDkxNzY2NzAxMTELIDkxNzY2NzAxMTEMNyBBTSB0byAxIEFNZAIEDxUBKU5vdCBWYWxpZCBvbiBCdWZmZXQgJiBBbGNvaG9saWMgQmV2ZXJhZ2VzZAIGDxUDYkVuam95IG1pbmltdW0gMTUlIG9mZiBhdCBvdmVyIDQsMDAwIHJlc3RhdXJhbnRzIGFjcm9zcyBJbmRpYSB3aXRoICNBeGlzQmFuayBDYXJkcyEgI0RpbmluZ0RlbGlnaHRzOEkgZm91bmQgYSBncmVhdCBvZmZlciBhdCBUaGUgS2l0Y2hlbiBvbiBBeGlzIEJhbmsgQ2FyZHMhQkkganVzdCBkaXNjb3ZlcmVkIGEgZ3JlYXQgb2ZmZXIgYXQgVGhlIEtpdGNoZW4gb24gQXhpcyBCYW5rIENhcmRzIWQCBg8VAR1UaGUgS2l0Y2hlbiAtIFJhaW50cmVlIEhvdGVsc2QCBw8WAh8EAgEWAmYPZBYEAgEPDxYCHwYFCVRleW5hbXBldGRkAgUPFgIfBAIBFgJmD2QWAgIBDxAPFgIfBgUXNjM2LCBUZXluYW1wZXQsIENoZW5uYWlkZGRkAg8PZBYCAgEPZBYIZg8VAQIxNGQCBQ9kFgICAQ8WAh8EAgEWAmYPZBYKZg8VDQ9jbGFzcz0ncGFya2luZycTY2xhc3M9J3dpZmkgYWN0aXZlJwtjbGFzcz0ndmVnJw1jbGFzcz0nZ3JpbGwnEmNsYXNzPSdiYXIgYWN0aXZlJwAyL2ltYWdlcy9tYW5hZ2VPZmZlcnMvUmVzdGF1cmFudEltYWdlL0FhdGhhZ3VkaS5wbmcDMTUlEE9mZiBvbiBGb29kIEJpbGwfQWF0aGFndWRpIC0gSGFyaWhhcmFuIFJlc2lkZW5jeQZJbmRpYW4vNzYzLCBCYW5nYWxvcmUgVHJ1bmsgUm9hZCwgUG9vbmFtYWxsZWUsIENoZW5uYWkKMzAvMDYvMjAxNmQCAQ8WAh8AaGQCAg8VAwwwNDQgNjUxMjU1NTEMMDQ0IDY1MTI1NTUxDDcgQU0gdG8gMSBBTWQCBA8VATFOb3QgVmFsaWQgb24gIEFsY29ob2xpYyAmIE5vbiBBbGNvaG9saWMgQmV2ZXJhZ2VzZAIGDxUDYkVuam95IG1pbmltdW0gMTUlIG9mZiBhdCBvdmVyIDQsMDAwIHJlc3RhdXJhbnRzIGFjcm9zcyBJbmRpYSB3aXRoICNBeGlzQmFuayBDYXJkcyEgI0RpbmluZ0RlbGlnaHRzNkkgZm91bmQgYSBncmVhdCBvZmZlciBhdCBBYXRoYWd1ZGkgb24gQXhpcyBCYW5rIENhcmRzIUBJIGp1c3QgZGlzY292ZXJlZCBhIGdyZWF0IG9mZmVyIGF0IEFhdGhhZ3VkaSBvbiBBeGlzIEJhbmsgQ2FyZHMhZAIGDxUBH0FhdGhhZ3VkaSAtIEhhcmloYXJhbiBSZXNpZGVuY3lkAgcPFgIfBAIBFgJmD2QWBAIBDw8WAh8GBQtQb29uYW1hbGxlZWRkAgUPFgIfBAIBFgJmD2QWAgIBDxAPFgIfBgUvNzYzLCBCYW5nYWxvcmUgVHJ1bmsgUm9hZCwgUG9vbmFtYWxsZWUsIENoZW5uYWlkZGRkAgMPZBYGAgUPDxYCHwBnZGQCBw8WAh8AZ2QCCQ8PFgIfAGdkZBgBBR5fX0NvbnRyb2xzUmVxdWlyZVBvc3RCYWNrS2V5X18WdgURY2JsTWFudWZhY3R1cmVyJDAFEWNibE1hbnVmYWN0dXJlciQxBRFjYmxNYW51ZmFjdHVyZXIkMgURY2JsTWFudWZhY3R1cmVyJDMFEWNibE1hbnVmYWN0dXJlciQ0BRFjYmxNYW51ZmFjdHVyZXIkNQURY2JsTWFudWZhY3R1cmVyJDYFEWNibE1hbnVmYWN0dXJlciQ3BRFjYmxNYW51ZmFjdHVyZXIkOAURY2JsTWFudWZhY3R1cmVyJDkFEmNibE1hbnVmYWN0dXJlciQxMAUSY2JsTWFudWZhY3R1cmVyJDExBRJjYmxNYW51ZmFjdHVyZXIkMTIFEmNibE1hbnVmYWN0dXJlciQxMwUSY2JsTWFudWZhY3R1cmVyJDE0BRJjYmxNYW51ZmFjdHVyZXIkMTUFEmNibE1hbnVmYWN0dXJlciQxNgUSY2JsTWFudWZhY3R1cmVyJDE3BRJjYmxNYW51ZmFjdHVyZXIkMTgFEmNibE1hbnVmYWN0dXJlciQxOQUSY2JsTWFudWZhY3R1cmVyJDIwBRJjYmxNYW51ZmFjdHVyZXIkMjEFEmNibE1hbnVmYWN0dXJlciQyMgUSY2JsTWFudWZhY3R1cmVyJDIzBRJjYmxNYW51ZmFjdHVyZXIkMjQFEmNibE1hbnVmYWN0dXJlciQyNQUSY2JsTWFudWZhY3R1cmVyJDI2BRJjYmxNYW51ZmFjdHVyZXIkMjcFEmNibE1hbnVmYWN0dXJlciQyOAUSY2JsTWFudWZhY3R1cmVyJDI5BRJjYmxNYW51ZmFjdHVyZXIkMzAFEmNibE1hbnVmYWN0dXJlciQzMQUSY2JsTWFudWZhY3R1cmVyJDMyBRJjYmxNYW51ZmFjdHVyZXIkMzMFEmNibE1hbnVmYWN0dXJlciQzNAUSY2JsTWFudWZhY3R1cmVyJDM1BRJjYmxNYW51ZmFjdHVyZXIkMzYFEmNibE1hbnVmYWN0dXJlciQzNwUSY2JsTWFudWZhY3R1cmVyJDM4BRJjYmxNYW51ZmFjdHVyZXIkMzkFEmNibE1hbnVmYWN0dXJlciQ0MAUSY2JsTWFudWZhY3R1cmVyJDQxBRJjYmxNYW51ZmFjdHVyZXIkNDIFEmNibE1hbnVmYWN0dXJlciQ0MwUSY2JsTWFudWZhY3R1cmVyJDQ0BRJjYmxNYW51ZmFjdHVyZXIkNDUFEmNibE1hbnVmYWN0dXJlciQ0NgUSY2JsTWFudWZhY3R1cmVyJDQ3BRJjYmxNYW51ZmFjdHVyZXIkNDgFEmNibE1hbnVmYWN0dXJlciQ0OQUSY2JsTWFudWZhY3R1cmVyJDUwBRJjYmxNYW51ZmFjdHVyZXIkNTEFEmNibE1hbnVmYWN0dXJlciQ1MgUSY2JsTWFudWZhY3R1cmVyJDUzBRJjYmxNYW51ZmFjdHVyZXIkNTQFEmNibE1hbnVmYWN0dXJlciQ1NQUSY2JsTWFudWZhY3R1cmVyJDU2BRJjYmxNYW51ZmFjdHVyZXIkNTcFEmNibE1hbnVmYWN0dXJlciQ1OAUSY2JsTWFudWZhY3R1cmVyJDU5BRJjYmxNYW51ZmFjdHVyZXIkNjAFEmNibE1hbnVmYWN0dXJlciQ2MQUSY2JsTWFudWZhY3R1cmVyJDYyBRJjYmxNYW51ZmFjdHVyZXIkNjMFEmNibE1hbnVmYWN0dXJlciQ2NAUSY2JsTWFudWZhY3R1cmVyJDY1BRJjYmxNYW51ZmFjdHVyZXIkNjYFEmNibE1hbnVmYWN0dXJlciQ2NwUSY2JsTWFudWZhY3R1cmVyJDY4BRJjYmxNYW51ZmFjdHVyZXIkNjkFEmNibE1hbnVmYWN0dXJlciQ3MAUSY2JsTWFudWZhY3R1cmVyJDcxBRJjYmxNYW51ZmFjdHVyZXIkNzIFEmNibE1hbnVmYWN0dXJlciQ3MwUSY2JsTWFudWZhY3R1cmVyJDc0BRJjYmxNYW51ZmFjdHVyZXIkNzUFEmNibE1hbnVmYWN0dXJlciQ3NgUSY2JsTWFudWZhY3R1cmVyJDc3BRJjYmxNYW51ZmFjdHVyZXIkNzgFEmNibE1hbnVmYWN0dXJlciQ3OQUSY2JsTWFudWZhY3R1cmVyJDgwBRJjYmxNYW51ZmFjdHVyZXIkODEFEmNibE1hbnVmYWN0dXJlciQ4MQUKY2hrdmVnT25seQUKY2hrQnVmZmV0cwUHY2hrV2lmaQUGY2hrQmFyBQ9jaGtWYWxldFBhcmtpbmcFXlJwdE9mZmVyRGV0YWlscyRjdGwwMSRQYXJlbnRfUnB0TG9jYWxpdHlEZXRhaWxzJGN0bDAwJENoaWxkX1JwdExvY2FsaXR5RGV0YWlscyRjdGwwMCRyYkFkZHJlc3MFXlJwdE9mZmVyRGV0YWlscyRjdGwwMSRQYXJlbnRfUnB0TG9jYWxpdHlEZXRhaWxzJGN0bDAwJENoaWxkX1JwdExvY2FsaXR5RGV0YWlscyRjdGwwMCRyYkFkZHJlc3MFXlJwdE9mZmVyRGV0YWlscyRjdGwwMiRQYXJlbnRfUnB0TG9jYWxpdHlEZXRhaWxzJGN0bDAwJENoaWxkX1JwdExvY2FsaXR5RGV0YWlscyRjdGwwMCRyYkFkZHJlc3MFXlJwdE9mZmVyRGV0YWlscyRjdGwwMiRQYXJlbnRfUnB0TG9jYWxpdHlEZXRhaWxzJGN0bDAwJENoaWxkX1JwdExvY2FsaXR5RGV0YWlscyRjdGwwMCRyYkFkZHJlc3MFXlJwdE9mZmVyRGV0YWlscyRjdGwwMyRQYXJlbnRfUnB0TG9jYWxpdHlEZXRhaWxzJGN0bDAyJENoaWxkX1JwdExvY2FsaXR5RGV0YWlscyRjdGwwMCRyYkFkZHJlc3MFXlJwdE9mZmVyRGV0YWlscyRjdGwwMyRQYXJlbnRfUnB0TG9jYWxpdHlEZXRhaWxzJGN0bDAyJENoaWxkX1JwdExvY2FsaXR5RGV0YWlscyRjdGwwMCRyYkFkZHJlc3MFXlJwdE9mZmVyRGV0YWlscyRjdGwwNCRQYXJlbnRfUnB0TG9jYWxpdHlEZXRhaWxzJGN0bDAwJENoaWxkX1JwdExvY2FsaXR5RGV0YWlscyRjdGwwMCRyYkFkZHJlc3MFXlJwdE9mZmVyRGV0YWlscyRjdGwwNCRQYXJlbnRfUnB0TG9jYWxpdHlEZXRhaWxzJGN0bDAwJENoaWxkX1JwdExvY2FsaXR5RGV0YWlscyRjdGwwMCRyYkFkZHJlc3MFXlJwdE9mZmVyRGV0YWlscyRjdGwwNSRQYXJlbnRfUnB0TG9jYWxpdHlEZXRhaWxzJGN0bDAwJENoaWxkX1JwdExvY2FsaXR5RGV0YWlscyRjdGwwMCRyYkFkZHJlc3MFXlJwdE9mZmVyRGV0YWlscyRjdGwwNSRQYXJlbnRfUnB0TG9jYWxpdHlEZXRhaWxzJGN0bDAwJENoaWxkX1JwdExvY2FsaXR5RGV0YWlscyRjdGwwMCRyYkFkZHJlc3MFXlJwdE9mZmVyRGV0YWlscyRjdGwwNiRQYXJlbnRfUnB0TG9jYWxpdHlEZXRhaWxzJGN0bDAwJENoaWxkX1JwdExvY2FsaXR5RGV0YWlscyRjdGwwMCRyYkFkZHJlc3MFXlJwdE9mZmVyRGV0YWlscyRjdGwwNiRQYXJlbnRfUnB0TG9jYWxpdHlEZXRhaWxzJGN0bDAwJENoaWxkX1JwdExvY2FsaXR5RGV0YWlscyRjdGwwMCRyYkFkZHJlc3MFXlJwdE9mZmVyRGV0YWlscyRjdGwwNyRQYXJlbnRfUnB0TG9jYWxpdHlEZXRhaWxzJGN0bDAwJENoaWxkX1JwdExvY2FsaXR5RGV0YWlscyRjdGwwMCRyYkFkZHJlc3MFXlJwdE9mZmVyRGV0YWlscyRjdGwwNyRQYXJlbnRfUnB0TG9jYWxpdHlEZXRhaWxzJGN0bDAwJENoaWxkX1JwdExvY2FsaXR5RGV0YWlscyRjdGwwMCRyYkFkZHJlc3MFXlJwdE9mZmVyRGV0YWlscyRjdGwwOCRQYXJlbnRfUnB0TG9jYWxpdHlEZXRhaWxzJGN0bDAwJENoaWxkX1JwdExvY2FsaXR5RGV0YWlscyRjdGwwMCRyYkFkZHJlc3MFXlJwdE9mZmVyRGV0YWlscyRjdGwwOCRQYXJlbnRfUnB0TG9jYWxpdHlEZXRhaWxzJGN0bDAwJENoaWxkX1JwdExvY2FsaXR5RGV0YWlscyRjdGwwMCRyYkFkZHJlc3MFXlJwdE9mZmVyRGV0YWlscyRjdGwwOSRQYXJlbnRfUnB0TG9jYWxpdHlEZXRhaWxzJGN0bDAwJENoaWxkX1JwdExvY2FsaXR5RGV0YWlscyRjdGwwMCRyYkFkZHJlc3MFXlJwdE9mZmVyRGV0YWlscyRjdGwwOSRQYXJlbnRfUnB0TG9jYWxpdHlEZXRhaWxzJGN0bDAwJENoaWxkX1JwdExvY2FsaXR5RGV0YWlscyRjdGwwMCRyYkFkZHJlc3MFXlJwdE9mZmVyRGV0YWlscyRjdGwxMCRQYXJlbnRfUnB0TG9jYWxpdHlEZXRhaWxzJGN0bDAwJENoaWxkX1JwdExvY2FsaXR5RGV0YWlscyRjdGwwMCRyYkFkZHJlc3MFXlJwdE9mZmVyRGV0YWlscyRjdGwxMCRQYXJlbnRfUnB0TG9jYWxpdHlEZXRhaWxzJGN0bDAwJENoaWxkX1JwdExvY2FsaXR5RGV0YWlscyRjdGwwMCRyYkFkZHJlc3MFXlJwdE9mZmVyRGV0YWlscyRjdGwxMSRQYXJlbnRfUnB0TG9jYWxpdHlEZXRhaWxzJGN0bDAwJENoaWxkX1JwdExvY2FsaXR5RGV0YWlscyRjdGwwMCRyYkFkZHJlc3MFXlJwdE9mZmVyRGV0YWlscyRjdGwxMSRQYXJlbnRfUnB0TG9jYWxpdHlEZXRhaWxzJGN0bDAwJENoaWxkX1JwdExvY2FsaXR5RGV0YWlscyRjdGwwMCRyYkFkZHJlc3MFXlJwdE9mZmVyRGV0YWlscyRjdGwxMiRQYXJlbnRfUnB0TG9jYWxpdHlEZXRhaWxzJGN0bDAwJENoaWxkX1JwdExvY2FsaXR5RGV0YWlscyRjdGwwMCRyYkFkZHJlc3MFXlJwdE9mZmVyRGV0YWlscyRjdGwxMiRQYXJlbnRfUnB0TG9jYWxpdHlEZXRhaWxzJGN0bDAwJENoaWxkX1JwdExvY2FsaXR5RGV0YWlscyRjdGwwMCRyYkFkZHJlc3MFXlJwdE9mZmVyRGV0YWlscyRjdGwxMyRQYXJlbnRfUnB0TG9jYWxpdHlEZXRhaWxzJGN0bDAwJENoaWxkX1JwdExvY2FsaXR5RGV0YWlscyRjdGwwMCRyYkFkZHJlc3MFXlJwdE9mZmVyRGV0YWlscyRjdGwxMyRQYXJlbnRfUnB0TG9jYWxpdHlEZXRhaWxzJGN0bDAwJENoaWxkX1JwdExvY2FsaXR5RGV0YWlscyRjdGwwMCRyYkFkZHJlc3MFXlJwdE9mZmVyRGV0YWlscyRjdGwxNCRQYXJlbnRfUnB0TG9jYWxpdHlEZXRhaWxzJGN0bDAwJENoaWxkX1JwdExvY2FsaXR5RGV0YWlscyRjdGwwMCRyYkFkZHJlc3MFXlJwdE9mZmVyRGV0YWlscyRjdGwxNCRQYXJlbnRfUnB0TG9jYWxpdHlEZXRhaWxzJGN0bDAwJENoaWxkX1JwdExvY2FsaXR5RGV0YWlscyRjdGwwMCRyYkFkZHJlc3MFXlJwdE9mZmVyRGV0YWlscyRjdGwxNSRQYXJlbnRfUnB0TG9jYWxpdHlEZXRhaWxzJGN0bDAwJENoaWxkX1JwdExvY2FsaXR5RGV0YWlscyRjdGwwMCRyYkFkZHJlc3MFXlJwdE9mZmVyRGV0YWlscyRjdGwxNSRQYXJlbnRfUnB0TG9jYWxpdHlEZXRhaWxzJGN0bDAwJENoaWxkX1JwdExvY2FsaXR5RGV0YWlscyRjdGwwMCRyYkFkZHJlc3M1hy3T0OMCthesljgHnlWlAcy5QLUpNREw3ezrqgu62g==',
			'__VIEWSTATEGENERATOR' => '8C61B58F',
			'__ASYNCPOST' => 'true'
			);

		//url-ify the data for the POST
		$fields_string='';
		foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		rtrim($fields_string, '&');
		/*curl_setopt($ch,CURLOPT_POST, count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);*/
		$html = curl_exec($ch);
		if (!$html) {
			echo "
			cURL error number: " .curl_errno($ch) . " on URL: " . $url ."
			" .
				 "
			cURL error: " . curl_error($ch) . "
			";
		}
		curl_close($ch);
		print_r($html);
	}

	public function callback_banknos(){
		$bankname = $this->input->post('bank');
		$affilation = $this->input->post('affilation');
		$affilationcat = $this->input->post('affilationcat');

		$cardno = "";
		$query = "SELECT GROUP_CONCAT(identity_no) as id_no FROM card where id!=''";
		if($bankname=="" && $affilation=="" && $affilationcat=="")
		{
			echo "";
			exit;
		}	
		if($bankname!=""){
			$query .=" AND issuing_organization='".$bankname."'";
		}
		if(is_array($affilation)){
			if($affilation[0]!=""){
				$count=1;
				foreach ($affilation as $value) {
					if($count==1){
						if(count($affilation)==1){
							$query .=" AND affiliation='".$value."'";
						}
						else{
		 					$query .=" AND (affiliation='".$value."'";
						}
					}
					else if(count($affilation)==$count){
						$query .=" OR affiliation='".$value."')";
					}
					else{
						$query .=" OR affiliation='".$value."'";
					}
					$count++;
				}
			}
		}
		if(is_array($affilationcat)){
			if($affilationcat[0]!=""){
				$count=1;
				foreach ($affilationcat as $value) {
					if($count==1){
						if(count($affilationcat)==1){
							$query .=" AND affiliation_category='".$value."'";
						}
						else{
		 					$query .=" AND (affiliation_category='".$value."'";
						}
					}
					else if(count($affilationcat)==$count){
						$query .=" OR affiliation_category='".$value."')";
					}
					else{
						$query .=" OR affiliation_category='".$value."'";
					}
					$count++;
				}
			}
		}
		$result = $this->db->query($query)->result();
		$cardno = $result[0]->id_no;
		echo $cardno;
	}

	public function callback_affilation_cards(){
		$bankname = $_POST['bank'];
		$affilation = $_POST['affilation'];
		$affilationcat = $_POST['affilationcat'];
		$cardno = $_POST['cardn'];
		if($affilationcat[0]!=""){
			$count=1;
			$query = "SELECT identity_no,card_name FROM card where identity_no IN (".$cardno.")";
			foreach ($affilationcat as $value) {
				if($count==1){
					if(count($affilationcat)==1){
						$query .=" AND affiliation_category='".$value."'";
					}
					else{
	 					$query .=" AND (affiliation_category='".$value."'";
					}
				}
				else if(count($affilationcat)==$count){
					$query .=" OR affiliation_category='".$value."')";
				}
				else{
					$query .=" OR affiliation_category='".$value."'";
				}
				$count++;
			}
			$cardnames = $this->db->query($query)->result();
			echo "<option value=''>Select</option>";
			foreach ($cardnames as $cardname) {
	            echo "<option value='{$cardname->identity_no}' >{$cardname->card_name}</option>";
			}
		}
	}

	public function callback_affilation_cat(){
		$bankname = $_POST['bank'];
		$affilation = $_POST['affilation'];
		// $affilationcats = $this->db->query("SELECT DISTINCT(affiliation_category) FROM card where issuing_organization='".$bankname."' And affiliation='".$affilation."'")->result();
		//$affilationcats = $this->db->query("SELECT DISTINCT(affiliation_category) FROM card where affiliation='".$affilation."'")->result();
		//echo "<option value=''>Select</option>";
		if($affilation[0]!=""){
				$count=1;
				if($bankname!=''){
					$query = "SELECT DISTINCT(affiliation_category) FROM card where issuing_organization='".$bankname."'";
				}
				else{
					$query = "SELECT DISTINCT(affiliation_category) FROM card where id!=''";
				}
				foreach ($affilation as $value) {
					if($count==1){
						if(count($affilation)==1){
							$query .=" AND affiliation='".$value."'";
						}
						else{
		 					$query .=" AND (affiliation='".$value."'";
						}
					}
					else if(count($affilation)==$count){
						$query .=" OR affiliation='".$value."')";
					}
					else{
						$query .=" OR affiliation='".$value."'";
					}
					$count++;
				}
		$affilationcats = $this->db->query($query)->result();
		foreach ($affilationcats as $affilationcat) {
            echo "<option value='{$affilationcat->affiliation_category}' >{$affilationcat->affiliation_category}</option>";
		}
	}
}

	public function callback_affilation(){
		$bankname = $_POST['bank'];

		if($bankname==''){
			$affilations = $this->db->query("SELECT DISTINCT(affiliation) FROM card")->result();
		}
		else{
			$affilations = $this->db->query("SELECT DISTINCT(affiliation) FROM card where issuing_organization='".$bankname."'")->result();
		}
		//echo "<option value=''>Select</option>";
		foreach ($affilations as $affilation) {
            echo "<option value='{$affilation->affiliation}' >{$affilation->affiliation}</option>";
		}

	}

	public function get_sub_categories($cat_id){

		$this->db->where('category_id', $cat_id);
		$sub_cat = $this->db->get('subcategories_master')->result();

		foreach ($sub_cat as $c) {;
            echo "<option value='{$c->id}' >{$c->category}</option>";
		}
	}

	public function get_sub_category(){
		$this->db->where("category_id", $this->input->post("txt_category"));
		$sub_categories = $this->db->get("subcategories_master")->result_array();
		$this->output->set_content_type('application/json')->set_output(json_encode($sub_categories));
	}


	function callback_lat_long(){
		$citys = $_POST['city'];
		$location = $_POST['location'];
		//$placeid = substr($citys, strpos($citys, ":") + 1);

		$offer_specified_cities = $citys;
		//exit;
		$offers_arr = explode("|", $offer_specified_cities);
		/*foreach ($offers_arr as $value) {
			$tempcity = substr($value,strpos($value,":")+1);
		}*/
		//$location1 = $_POST['location'];
		// $location2 = str_replace(' ', "%20", $location1);
		// $location = str_replace('&', "%26", $location2);
		$lat ='';
		$lng ='';
		//$city = implode(",", $citys);
		foreach ($offers_arr as $city) {
			//$address1 = $location.'+'.$city;
			//$address = urlencode($city);
			//$geocode_stats = file_get_contents("http://maps.googleapis.com/maps/api/geocode/json?address=".$address."&sensor=false");
			$placeid = substr($city,strpos($city,":")+1);
			$geocode_stats = file_get_contents("https://maps.googleapis.com/maps/api/place/details/json?placeid=".$placeid."&key=AIzaSyBpNCkDY74Etfx9yN8rljtz1Q7S2LMzcPc");
			$output_deals = json_decode($geocode_stats);
			if ($output_deals->status!="OK") {
				continue;
			}
			$latLng = $output_deals->result->geometry->location;
			if($lat==''){
				$lat = $latLng->lat;
			}
			else{
				$lat .= ','.$latLng->lat;
			}
			if($lng==''){
				$lng = $latLng->lng;
			}else{
				$lng .= ','.$latLng->lng;
			}
		}
		$arr = array('lat' => $lat,'lng' => $lng);
		echo json_encode($arr);
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
		$offer_citys = "";
		
		//print_r($offers_arr);
		//echo $offer_specified_cities;
		/*if($offer_specified_cities_arr!=''){
			$offer_specified_cities = implode(",",$offer_specified_cities_arr[0]);
		}
		else{
			$offer_specified_cities = '';		
		}*/
		//$offer_specified_cities = substr($offer_specified_cities_arr, strpos($offer_specified_cities_arr, ",") + 1);
		$specific_location_exists = $this->input->post('txt_specific_location_exists');
		if($specific_location_exists=="1"){
			$location_exist="Yes";
			$offer_specified_cities_arr = $this->input->post('txt_location');
			$offer_specified_cities = $offer_specified_cities_arr[0];
			$offers_arr = explode("|", $offer_specified_cities);
			foreach ($offers_arr as $value) {
				$tempcity = substr($value,strpos($value,",")+1);
				$city = substr($tempcity, 0,strpos($tempcity,":"));
				if($offer_citys==""){
					$offer_citys = $city;
				}
				else{
					$offer_citys.= ";".$city;
				}
			}
			$lat = $this->input->post('txt_latitude');
			$long = $this->input->post('txt_longtitude');
		}
		else{
			$location_exist="No";
			$lat = "";
			$long = "";
			$offer_citys = "";
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
		  "city" => $offer_citys
		 );
		if($this->db->insert('offers', $offers_arr))
		{
			$this->session->set_flashdata('msg', 'success');
		}
		else
		{
			$this->session->set_flashdata('msg', 'error');
		}
		redirect("new_offers");
	}
}

/* End of file new_offers */
/* Location: ./application/controllers/new_offers */