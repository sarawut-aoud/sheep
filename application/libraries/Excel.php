<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Excel {
	var $objPHPExcel;

	function Excelphp()
	{
		// $CI = & get_instance();

		/** Include PHPExcel */
		require_once APPPATH.'/third_party/Excel/PHPExcel.php';

		// Create new PHPExcel object
//		echo date('H:i:s') , " Create new PHPExcel object" , EOL;
		$this->objPHPExcel = new PHPExcel();

		// Set document properties
//		echo date('H:i:s') , " Set document properties" , EOL;
		$this->objPHPExcel->getProperties()
											// ->setCreator("Maarten Balliauw")
											//  ->setLastModifiedBy("Maarten Balliauw")
											 ->setTitle("PHPExcel Test Document")
											 ->setSubject("PHPExcel Test Document")
											//  ->setDescription("Test document for PHPExcel, generated using PHP classes.")
											//  ->setKeywords("office PHPExcel php")
											//  ->setCategory("Test result file")
											 ;
			// Add some data
			// echo date('H:i:s') , " Add some data" , EOL;
			// $this->objPHPExcel->setActiveSheetIndex(0)
			// 			->setCellValue('A1', 'Hello')
			// 			->setCellValue('B2', 'world!')
			// 			->setCellValue('C1', 'Hello')
			// 			->setCellValue('D2', 'world!');
			//
			// // Miscellaneous glyphs, UTF-8
			// $this->objPHPExcel->setActiveSheetIndex(0)
			// 			->setCellValue('A4', 'Miscellaneous glyphs')
			// 			->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');
	}

	function cellColor($cells, $color) {
		$this->objPHPExcel;

		$this->objPHPExcel
			->getActiveSheet()
			->getStyle($cells)
			->getFill()
			->applyFromArray(
				array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'startcolor' => array(
						'rgb' => $color
					)
				)
			);
	}

	public function addData($data=null)
	{
		$this->objPHPExcel->getActiveSheet()->fromArray($data, NULL, 'A10');
		$this->cellColor('A10:J11', 'F28A8C');

		// Rename worksheet
		echo date('H:i:s') , " Rename worksheet" , EOL;
		$this->objPHPExcel->getActiveSheet()->setTitle(DATE('Y-m-d'));
	}

	public function saveData($filename)
	{
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$this->objPHPExcel->setActiveSheetIndex(0);
		// Save Excel 2007 file
		// echo date('H:i:s') , " Write to Excel2007 format" , EOL;
		// $callStartTime = microtime(true);
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel2007');
		// $objWriter->save(str_replace('.php', '.xlsx', __FILE__));
		// $objWriter->save( str_replace('.php', '.xlsx', './export/'.pathinfo(__FILE__, PATHINFO_BASENAME)) );
		$objWriter->save(APPPATH.'/../export/'.$filename.'.xlsx');
		// $callEndTime = microtime(true);
		// $callTime = $callEndTime - $callStartTime;
		// echo date('H:i:s') , " File written to " , str_replace('.php', '.xlsx', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;
		// echo date('H:i:s') , " File written to " , APPPATH.'/../export/'.$filename.'.xlsx' , EOL;
		// echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;
		// Echo memory usage
		// echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;
	}
}
