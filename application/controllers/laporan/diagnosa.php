<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Diagnosa extends CI_Controller {
   // $kun="";
    

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('m_laporan','m_transaksi'));
        $this->load->helper('url'); // Load Helper URL CI
        $this->load->library(array('excel'));
        //$this->load->helper('form');
    }


   
    
        function index()
    {
	$this->load->view('laporan/diagnosa'); //Default di arahkan ke function grid

 	//$id= $this->session->userdata('id_user');
        
    //echo "Semangat";
	}
	
	function json() 
	{
                $diagnosa = $this->input->get('diagnosa');
                $bulan = $this->input->get('bulan');
                $tahun = $this->input->get('tahun');
		$page  = $this->input->get('page');
		$limit = $this->input->get('rows');
		$sidx  = $this->input->get('sidx');
		$sord  = $this->input->get('sord');
		$rayon=$this->session->userdata('id_rayon');
                //$rayon=1;
                $wilayah=$this->session->userdata('id_wilayah');
                $mitra=$this->session->userdata('id_mitra');
                

		if(!$sidx) $sidx=1;
		
	
		# Untuk Single Searchingnya #		
		$where = ""; //if there is no search request sent by jqgrid, $where should be empty
		$searchField = isset($_GET['searchField']) ? $_GET['searchField'] : false;
		$searchString = isset($_GET['searchString']) ? $_GET['searchString'] : false;
		/*if ($_GET['_search'] == 'true')
		{
			$where = array($searchField => $searchString);
		}*/
		# End #
		$searchField='nama_diagnosa';
                $searchString=$diagnosa;
                 
		$count = $this->m_laporan->count_Diagnosa($searchField,$searchString,$rayon,$wilayah,$mitra,$bulan,$tahun);
		
		$count > 0 ? $total_pages = ceil($count/$limit) : $total_pages = 0;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		if($start <0) $start = 0;
		
		$data1 = $this->m_laporan->get_Diagnosa1($searchField,$searchString, $sidx, $sord, $limit, $start,$rayon,$wilayah,$mitra,$bulan,$tahun)->result();

               

		$responce->page = $page;
		$responce->total = $total_pages;
		$responce->records = $count;
                $responce->bulan = $bulan;
                $responce->tahun = $tahun;
		$i=0;
		foreach($data1 as $line)
		{
			$responce->rows[$i]['id_transaksi']   = $line->id_transaksi;
			
			$responce->rows[$i]['cell'] = array($line->id_transaksi,$line->nama_diagnosa,$line->nip,$line->nama_karyawan,$line->status,$line->nama_tertanggung);
			$i++;
		}
		echo json_encode($responce);
	}

        function crud()
	{
		$oper=$this->input->post('oper');
		$id_transaksi=$this->input->post('id');




	    switch ($oper)
		{
	        case 'del':
	            $this->m_transaksi->delete_transaksi($id_transaksi);
	        break;
		}
	}
        
        function ekspor()
	{

	error_reporting(E_ALL);

	date_default_timezone_set('Europe/London');

	// Add some data
                $diagnosa = $this->input->get('diagnosa');
                $bulan = $this->input->get('bulan');
                $tahun = $this->input->get('tahun');
		$page  = $this->input->get('page');
		$limit = $this->input->get('rows');
		$sidx  = $this->input->get('sidx');
		$sord  = $this->input->get('sord');
		//$rayon=$this->session->userdata('id_rayon');
                $rayon=1;
                $wilayah=$this->session->userdata('id_wilayah');
                $mitra=$this->session->userdata('id_mitra');


		if(!$sidx) $sidx=1;


		# Untuk Single Searchingnya #
		$where = ""; //if there is no search request sent by jqgrid, $where should be empty
		$searchField = isset($_GET['searchField']) ? $_GET['searchField'] : false;
		$searchString = isset($_GET['searchString']) ? $_GET['searchString'] : false;
		/*if ($_GET['_search'] == 'true')
		{
			$where = array($searchField => $searchString);
		}*/
		# End #
		$searchField='nama_diagnosa';
                $searchString=$diagnosa;

		$count = $this->m_laporan->count_Diagnosa($searchField,$searchString,$rayon,$wilayah,$mitra,$bulan,$tahun);

		$count > 0 ? $total_pages = ceil($count/$limit) : $total_pages = 0;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		if($start <0) $start = 0;

		$data1 = $this->m_laporan->get_Diagnosa($searchField,$searchString, $sidx, $sord, $limit, $start,$rayon,$wilayah,$mitra,$bulan,$tahun)->result();
                $tulis=$this->excel->setActiveSheetIndex(0);

                        $tulis->setCellValue('A1', "No");
                        $tulis->setCellValue('B1', "id_transaksi");
                        $tulis->setCellValue('C1', "Diagnosa");
                        $tulis->setCellValue('D1', "NIP");
                        $tulis->setCellValue('E1', "Penanggung");
                        $tulis->setCellValue('F1', "Status");
                        $tulis->setCellValue('G1', "Pasien");


        $i=2;
        foreach($data1 as $line)
		{

			$tulis->setCellValue('A'.$i, $i-1);
                        $tulis->setCellValue('B'.$i, $line->id_transaksi);
                        $tulis->setCellValue('C'.$i, $line->nama_diagnosa);
                        $tulis->setCellValue('D'.$i, $line->nip);
                        $tulis->setCellValue('E'.$i, $line->nama_karyawan);
                        $tulis->setCellValue('F'.$i, $line->status);
                        $tulis->setCellValue('G'.$i, $line->nama_tertanggung);
			$i++;
		}


      	// Rename worksheet
	$this->excel->getActiveSheet()->setTitle('Laporan Diagnosa');


	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$this->excel->setActiveSheetIndex(0);


	// Redirect output to a client�s web browser (Excel5)
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="Laporan Diagnosa.xls"');
	header('Cache-Control: max-age=0');

	$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
	$objWriter->save('php://output');
	//exit;
	}

}