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
	
	/*public function user(){
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
        /*download excel file
       	$this->downloadExcel();
        192.168.6.126
        tranfer_nb
        shipSago123
		/data/rawrecords/yodlee_extract
		$config['hostname'] = '192.168.6.126';
		$config['username'] = 'tranfer_nb';
		$config['password'] = 'shipSago123';
		$config['hostname'] = '192.168.15.96';
		$config['username'] = 'tranfer_nb';
		$config['password'] = 'sagoShip123';*/
		$config['debug']	= TRUE;
		$ddd = $this->ftp->connect($config);
		$this->ftp->upload('./upload/testexcel.txt','/data/rawrecords/nb_extract/testexcel.txt',"",777);
		$this->ftp->upload('./upload/card.txt','/data/rawrecords/nb_extract/card.txt',"",777);
		$this->ftp->close();
    }

	function cards_file(){
        //place where the excel file is created
        $myFile = "./upload/cards.txt";
        $this->load->library('parser');
        //load required data from database
        $userDetails = $this->user_model->cards();
        $data['user_details'] = $userDetails;
		
		foreach($userDetails as $abc){
			$array = get_object_vars($abc);
		}
        //pass retrieved data into template and return as a string
        $stringData = $this->parser->parse('user_details_csv', $data, true);
        //open excel and write string into excel
        $stringData = trim($stringData);
        $fh = fopen($myFile, 'w') or die("can't open file");
        fwrite($fh,$stringData);
        fclose($fh);

        $this->checkcharacters($myFile);
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
		// $config['hostname'] = '192.168.6.126';
		// $config['username'] = 'tranfer_nb';
		// $config['password'] = 'shipSago123';
		$config['hostname'] = '192.168.15.96';
		$config['username'] = 'tranfer_nb';
		$config['password'] = 'sagoShip123';
		$config['debug']	= TRUE;
		$this->ftp->connect($config);
		$this->ftp->upload('./upload/testexcel_establishment.txt','/data/rawrecords/nb_extract/testexcel_establishment.txt',"",777);
		$this->ftp->upload('./upload/establishment.txt','/data/rawrecords/nb_extract/establishment.txt',"",777);
		$this->ftp->close();
    }
	
    function establishment_file(){
        //place where the excel file is created
        $myFile = "./upload/establishment.txt";
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
        $stringData = trim($stringData);
        //open excel and write string into excel
        $fh = fopen($myFile, 'w') or die("can't open file");
        fwrite($fh, $stringData);
        fclose($fh);
        $this->checkcharacters($myFile);
    }
	
	function offer(){
        //place where the excel file is created
        $myFile = "./upload/offer.txt";
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
		// $config['hostname'] = '192.168.6.126';
		// $config['username'] = 'tranfer_nb';
		// $config['password'] = 'shipSago123';
		$config['hostname'] = '192.168.15.96';
		$config['username'] = 'tranfer_nb';
		$config['password'] = 'sagoShip123';
		$config['passive']  = TRUE;
		$config['debug']	= TRUE;

		$this->ftp->connect($config);

		$this->ftp->upload('./upload/testexcel_offer.txt','/data/rawrecords/nb_extract/testexcel_offer.txt',"",777);
		$this->ftp->upload('./upload/offer.txt','/data/rawrecords/nb_extract/offer.txt',"",777);

		$this->ftp->close();
    }

    function offer_file(){
        $myFile = "./upload/offer.txt";
        $this->load->library('parser');
 
        $userDetails = $this->user_model->offer();
        $data['user_details'] = $userDetails;
		
		foreach($userDetails as $abc){
			$array = get_object_vars($abc);
			//echo $comma_separated = implode("+",$array);	
		}
		
        $stringData = $this->parser->parse('offer_details_csv', $data, true);
 
        $stringData = trim($stringData);

        $fh = fopen($myFile, 'w') or die("can't open file");
        fwrite($fh, $stringData);
 
        fclose($fh);
        $this->checkcharacters($myFile);
    }

    /********** Junk Characters Checking Start**************/
    function checkcharacters($myFile){
    	$valid =0;
        $counter=0;
        $msg="";
        
        $handle = fopen($myFile, "r");
		if ($handle) {
		    while (($line = fgets($handle)) !== false) {
		    	$counter++;
		        if (preg_match_all('/^[\x{0000}-\x{007E}\x{00A0}\x{02C2}\x{02C3}\x{2010}\x{2012}\x{00C7}\x{2122}\x{00AE}]+$/u', $line)) {
				  
				}
				else{
					$valid=1;
					if($msg==""){
						$msg = "Invalid data at <br> line number: ".$counter;
					}
					else{
						$msg .= "line number: ".$counter;
					}
					if(preg_match('/[^(\x{0000}-\x{007E}\x{00A0}\x{02C2}\x{02C3}\x{2010}\x{2012}\x{00C7}\x{2122}\x{00AE})]+/u', $line,$matches)){
						foreach ($matches as $value) {
							$msg .= " : ".$value;
						}
					}
					$msg .= "<br>";
					$msg .= $line."<br><br>";	
				}
		    }
		    fclose($handle);
		} else {
			$valid=1;
		}

		if($valid==0){
			$countobj = $this->db->query("SELECT COUNT(*) as totalrows from establishment")->row();
			if($counter = $countobj->totalrows+1){
				echo "Success";
			}
			else{
				echo "data seems to be splited";
			}
		}
		else{
			//echo "invalid data at Line number ".$counter;
			echo $msg;
		}
    }
    /********** Junk Characters Checking End **************/

    /********** Download File Start **************/
    function download_file($file){
    	$myFile = "./upload/".$file.".txt";
    	$type = filetype($myFile);
	    // Get a date and timestamp
	    $today = date("F j, Y, g:i a");
	    $time = time();
	    // Send file headers   
	    header("Content-type: $type");
	    header("Content-Disposition: attachment;filename=".$file.".txt");
	    header("Content-Transfer-Encoding: binary"); 
	    header('Pragma: no-cache'); 
	    header('Expires: 0');
	    // Send the file contents.
	    set_time_limit(0); 
	    readfile($myFile);
    }
    /********** Download File End **************/

    /********** Send File Start **************/
    function send_file($file){
    	$host = '192.168.15.96';
		$usr = 'transfer_nb';
		$pwd = 'sagoShip123';
		$local_file = './upload/'.$file.'.txt';
		$ftp_path = '/data/rawrecords/nb_extract/'.$file.'.txt';

		$local_file2 = './upload/success/'.$file.'.txt';
		$ftp_path2 = '/data/rawrecords/nb_extract/success/'.$file.'.txt';

		$conn_id = ftp_connect($host, 21) or die ("Cannot connect to host");
		ftp_login($conn_id, $usr, $pwd) or die("Cannot login");

		$upload = ftp_put($conn_id, $ftp_path, $local_file, FTP_ASCII);
		print (!$upload) ? 'Cannot upload' : 'Upload complete';
		print "\n";

		if (!function_exists('ftp_chmod')) {
		   function ftp_chmod($ftp_stream, $mode, $filename){
		        return ftp_site($ftp_stream, sprintf('CHMOD %o %s', $mode, $filename));
		   }
		}
		 
		if (ftp_chmod($conn_id, 0666, $ftp_path) !== false) {
		    print $ftp_path . " chmoded successfully to 666\n";
		} else {
		    print "could not chmod $file\n";
		}

		$upload2 = ftp_put($conn_id, $ftp_path2, $local_file2, FTP_ASCII);

		print (!$upload2) ? 'Cannot upload' : 'Success';
		print "\n";

		ftp_close($conn_id);
    }
    /********** Send File End **************/


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
	