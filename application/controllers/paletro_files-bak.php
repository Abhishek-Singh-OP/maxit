<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paletro_files extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
                date_default_timezone_set("Asia/Calcutta");
                $this->load->model('user_model');
				$this->load->library('ftp');
	}
	
	/*public function user()
	{
		 $post = $this->input->post();
		 akhilesh($post);
		 exit();
		$userData = array(
                                    'user_fullname' => $post['fname'],
                                    'user_email' => $post['email'],
                                    'user_name' => $post['username'],
                                );
                        $return = $this->user_model->addData('user',$userData);
						echo $return;	
	}*/
	
	function cards(){
        //place where the excel file is created
        $myFile = "./upload/testexcel.txt";
        $this->load->library('parser');
        //load required data from database
        $userDetails = $this->user_model->cards();
        $data['user_details'] = $userDetails;
		//echo "<pre>";
		//print_r($data['user_details']);
		//exit;
		foreach($userDetails as $abc){
			$array = get_object_vars($abc);
			//echo $comma_separated = implode("+",$array);	
		}
		//print_r($comma_separated);
        //pass retrieved data into template and return as a string
        $stringData = $this->parser->parse('user_details_csv', $data, true);
        //open excel and write string into excel
        $fh = fopen($myFile, 'w') or die("can't open file");
        fwrite($fh,$stringData);
        fclose($fh);
        //download excel file
       //$this->downloadExcel();
  //       192.168.6.126
  //       tranfer_nb
  //       shipSago123
		// /data/rawrecords/yodlee_extract
		$config['hostname'] = '192.168.6.126';
		$config['username'] = 'tranfer_nb';
		$config['password'] = 'shipSago123';
		$config['debug']	= TRUE;
		$ddd = $this->ftp->connect($config);
		$this->ftp->upload('./upload/testexcel.txt','/data/rawrecords/nb_extract/testexcel.txt',"",777);
		$this->ftp->upload('./upload/card.txt','/data/rawrecords/nb_extract/card.txt',"",777);
		$this->ftp->close();
		
    }
	
	function establishment(){
        //place where the excel file is created
        $myFile = "./upload/testexcel_establishment.txt";
        $this->load->library('parser');
 
        //load required data from database
        $userDetails = $this->user_model->establishment();
        $data['user_details'] = $userDetails;
		
		foreach($userDetails as $abc){
			$array = get_object_vars($abc);
			//echo $comma_separated = implode("+",$array);	
		}
		
        //pass retrieved data into template and return as a string
        $stringData = $this->parser->parse('establishment_details_csv', $data, true);
	
        //open excel and write string into excel
        $fh = fopen($myFile, 'w') or die("can't open file");
        fwrite($fh, $stringData);
 
        fclose($fh);
        //download excel file
        //$this->downloadExcelestablishment();
		$config['hostname'] = '192.168.6.126';
		$config['username'] = 'tranfer_nb';
		$config['password'] = 'shipSago123';
		$config['debug']	= TRUE;
		$this->ftp->connect($config);
		$this->ftp->upload('./upload/testexcel_establishment.txt','/data/rawrecords/nb_extract/testexcel_establishment.txt',"",777);
		$this->ftp->upload('./upload/establishment.txt','/data/rawrecords/nb_extract/establishment.txt',"",777);
		$this->ftp->close();
    }
	
	function offer(){
        //place where the excel file is created
        $myFile = "./upload/testexcel_offer.txt";
        $this->load->library('parser');
 
        //load required data from database
        $userDetails = $this->user_model->offer();
        $data['user_details'] = $userDetails;
		
		foreach($userDetails as $abc){
			$array = get_object_vars($abc);
			//echo $comma_separated = implode("+",$array);	
		}
		
        //pass retrieved data into template and return as a string
        $stringData = $this->parser->parse('offer_details_csv', $data, true);
		//print_r($stringData);
		//exit();
 
        //open excel and write string into excel
        $fh = fopen($myFile, 'w') or die("can't open file");
        fwrite($fh, $stringData);
 
        fclose($fh);
        //download excel file
        //$this->downloadExceleoffer();
		$config['hostname'] = '192.168.6.126';
		$config['username'] = 'tranfer_nb';
		$config['password'] = 'shipSago123';
		$config['debug']	= TRUE;
		$this->ftp->connect($config);
		$this->ftp->upload('./upload/testexcel_offer.txt','/data/rawrecords/nb_extract/testexcel_offer.txt',"",777);
		$this->ftp->upload('./upload/offer.txt','/data/rawrecords/nb_extract/offer.txt',"",777);
		$this->ftp->close();
    }
	
	
	
	function downloadExcel(){
        $myFile = "./upload/testexcel.txt";
        header("Content-Length: " . filesize($myFile));
		header('Content-Type: text/plain');
        //header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=testexcel.txt');
        readfile($myFile);
    }
	
	function downloadExcelestablishment(){
        $myFile = "./upload/testexcel_establishment.txt";
        header("Content-Length: " . filesize($myFile));
		header('Content-Type: text/plain');
        //header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=testexcel_establishment.txt');
        readfile($myFile);
    }
	
	function downloadExceleoffer(){
        $myFile = "./upload/testexcel_offer.txt";
        header("Content-Length: " . filesize($myFile));
		header('Content-Type: text/plain');
        //header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=testexcel_offer.txt');
        readfile($myFile);
    }
	
	
	function uploadfile(){
		/*$config['hostname'] = 'kreaserve.in';
		$config['username'] = 'kreaserve';
		$config['password'] = 'saiprasad123';
		//$config['port'] =     '';
		$config['debug']	= TRUE;
		$ddd = $this->ftp->connect($config);
		echo $ddd;
		//$this->ftp->upload('./upload/testexcel.txt','/public_html/testexcel.txt');
		$this->ftp->close();*/
		$config['hostname'] = 'kreaserv.in';
		$config['username'] = 'kreaserv';
		$config['password'] = 'saiprasad123';
		$config['debug']	= TRUE;
		$val = $this->ftp->connect($config);
		echo $val;
		
		$this->ftp->upload('file:///C:/Users/ITRS-132/Desktop/save.txt', '/public_html/save.txt', 'ascii', 0775);
		$this->ftp->close();
		
	}	
	
}

?>
	