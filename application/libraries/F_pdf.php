<?php if (!defined('BASEPATH')) exit('No direct script access allowed');  
require_once APPPATH  . '/third_party/FPDF/fpdf.php';
require_once APPPATH  . '/third_party/FPDI/fpdi.php';
class F_pdf { 
	public function __construct() { 
		$pdf = new FPDI();
		$pdf->AliasNbPages();   
        $pdf->SetAutoPageBreak(false, 0);  
        $pdf->setSourceFile('/assets/filepdf/repeat.pdf'); 
        $tplIdx = $pdf->importPage(1);          
		// $pdf->useTemplate($tplIdx, 0, 0, 0); 
        $pdf->SetMargins(0, 0, 0, 0);
        $pdf->AddPage('L');
        // $pdf->AliasNbPages();   
        $pdf->SetAutoPageBreak(false, 0);   
        $pdf->AddFont('angsana','','angsa.php');
        $pdf->AddFont('angsana','B','angsab.php');
        $pdf->AddFont('angsana','I','angsai.php');
        $pdf->AddFont('angsana','BI','angsaz.php');  
		$pdf->SetFont('angsana','',14);
		
		$CI =& get_instance();
		$CI->fpdf = $pdf;
		
	}
} 
