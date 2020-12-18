<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// require_once('vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Home extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Home_model');
	}
	
	public function index()
	{
		$this->load->view('Home');
	}
	
	function getTamu()
	{
		$nama = $_POST["nama"];
		$pos1 = strpos($nama," : ");
		$pos2 = strpos($nama,"Alamat : ");
		$nama = substr($nama, $pos1+3, $pos2-($pos1+3));
		$alamat = trim(substr($_POST["nama"], $pos2+8));
		//echo rtrim($nama);
		
		$jam = date("Y-m-d H:i:s");
		$data = array("guest_date"=>$jam);
		$dataDetail = $this->Home_model->update_tamu($nama, $data);
		if ($dataDetail == "ok") {
			$out = array("nama"=>$nama, "alamat"=>$alamat, "jam"=>$jam);
			echo json_encode($out);
		} else {
			echo "false";
		}
	}
	
	function fileImport()
	{
		$file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		if(isset($_FILES['file']['name']) && in_array($_FILES['file']['type'], $file_mimes)) {
			$arr_file = explode('.', $_FILES['file']['name']);
			$extension = end($arr_file);
			if('csv' == $extension){
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
			} else {
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			}
			$spreadsheet = $reader->load($_FILES['file']['tmp_name']);
			$sheetData = $spreadsheet->getActiveSheet()->toArray();
// 			echo "<pre>";
// 			print_r($sheetData);
			$data = array();
			for($i = 1; $i < count ( $sheetData ); $i ++) {
				array_push($data, array("guest_name"=>$sheetData[$i][0], "guest_addr"=>$sheetData[$i][1]));
			}
			$dataDetail = $this->Home_model->import_data($data);
		}
	}
	
	function getHadir()
	{
		$data = array ();
		$dataDetail = $this->Home_model->get_hadir()->result_array();
		for($i = 0; $i < count ( $dataDetail ); $i ++) {
			$row = array ();
			$row ['guest_name'] = $dataDetail [$i] ['guest_name'];
			$row ['guest_addr'] = $dataDetail [$i] ['guest_addr'];
			$row ['guest_date'] = $dataDetail [$i] ['guest_date'];
			$data [$i] = $row;
		}
		echo json_encode($data);
	}
}
