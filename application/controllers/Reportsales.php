<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
date_default_timezone_set('Asia/Jakarta');
require 'vendor/autoload.php';

use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Reportsales extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('global_model');
		$this->load->model('reportsales_model');
		$this->load->model('masterdata_model');
		$this->load->helper(array('url', 'html'));
	}

	private function check_auth($modul){
		if(isset($_SESSION['user_name']) == null){
			redirect('Dashboard', 'refresh');
		}else{
			$user_role_id = $_SESSION['user_role_id'];
			$check_access = $this->global_model->check_access($user_role_id, $modul);
			return($check_access);
		}
	}

	public function index(){
		echo 'Report Pembelian';die();
	}

	// Report Sales Order
	public function reportsalesorder()
	{
		$modul = 'Report';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$customer_list['customer_list'] = $this->masterdata_model->customer_list();
            $salesman_list['salesman_list'] = $this->masterdata_model->salesman_list();
            $warehouse_list['warehouse_list'] = $this->masterdata_model->warehouse_list();
			$data['data'] = array_merge($customer_list, $salesman_list, $warehouse_list);
			$this->load->view('Pages/Report/Sales/reportsalesorder', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}
    
    public function reportsalesorderpdf()
    {
        $start_date       = $this->input->get('start_date');
		$end_date 	      = $this->input->get('end_date');
		$customer_report  = $this->input->get('customer_report');
        $salesman_report  = $this->input->get('salesman_report');
        $warehouse_report = $this->input->get('warehouse_report');

		$data['data'] = $this->reportsales_model->get_report_sales_order($start_date, $end_date, $customer_report, $salesman_report, $warehouse_report)->result_array();
		$htmlView   = $this->load->view('Pages/Report/Sales/reportsalesorderpdf', $data, true);
		$dompdf = new Dompdf();
		$dompdf->loadHtml($htmlView);
		$dompdf->setPaper('A4', 'landscape');
		$dompdf->render();
		$dompdf->stream('pembelian.pdf', array("Attachment" => false));
		exit();
    }

    public function reportsalesorder_excell()
	{
		$modul = 'Report';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$start_date       = $this->input->get('start_date');
			$end_date 	      = $this->input->get('end_date');
		    $customer_report  = $this->input->get('customer_report');
            $salesman_report  = $this->input->get('salesman_report');
            $warehouse_report = $this->input->get('warehouse_report');

			$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
			$sheet = $excel->getActiveSheet();
			$sheet->setCellValue('A1', "Laporan Sales Order"); 
			$sheet->mergeCells('A1:S1');
			$sheet->getStyle('A1')->getFont()->setBold(true);
			$sheet->getStyle('A3:S3')->getFont()->setBold(true);
			$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
			$sheet->getStyle('A3:S3')->getAlignment()->setHorizontal('center');
			$sheet->setCellValue('A3', "Invoice"); 
			$sheet->setCellValue('B3', "Tanggal"); 
			$sheet->setCellValue('C3', "Pelanggan"); 
			$sheet->setCellValue('D3', "Pembayaran"); 
			$sheet->setCellValue('E3', "Ekspedisi");
            $sheet->setCellValue('F3', "Nama Barang");
            $sheet->setCellValue('G3', "Satuan");
            $sheet->setCellValue('H3', "Qty");
            $sheet->setCellValue('I3', "Harga");
            $sheet->setCellValue('J3', "Total Harga Barang");
			$sheet->setCellValue('K3', "TOP");
			$sheet->setCellValue('L3', "Salsesman");
			$sheet->setCellValue('M3', "Prepare By");
			$sheet->setCellValue('N3', "Koli");
			$sheet->setCellValue('O3', "Cabang");
            $sheet->setCellValue('P3', "Subtotal");
            $sheet->setCellValue('Q3', "Diskon");
            $sheet->setCellValue('R3', "PPN");
            $sheet->setCellValue('S3', "Total");
            $sheet->setCellValue('T3', "Catatan");
             $sheet->setCellValue('U3', "Di Buat Oleh");

			$data = $this->reportsales_model->get_report_sales_order($start_date, $end_date, $customer_report, $salesman_report, $warehouse_report)->result_array();
			$i = 4;

			foreach($data as $row){
				$sheet->setCellValue('A'.$i, $row['hd_sales_order_inv']); 
				$sheet->setCellValue('B'.$i, $row['hd_sales_order_date']); 
				$sheet->setCellValue('C'.$i, $row['customer_name']);
				$sheet->setCellValue('D'.$i, $row['payment_name']); 
				$sheet->setCellValue('E'.$i, $row['ekspedisi_name']); 
				$sheet->setCellValue('F'.$i, $row['product_name']);
				$sheet->setCellValue('G'.$i, $row['unit_name']);
				$sheet->setCellValue('H'.$i, $row['dt_so_qty']); 
				$sheet->setCellValue('I'.$i, $row['dt_so_price']); 
				$sheet->setCellValue('J'.$i, $row['dt_so_total']); 
                $sheet->setCellValue('K'.$i, $row['hd_sales_order_top']); 
                $sheet->setCellValue('L'.$i, $row['salesman_name']); 
                $sheet->setCellValue('M'.$i, $row['hd_sales_order_prepare']); 
                $sheet->setCellValue('N'.$i, $row['hd_sales_order_colly']); 
                $sheet->setCellValue('O'.$i, $row['warehouse_name']); 
                $sheet->setCellValue('P'.$i, $row['hd_sales_order_sub_total']); 
                $sheet->setCellValue('Q'.$i, $row['hd_sales_order_total_discount']); 
                $sheet->setCellValue('R'.$i, $row['hd_sales_order_ppn']); 
                $sheet->setCellValue('S'.$i, $row['hd_sales_order_total']); 
                $sheet->setCellValue('T'.$i, $row['hd_sales_order_note']); 
                $sheet->setCellValue('U'.$i, $row['user_name']); 
				$i++;
			};

			$sheet->getColumnDimension('A')->setWidth(35); 
			$sheet->getColumnDimension('B')->setWidth(25); 
			$sheet->getColumnDimension('C')->setWidth(25);
			$sheet->getColumnDimension('D')->setWidth(25);
			$sheet->getColumnDimension('E')->setWidth(25);
			$sheet->getColumnDimension('F')->setWidth(40);
			$sheet->getColumnDimension('G')->setWidth(25);
			$sheet->getColumnDimension('H')->setWidth(20);
			$sheet->getColumnDimension('I')->setWidth(20);
			$sheet->getColumnDimension('J')->setWidth(20);
            $sheet->getColumnDimension('K')->setWidth(30);
            $sheet->getColumnDimension('L')->setWidth(35);
            $sheet->getColumnDimension('M')->setWidth(30);
            $sheet->getColumnDimension('N')->setWidth(20);
            $sheet->getColumnDimension('O')->setWidth(30);
            $sheet->getColumnDimension('P')->setWidth(30);
            $sheet->getColumnDimension('Q')->setWidth(30);
            $sheet->getColumnDimension('R')->setWidth(30);
            $sheet->getColumnDimension('S')->setWidth(30);
            $sheet->getColumnDimension('T')->setWidth(30);
            $sheet->getColumnDimension('U')->setWidth(50);
            $sheet->getColumnDimension('U')->setWidth(30);


            $sheet->getStyle('I')->getNumberFormat()->setFormatCode('#,##0');	
            $sheet->getStyle('J')->getNumberFormat()->setFormatCode('#,##0');	
			$sheet->getStyle('P')->getNumberFormat()->setFormatCode('#,##0');	
			$sheet->getStyle('Q')->getNumberFormat()->setFormatCode('#,##0');	
			$sheet->getStyle('R')->getNumberFormat()->setFormatCode('#,##0');	
			$sheet->getStyle('S')->getNumberFormat()->setFormatCode('#,##0');	


			$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
			$sheet->setTitle("Excell");
			ob_end_clean();
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="sales_order_' .date('Y-m-d') . '.xlsx"');
			header('Cache-Control: max-age=0');

			$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($excel, 'Xlsx');
			$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
			exit($xlsxWriter->save('php://output'));
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}
	// End Report sales Order 



    // Report Sales
    public function reportsaless()
	{
		$modul = 'Report';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$customer_list['customer_list'] = $this->masterdata_model->customer_list();
            $salesman_list['salesman_list'] = $this->masterdata_model->salesman_list();
            $warehouse_list['warehouse_list'] = $this->masterdata_model->warehouse_list();
			$data['data'] = array_merge($customer_list, $salesman_list, $warehouse_list);
			$this->load->view('Pages/Report/Sales/reportsaless', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}
    
    public function reportsalesspdf()
    {
        $start_date       = $this->input->get('start_date');
		$end_date 	      = $this->input->get('end_date');
		$customer_report  = $this->input->get('customer_report');
        $salesman_report  = $this->input->get('salesman_report');
        $warehouse_report = $this->input->get('warehouse_report');

		$data['data'] = $this->reportsales_model->get_report_sales($start_date, $end_date, $customer_report, $salesman_report, $warehouse_report)->result_array();
		$htmlView   = $this->load->view('Pages/Report/Sales/reportsalesorderpdf', $data, true);
		$dompdf = new Dompdf();
		$dompdf->loadHtml($htmlView);
		$dompdf->setPaper('A4', 'landscape');
		$dompdf->render();
		$dompdf->stream('pembelian.pdf', array("Attachment" => false));
		exit();
    }

	public function reportsaless_excell()
	{
		$modul = 'Report';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$start_date       = $this->input->get('start_date');
			$end_date 	      = $this->input->get('end_date');
		    $customer_report  = $this->input->get('customer_report');
            $salesman_report  = $this->input->get('salesman_report');
            $warehouse_report = $this->input->get('warehouse_report');

			$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
			$sheet = $excel->getActiveSheet();
			$sheet->setCellValue('A1', "Laporan Penjualan"); 
			$sheet->mergeCells('A1:S1');
			$sheet->getStyle('A1')->getFont()->setBold(true);
			$sheet->getStyle('A3:S3')->getFont()->setBold(true);
			$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
			$sheet->getStyle('A3:S3')->getAlignment()->setHorizontal('center');
			$sheet->setCellValue('A3', "Invoice"); 
			$sheet->setCellValue('B3', "Tanggal"); 
			$sheet->setCellValue('C3', "Pelanggan"); 
			$sheet->setCellValue('D3', "Pembayaran"); 
			$sheet->setCellValue('E3', "Ekspedisi");
            $sheet->setCellValue('F3', "Nama Barang");
            $sheet->setCellValue('G3', "Satuan");
            $sheet->setCellValue('H3', "Qty");
            $sheet->setCellValue('I3', "Harga");
            $sheet->setCellValue('J3', "Total Harga Barang");
			$sheet->setCellValue('K3', "TOP");
			$sheet->setCellValue('L3', "Salsesman");
			$sheet->setCellValue('M3', "Prepare By");
			$sheet->setCellValue('N3', "Koli");
			$sheet->setCellValue('O3', "Cabang");
            $sheet->setCellValue('P3', "Subtotal");
            $sheet->setCellValue('Q3', "Diskon");
            $sheet->setCellValue('R3', "PPN");
            $sheet->setCellValue('S3', "Total");
            $sheet->setCellValue('T3', "Catatan");
             $sheet->setCellValue('U3', "Di Buat Oleh");

			$data = $this->reportsales_model->get_report_sales($start_date, $end_date, $customer_report, $salesman_report, $warehouse_report)->result_array();
			$i = 4;

			foreach($data as $row){
				$sheet->setCellValue('A'.$i, $row['hd_sales_inv']); 
				$sheet->setCellValue('B'.$i, $row['hd_sales_date']); 
				$sheet->setCellValue('C'.$i, $row['customer_name']);
				$sheet->setCellValue('D'.$i, $row['payment_name']); 
				$sheet->setCellValue('E'.$i, $row['ekspedisi_name']); 
				$sheet->setCellValue('F'.$i, $row['product_name']);
				$sheet->setCellValue('G'.$i, $row['unit_name']);
				$sheet->setCellValue('H'.$i, $row['dt_sales_qty']); 
				$sheet->setCellValue('I'.$i, $row['dt_sales_price']); 
				$sheet->setCellValue('J'.$i, $row['dt_sales_total']); 
                $sheet->setCellValue('K'.$i, $row['hd_sales_top']); 
                $sheet->setCellValue('L'.$i, $row['salesman_name']); 
                $sheet->setCellValue('M'.$i, $row['hd_sales_prepare']); 
                $sheet->setCellValue('N'.$i, $row['hd_sales_colly']); 
                $sheet->setCellValue('O'.$i, $row['warehouse_name']); 
                $sheet->setCellValue('P'.$i, $row['hd_sales_sub_total']); 
                $sheet->setCellValue('Q'.$i, $row['hd_sales_total_discount']); 
                $sheet->setCellValue('R'.$i, $row['hd_sales_ppn']); 
                $sheet->setCellValue('S'.$i, $row['hd_sales_total']); 
                $sheet->setCellValue('T'.$i, $row['hd_sales_note']); 
                $sheet->setCellValue('U'.$i, $row['user_name']); 
				$i++;
			};

			$sheet->getColumnDimension('A')->setWidth(35); 
			$sheet->getColumnDimension('B')->setWidth(25); 
			$sheet->getColumnDimension('C')->setWidth(25);
			$sheet->getColumnDimension('D')->setWidth(25);
			$sheet->getColumnDimension('E')->setWidth(25);
			$sheet->getColumnDimension('F')->setWidth(40);
			$sheet->getColumnDimension('G')->setWidth(25);
			$sheet->getColumnDimension('H')->setWidth(20);
			$sheet->getColumnDimension('I')->setWidth(20);
			$sheet->getColumnDimension('J')->setWidth(20);
            $sheet->getColumnDimension('K')->setWidth(30);
            $sheet->getColumnDimension('L')->setWidth(35);
            $sheet->getColumnDimension('M')->setWidth(30);
            $sheet->getColumnDimension('N')->setWidth(20);
            $sheet->getColumnDimension('O')->setWidth(30);
            $sheet->getColumnDimension('P')->setWidth(30);
            $sheet->getColumnDimension('Q')->setWidth(30);
            $sheet->getColumnDimension('R')->setWidth(30);
            $sheet->getColumnDimension('S')->setWidth(30);
            $sheet->getColumnDimension('T')->setWidth(30);
            $sheet->getColumnDimension('U')->setWidth(50);
            $sheet->getColumnDimension('U')->setWidth(30);


            $sheet->getStyle('I')->getNumberFormat()->setFormatCode('#,##0');	
            $sheet->getStyle('J')->getNumberFormat()->setFormatCode('#,##0');	
			$sheet->getStyle('P')->getNumberFormat()->setFormatCode('#,##0');	
			$sheet->getStyle('Q')->getNumberFormat()->setFormatCode('#,##0');	
			$sheet->getStyle('R')->getNumberFormat()->setFormatCode('#,##0');	
			$sheet->getStyle('S')->getNumberFormat()->setFormatCode('#,##0');	


			$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
			$sheet->setTitle("Excell");
			ob_end_clean();
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="sales_' .date('Y-m-d') . '.xlsx"');
			header('Cache-Control: max-age=0');

			$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($excel, 'Xlsx');
			$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
			exit($xlsxWriter->save('php://output'));
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}
    // End Report Sales


	// Report Revisi Sales
    public function reportrevisisales()
	{
		$modul = 'Report';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$customer_list['customer_list'] = $this->masterdata_model->customer_list();
            $salesman_list['salesman_list'] = $this->masterdata_model->salesman_list();
            $warehouse_list['warehouse_list'] = $this->masterdata_model->warehouse_list();
			$data['data'] = array_merge($customer_list, $salesman_list, $warehouse_list);
			$this->load->view('Pages/Report/Sales/reportsalesrevisi', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}
    
    public function reportsalesrevisipdf()
    {
        $start_date       = $this->input->get('start_date');
		$end_date 	      = $this->input->get('end_date');
		$customer_report  = $this->input->get('customer_report');
        $salesman_report  = $this->input->get('salesman_report');
        $warehouse_report = $this->input->get('warehouse_report');

		$data['data'] = $this->reportsales_model->get_report_revisi_sales($start_date, $end_date, $customer_report, $salesman_report, $warehouse_report)->result_array();
		$htmlView   = $this->load->view('Pages/Report/Sales/reportsalesrevisipdf', $data, true);
		$dompdf = new Dompdf();
		$dompdf->loadHtml($htmlView);
		$dompdf->setPaper('A4', 'landscape');
		$dompdf->render();
		$dompdf->stream('pembelian.pdf', array("Attachment" => false));
		exit();
    }

	public function reportrevisisales_excell()
	{
		$modul = 'Report';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$start_date       = $this->input->get('start_date');
			$end_date 	      = $this->input->get('end_date');
		    $customer_report  = $this->input->get('customer_report');
            $salesman_report  = $this->input->get('salesman_report');
            $warehouse_report = $this->input->get('warehouse_report');

			$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
			$sheet = $excel->getActiveSheet();
			$sheet->setCellValue('A1', "Laporan Revisi Penjualan"); 
			$sheet->mergeCells('A1:S1');
			$sheet->getStyle('A1')->getFont()->setBold(true);
			$sheet->getStyle('A3:S3')->getFont()->setBold(true);
			$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
			$sheet->getStyle('A3:S3')->getAlignment()->setHorizontal('center');
			$sheet->setCellValue('A3', "Invoice"); 
			$sheet->setCellValue('B3', "Tanggal"); 
			$sheet->setCellValue('C3', "Pelanggan"); 
			$sheet->setCellValue('D3', "Pembayaran"); 
			$sheet->setCellValue('E3', "Ekspedisi");
            $sheet->setCellValue('F3', "Nama Barang");
            $sheet->setCellValue('G3', "Satuan");
            $sheet->setCellValue('H3', "Qty");
            $sheet->setCellValue('I3', "Harga");
            $sheet->setCellValue('J3', "Total Harga Barang");
			$sheet->setCellValue('K3', "TOP");
			$sheet->setCellValue('L3', "Salsesman");
			$sheet->setCellValue('M3', "Prepare By");
			$sheet->setCellValue('N3', "Koli");
			$sheet->setCellValue('O3', "Cabang");
            $sheet->setCellValue('P3', "Subtotal");
            $sheet->setCellValue('Q3', "Diskon");
            $sheet->setCellValue('R3', "PPN");
            $sheet->setCellValue('S3', "Total");
            $sheet->setCellValue('T3', "Catatan");
             $sheet->setCellValue('U3', "Di Buat Oleh");

			$data = $this->reportsales_model->get_report_revisi_sales($start_date, $end_date, $customer_report, $salesman_report, $warehouse_report)->result_array();
			$i = 4;

			foreach($data as $row){
				$sheet->setCellValue('A'.$i, $row['hd_sales_inv']); 
				$sheet->setCellValue('B'.$i, $row['hd_sales_date']); 
				$sheet->setCellValue('C'.$i, $row['customer_name']);
				$sheet->setCellValue('D'.$i, $row['payment_name']); 
				$sheet->setCellValue('E'.$i, $row['ekspedisi_name']); 
				$sheet->setCellValue('F'.$i, $row['product_name']);
				$sheet->setCellValue('G'.$i, $row['unit_name']);
				$sheet->setCellValue('H'.$i, $row['dt_sales_qty']); 
				$sheet->setCellValue('I'.$i, $row['dt_sales_price']); 
				$sheet->setCellValue('J'.$i, $row['dt_sales_total']); 
                $sheet->setCellValue('K'.$i, $row['hd_sales_top']); 
                $sheet->setCellValue('L'.$i, $row['salesman_name']); 
                $sheet->setCellValue('M'.$i, $row['hd_sales_prepare']); 
                $sheet->setCellValue('N'.$i, $row['hd_sales_colly']); 
                $sheet->setCellValue('O'.$i, $row['warehouse_name']); 
                $sheet->setCellValue('P'.$i, $row['hd_sales_sub_total']); 
                $sheet->setCellValue('Q'.$i, $row['hd_sales_total_discount']); 
                $sheet->setCellValue('R'.$i, $row['hd_sales_ppn']); 
                $sheet->setCellValue('S'.$i, $row['hd_sales_total']); 
                $sheet->setCellValue('T'.$i, $row['hd_sales_note']); 
                $sheet->setCellValue('U'.$i, $row['user_name']); 
				$i++;
			};

			$sheet->getColumnDimension('A')->setWidth(35); 
			$sheet->getColumnDimension('B')->setWidth(25); 
			$sheet->getColumnDimension('C')->setWidth(25);
			$sheet->getColumnDimension('D')->setWidth(25);
			$sheet->getColumnDimension('E')->setWidth(25);
			$sheet->getColumnDimension('F')->setWidth(40);
			$sheet->getColumnDimension('G')->setWidth(25);
			$sheet->getColumnDimension('H')->setWidth(20);
			$sheet->getColumnDimension('I')->setWidth(20);
			$sheet->getColumnDimension('J')->setWidth(20);
            $sheet->getColumnDimension('K')->setWidth(30);
            $sheet->getColumnDimension('L')->setWidth(35);
            $sheet->getColumnDimension('M')->setWidth(30);
            $sheet->getColumnDimension('N')->setWidth(20);
            $sheet->getColumnDimension('O')->setWidth(30);
            $sheet->getColumnDimension('P')->setWidth(30);
            $sheet->getColumnDimension('Q')->setWidth(30);
            $sheet->getColumnDimension('R')->setWidth(30);
            $sheet->getColumnDimension('S')->setWidth(30);
            $sheet->getColumnDimension('T')->setWidth(30);
            $sheet->getColumnDimension('U')->setWidth(50);
            $sheet->getColumnDimension('U')->setWidth(30);


            $sheet->getStyle('I')->getNumberFormat()->setFormatCode('#,##0');	
            $sheet->getStyle('J')->getNumberFormat()->setFormatCode('#,##0');	
			$sheet->getStyle('P')->getNumberFormat()->setFormatCode('#,##0');	
			$sheet->getStyle('Q')->getNumberFormat()->setFormatCode('#,##0');	
			$sheet->getStyle('R')->getNumberFormat()->setFormatCode('#,##0');	
			$sheet->getStyle('S')->getNumberFormat()->setFormatCode('#,##0');	


			$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
			$sheet->setTitle("Excell");
			ob_end_clean();
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="sales_revisi_' .date('Y-m-d') . '.xlsx"');
			header('Cache-Control: max-age=0');

			$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($excel, 'Xlsx');
			$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
			exit($xlsxWriter->save('php://output'));
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}
    // End Report Sales


	// Report Revisi Sales
    public function reportretursales()
	{
		$modul = 'Report';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$customer_list['customer_list'] = $this->masterdata_model->customer_list();
            $salesman_list['salesman_list'] = $this->masterdata_model->salesman_list();
            $warehouse_list['warehouse_list'] = $this->masterdata_model->warehouse_list();
			$data['data'] = array_merge($customer_list, $salesman_list, $warehouse_list);
			$this->load->view('Pages/Report/Sales/reportretursales', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}
    
    public function reportretursalespdf()
    {
        $start_date       = $this->input->get('start_date');
		$end_date 	      = $this->input->get('end_date');
		$customer_report  = $this->input->get('customer_report');

		$data['data'] = $this->reportsales_model->get_report_retur_sales($start_date, $end_date, $customer_report)->result_array();
		$htmlView   = $this->load->view('Pages/Report/Sales/reportretursalespdf', $data, true);
		$dompdf = new Dompdf();
		$dompdf->loadHtml($htmlView);
		$dompdf->setPaper('A4', 'landscape');
		$dompdf->render();
		$dompdf->stream('pembelian.pdf', array("Attachment" => false));
		exit();
    }

	public function reportretursales_excell()
	{
		$modul = 'Report';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$start_date       = $this->input->get('start_date');
			$end_date 	      = $this->input->get('end_date');
		    $customer_report  = $this->input->get('customer_report');

			$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
			$sheet = $excel->getActiveSheet();
			$sheet->setCellValue('A1', "Laporan Retur Penjualan"); 
			$sheet->mergeCells('A1:O1');
			$sheet->getStyle('A1')->getFont()->setBold(true);
			$sheet->getStyle('A3:O3')->getFont()->setBold(true);
			$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
			$sheet->getStyle('A3:O3')->getAlignment()->setHorizontal('center');
			$sheet->setCellValue('A3', "Invoice"); 
			$sheet->setCellValue('B3', "Tanggal"); 
			$sheet->setCellValue('C3', "Pelanggan"); 
            $sheet->setCellValue('D3', "Nama Barang");
            $sheet->setCellValue('E3', "Satuan");
            $sheet->setCellValue('F3', "Qty");
            $sheet->setCellValue('G3', "Harga");
            $sheet->setCellValue('H3', "Total Harga Barang");
			$sheet->setCellValue('I3', "Catatan Barang");
            $sheet->setCellValue('J3', "Total");
			$sheet->setCellValue('K3', "Status Retur");
			$sheet->setCellValue('L3', "Jenis Pembayaran");
            $sheet->setCellValue('M3', "Catatan");
            $sheet->setCellValue('N3', "Di Buat Oleh");

			$data = $this->reportsales_model->get_report_retur_sales($start_date, $end_date, $customer_report, $salesman_report, $warehouse_report)->result_array();
			$i = 4;

			foreach($data as $row){
				$sheet->setCellValue('A'.$i, $row['hd_retur_sales_inv']); 
				$sheet->setCellValue('B'.$i, $row['hd_retur_sales_date']); 
				$sheet->setCellValue('C'.$i, $row['customer_name']);
				$sheet->setCellValue('D'.$i, $row['product_name']); 
				$sheet->setCellValue('E'.$i, $row['unit_name']); 
				$sheet->setCellValue('F'.$i, $row['dt_retur_sales_qty']);
				$sheet->setCellValue('G'.$i, $row['dt_retur_sales_price']);
				$sheet->setCellValue('H'.$i, $row['dt_retur_sales_total']);
				$sheet->setCellValue('I'.$i, $row['dt_retur_sales_note']); 
				$sheet->setCellValue('J'.$i, $row['hd_retur_sales_total']);
                $sheet->setCellValue('K'.$i, $row['hd_retur_sales_status']); 
				if($row['hd_retur_sales_payment_type'] == 'PN'){
                	$sheet->setCellValue('L'.$i, 'Potong Nota'); 
				}else{
                	$sheet->setCellValue('L'.$i, 'Cash'); 
				}
                $sheet->setCellValue('M'.$i, $row['hd_retur_sales_note']); 
                $sheet->setCellValue('N'.$i, $row['user_name']); 
				$i++;
			};

			$sheet->getColumnDimension('A')->setWidth(35); 
			$sheet->getColumnDimension('B')->setWidth(25); 
			$sheet->getColumnDimension('C')->setWidth(35);
			$sheet->getColumnDimension('D')->setWidth(35);
			$sheet->getColumnDimension('E')->setWidth(25);
			$sheet->getColumnDimension('F')->setWidth(20);
			$sheet->getColumnDimension('G')->setWidth(30);
			$sheet->getColumnDimension('H')->setWidth(30);
			$sheet->getColumnDimension('I')->setWidth(45);
			$sheet->getColumnDimension('J')->setWidth(30);
            $sheet->getColumnDimension('K')->setWidth(30);
            $sheet->getColumnDimension('L')->setWidth(30);
            $sheet->getColumnDimension('M')->setWidth(45);
            $sheet->getColumnDimension('N')->setWidth(30);


            $sheet->getStyle('G')->getNumberFormat()->setFormatCode('#,##0');	
            $sheet->getStyle('H')->getNumberFormat()->setFormatCode('#,##0');	
			$sheet->getStyle('J')->getNumberFormat()->setFormatCode('#,##0');


			$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
			$sheet->setTitle("Excell");
			ob_end_clean();
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="laporan_retur_sales_' .date('Y-m-d') . '.xlsx"');
			header('Cache-Control: max-age=0');

			$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($excel, 'Xlsx');
			$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
			exit($xlsxWriter->save('php://output'));
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}
    // End Report Sales

	// Report Retur Sales

	
	// End report Retur Sales

}

?>