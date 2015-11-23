<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Validate_enrichment extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$estab_id = array( 1381, 1067, 1438, 2062, 1381, 1067, 1381, 2062, 1381, 1067, 1067, 1439, 1438, 1381, 1067, 1440, 1067, 1067, 1381, 199, 199, 1438, 1381, 2062, 1441, 1381, 1439, 1441, 1067, 1381, 2062, 1442, 1443, 1381, 1067, 1067, 199, 1382, 1381, 1442, 1440, 1441, 1444, 1439, 1440, 1445, 1446, 1443, 1438, 1446, 1251, 1067, 1067, 1447, 1444, 1383, 1448, 199, 1449, 1381, 171, 198, 1381, 1251, 1441, 1438, 199, 1633, 1439, 1381, 1439, 198, 199, 1448, 1381, 1451, 1381, 1452, 1442, 199, 1449, 1452, 1447, 1453, 1454, 1251, 199, 1381, 2062, 1441, 1067, 1455, 1441, 1438, 1448, 1446, 1446, 1067, 1446, 199, 171, 1439, 199, 1441, 1633, 1446, 1442, 1251, 1381, 169, 1448, 1457, 1439, 428, 1440, 1441, 1458, 1451, 1462, 1441, 1463, 993, 1463, 1446, 1465, 199, 1251, 199, 1466, 1467, 1439, 1439, 1441, 1448, 1451, 1381, 1251, 2062, 1439, 1439, 1067, 1439, 198, 1446, 1440, 1438, 1067, 1067, 1453, 1443, 1439, 1067, 1439, 2062, 199, 1466, 1468, 1452, 1462, 1381, 1067, 1448, 1462, 1459, 1381, 171, 1459, 173, 1439, 1438, 198, 1443, 1441, 1442, 1381, 1496, 1454, 1439, 1457, 1459, 1439, 1050, 1447, 1474, 171, 1458, 1476, 1475, 1477, 1440, 1451, 1478, 1459, 1625, 1625, 1067, 1067, 1480, 2062, 1446, 1438, 138, 1383, 1449, 1470, 2062, 1477, 1463, 2158, 173, 1438, 2062, 1634, 1381, 1459, 1462, 1461, 1381, 1439, 1473, 175, 1473, 1483, 1439, 1439, 1441, 1067, 1484, 2062, 199, 199, 1103, 1443, 1438, 1067, 1067, 175, 1067, 1474, 1485, 1439, 1441, 199, 1467, 1218, 1487, 1496, 1470, 1443, 1034, 1488, 1489, 1490, 1491, 1493, 1454, 1492, 1494, 1067, 1457, 1067, 1461, 1495, 1441, 1442, 199, 1043, 1497, 1451, 1251, 1496, 1498, 1499, 1446, 1067, 1443, 1500, 199, 1453, 1458, 2062, 1468, 1461, 1447, 1625, 1502, 1451, 173, 1503, 1633, 1458, 2062, 1502, 1504, 428, 162, 2062, 1505, 171, 1438, 1382, 1439, 1506, 1507, 1508, 1475, 1509, 1439, 1439, 1381, 1487, 1510, 1474, 1459, 198, 1475, 2100, 1446, 1067, 198, 1443, 1473, 1495, 1439, 1442, 1439, 198, 1447, 199, 1439, 2062, 1381, 1439, 1439, 1473, 1471, 1439, 198, 1439, 2062, 1439, 1441, 1446, 1458, 1441, 1446, 1447, 1067, 1470, 1439, 1446, 1439, 1447, 1439, 198, 1443, 2062, 1459, 1439, 1067, 1458, 1446, 1251, 1439, 1471, 1443, 1251, 1439, 1472, 1443, 1470, 1439, 1438, 1452, 1067, 2062, 199, 198, 1439, 1439, 199, 1439, 199, 1441, 1441, 1381, 1439, 1439, 1439, 199, 1495, 1442, 1439, 1446, 1446, 1442, 1447, 2062, 1439, 1458, 1473, 2062, 1439, 198, 1459, 1067, 1447, 1439, 1439, 1458, 1471, 1447, 199, 199, 1439, 1439, 1439, 1458, 2062 );

		foreach ($estab_id as $value) {
			$this->db->where('id', $value);
			$data = $this->db->get('establishment');

			if ($data->num_rows() > 0){
			// echo 'Establishment Id : '.$value.'<br>';
			} else {
				echo 'Establishment Not Present : '.$value.'<br>';
			}
		}
	}


	public function make_location_array(){
		$est_id = '';
		$push_arr = '';
		$push_arr2 = '';
		$offer_nam = '';
		$data = $this->db->query("SELECT COUNT(establishment_id) AS c, establishment_id FROM `offers` WHERE latitude != '' AND longtitude != '' GROUP BY establishment_id ORDER BY establishment_id");
		print_r($data->num_rows());
		echo '<br>';
		foreach ($data->result() as $value) {
			$push_arr = '';
			$push_arr2 = '';

			if($value->c > 1){
				echo $value->establishment_id.'<br>';
				$est_data = $this->db->query('SELECT * FROM offers WHERE establishment_id = '.$value->establishment_id.' ORDER BY offer ASC');

				foreach ($est_data->result() as $v) {
					if(!strcmp($v->offer, $offer_nam)){
						echo "equal   ";
						echo $v->offer.'	';
						echo $v->latitude.'	';
						echo $v->longtitude.'<br>';
						$push_arr = $v->latitude.', '.$push_arr;
						$push_arr2 = $v->longtitude.', '.$push_arr2;
					} else {
						echo "Not equal   ";
						echo $v->offer.'	';
						echo $v->latitude.'	';
						echo $v->longtitude.'<br>';
						$push_arr = $v->latitude;
						$push_arr2 = $v->longtitude;
					}

					$offer_nam = $v->offer;
				}
				echo 'Equal array lat  '.$push_arr.'<br>';
				echo 'Equal array long '.$push_arr2.'<br>';
			}
		}
	}
}

// public function dashboard1(){
// $this->load->view('admin/dashboard1');
// }

// function readxl(){
 //        if (@$_FILES[csv][size] > 0) { 
//     $file = @$_FILES[csv][tmp_name]; 
//     $handle = fopen($file,"r"); 

//     do {
//     $data = explode('";"', @$data_csv[0]); 
//         if (@$data[0]) { 
// $data1 = array(
 //   'description' => addslashes($data[0]),
// 'zipsave_category' => addslashes($data[1]),
// 'zipsave_subcategory_1' => addslashes($data[2]),
// 'offline_online' => addslashes($data[3]),
// 'city' => addslashes($data[4]),
// 'establishment' => addslashes($data[5]),
// 'brand' => addslashes($data[6]),
// 'any_additional_info' => addslashes($data[7]),
// );
// $this->db->insert('rules', $data1);

//         } 
//     } while (@$data_csv = fgetcsv($handle,1000,';','"')); 
// }
// }