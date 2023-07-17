<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH  . '/third_party/vendor/autoload.php';
class M_pdf
{

	var $mPDF = null;

	function M_pdf()
	{
		$CI = &get_instance();
	}

	function load($param = NULL)
	{

		if ($param == NULL) {
			$this->mPDF = new \Mpdf\Mpdf([
				'mode' => 'utf-8', 'format' => 'A4', 'default_font_size' => '16px', 'autoMarginPadding' => 0, 'bleedMargin' => 0, 'nonPrintMargin' => 0, 'margBuffer' => 0, 'margin_left' => 0, 'margin_right' => 0, 'margin_top' => 0, 'margin_bottom' => 0, 'setAutoTopMargin' => 'stretch', 'setAutoBottomMargin ' => 'stretch', 'default_font' => 'niramit', 'defaultheaderline' => 0, 'defaultfooterline' => 0
			]);
		} else {
			$this->mPDF = new \Mpdf\Mpdf($param);
		}
		// $this->mPDF->useAdobeCJK = false;             
		// $this->mPDF->autoScriptToLang = true;
		// $this->mPDF->autoLangToFont = true; 
	}

	function SetHTMLHeader($message)
	{
		$this->mPDF->SetHTMLHeader($message);
	}

	function SetHTMLFooter($message)
	{
		$this->mPDF->SetHTMLFooter($message);
	}

	function WriteHTML($message)
	{
		$this->mPDF->WriteHTML($message);
	}
	function SetWatermark($message)
	{
		$this->mPDF->SetWatermarkText($message, 0.5);
		$this->mPDF->showWatermarkText = true;
		$this->mPDF->watermark_font = 'FreeSans';
	}
	function SetWatermarkImage($files)
	{
		$this->mPDF->SetWatermarkImage($files);
		$this->mPDF->showWatermarkImage  = true;
	}

	function AppendAttachFile($path, $fileName)
	{
		$this->mPDF->SetImportUse();
		$pagecount = $this->mPDF->SetSourceFile($path . $fileName);
		for ($i = 1; $i <= $pagecount; $i++) {
			$this->mPDF->AddPage();
			$import_page = $this->mPDF->ImportPage($i);
			$this->mPDF->UseTemplate($import_page, 10, 30, 190, 250);
		}
	}

	function Output($pdfFilePath, $op)
	{
		$this->mPDF->Output($pdfFilePath, $op);
	}
}
// - See more at: https://arjunphp.com/generating-a-pdf-in-codeigniter-using-mpdf/#sthash.jNo6TCBd.dpuf