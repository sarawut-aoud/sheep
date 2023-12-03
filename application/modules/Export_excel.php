<?php
require_once APPPATH . '/third_party/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (!defined('BASEPATH'))  exit('No direct script access allowed');

/**
 * [ Controller File name : Users.php ]
 */
class Export_excel extends CRUD_Controller
{
	private $per_page;
	private $another_js;
	private $another_css;

	public function __construct()
	{
		parent::__construct();
		check_lang();
		$this->load->model('hrm/Payroll_model', 'Payroll');
		if (empty($this->session->userdata('company_id')) && empty($this->session->userdata('pd_id'))) {
			redirect('gmember');
		}
	}

	/**
	 * Render this controller page
	 * @param String path of controller
	 * @param Integer total record
	 */
	protected function render_view($path)
	{
		$this->data['top_navbar'] = $this->parser->parse('template/geerang/top_navbar_view', $this->top_navbar_data, TRUE);
		$this->data['left_sidebar'] = $this->parser->parse('template/geerang/left_sidebar_view', $this->left_sidebar_data, TRUE);
		$this->data['breadcrumb_list'] = $this->parser->parse('template/geerang/breadcrumb_view', $this->breadcrumb_data, TRUE);
		$this->data['page_content'] = $this->parser->parse_repeat($path, $this->data, TRUE);
		$this->data['another_css'] = $this->another_css;
		$this->data['another_js'] = $this->another_js;
		$this->parser->parse('template/geerang/homepage_view', $this->data);
	}

	public function loadAllEmpDetail()
	{
		$result = $this->Payroll->getEmployeeList(null);
		echo json_encode($result);
	}

	public function export_template_payroll($spreadsheet, $data_pd)
	{
		$employeeList = self::setEmployeeListToArr();

		// $spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0);
		$sheet = $spreadsheet->getActiveSheet();
		$start_at = 2;


		$sheet->setCellValue('A1', 'pay_date')
			->setCellValue('B1', 'titlename')
			->setCellValue('C1', 'name')
			->setCellValue('D1', 'surname')
			->setCellValue('E1', 'idcard')
			->setCellValue('F1', 'salary')
			->setCellValue('G1', 'tax')
			->setCellValue('H1', 'pay_support')
			->setCellValue('I1', 'address')
			->setCellValue('J1', 'bank_id')
			->setCellValue('K1', 'bank_name')
			->setCellValue('L1', 'base_salary')
			->setCellValue('M1', 'deduct_early')
			->setCellValue('N1', 'deduct_absent')
			->setCellValue('O1', 'deduct_late')
			->setCellValue('P1', 'income_sumsso')
			->setCellValue('Q1', 'income_sumtax')
			->setCellValue('R1', 'outcome_sumsso')
			->setCellValue('S1', 'outcome_sumtax');

		foreach ($sheet->getColumnIterator() as $column) {
			$sheet->getColumnDimension($column->getColumnIndex())->setWidth(20);
		}

		foreach ($data_pd as $key => $value) {
			$sheet->setCellValue('B' . ($start_at + $key), $employeeList[$value]->title)
				->setCellValue('C' . ($start_at + $key), $employeeList[$value]->first_name)
				->setCellValue('D' . ($start_at + $key), $employeeList[$value]->last_name)
				->setCellValue('J' . ($start_at + $key), $employeeList[$value]->bank_id)
				->setCellValue('K' . ($start_at + $key), $employeeList[$value]->bank_name);
			// $sheet->setCellValue('E' . ($start_at + $key), $pd_arr[$data_pd[1]]->id_card);

			$sheet
				->getCell('E' . ($start_at + $key))
				->setValueExplicit(
					$employeeList[$value]->id_card,
					\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2
				);
		}

		$sheet->getStyle('A1:R1')->getAlignment()->setHorizontal('center');
	}

	public function read_payroll_excel()
	{
		try {
			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

			$spreadsheet = $reader->load($_FILES['excel']['tmp_name']);
			$sheetCount = $spreadsheet->getSheetCount();

			$sum_payroll = [];
			$month_payroll = [];
			$header_payroll = [];
			$title_payroll = [];

			for ($i = 0; $i < $sheetCount; $i++) {
				$sheet = $spreadsheet->getSheet($i);
				// $sheetData = $sheet->toArray(null, true, true, true);
				$sheetData = $sheet->toArray();
				if ($i == 0) {


					/** first sheet */
					$header_s1 = array_shift($sheetData);
					$sum_payroll[] = $sheetData;
				} else {
					/** another sheet */
					array_shift($sheetData);
					$key = array_shift($sheetData);
					array_shift($sheetData);
					$header = array_shift($sheetData);
					$check = self::checkCorrectKeygen($key[0], $header, $sheet->getTitle());

					if (!$check['isSucces']) throw new Exception($check["message"]);

					$header_payroll[] = $header;
					$month_payroll[] = $sheetData;
					$title_payroll[] = $sheet->getTitle();
				}
			}


			if (!empty($sum_payroll) && !empty($month_payroll)) {
				echo json_encode([
					'status' => true,
					'sum' => $sum_payroll,
					'month' => $month_payroll,
					'header' => $header_payroll,
					'title' => $title_payroll
				]);
			}
		} catch (Exception $e) {
			echo json_encode([
				'status' => false,
				'msg'	 => $e->getMessage(),
			]);
		}
	}

	public function checkCorrectKeygen($key, $head, $sheetName)
	{
		try {

			$key_gen = explode(':', $key)[1];
			$query = $this->db->get_where('geerang_hrm.payroll_import_generate', ['generate_key' => $key_gen]);
			if ($query->num_rows() > 0) {
				$result = $query->row();

				$field_set = unserialize($result->field_set);

				$err = 0;
				for ($i = 3; $i <= sizeof($field_set); $i++) {
					if ($field_set[$i] != $head[$i]) {
						$err++;
					}
				}

				if ($err > 0) throw new Exception("sheet " . $sheetName . " field doesn't match!");
			} else {
				throw new Exception("sheet " . $sheetName . " key doesn't correct!");
			}

			return ['isSucces' => true, 'message' => []];
		} catch (Exception $e) {
			return ['isSucces' => false, 'message' => $e->getMessage()];
		}
	}

	public function importPayrollTax()
	{
		$post = $this->input->post(NULL, TRUE);
		$result = $this->Payroll->importPayrollTax($post);

		$json = json_encode($result);
		echo $json;
	}

	public function excelColumnRange($lower, $upper)
	{
		++$upper;
		for ($i = $lower; $i !== $upper; ++$i) {
			yield $i;
		}
	}

	public function setEmployeeListToArr()
	{
		$result = $this->Payroll->getEmployeeList(null);
		$title = ['', 'นาย', 'นาง', 'นางสาว'];
		$pd_arr = [];
		foreach ($result as $key => $value) {
			$pd_arr[$value->pd_id] = (object) [
				'employee_code' => $value->employee_code,
				'title' => $title[$value->title],
				'first_name' => $value->first_name,
				'last_name' => $value->last_name,
				'id_card' => $value->id_card,
				'bank_id' => $value->bank_id,
				'bank_name' => $value->bank_name,
			];
		}
		return $pd_arr;
	}

	public function export_payroll()
	{
		$alphabet = [];
		$arr_header = ['รหัสพนักงาน', 'G ID', 'รายชื่อพนักงาน', 'วัน', 'ชม.', 'สาย', 'ขาดงาน', 'ลาไม่รับค่าจ้าง', 'ออกก่อน', '1', '1.5', '2', '2.5', '3', 'เงินเดือน', 'เบี้ยขยัน'];
		$key_gen = bin2hex(random_bytes(32));

		$data = $this->input->get(null, true);

		$start_at = 5; //name start at row
		$income = 16; //start at
		$outcome = $income + sizeof($data['income']) + 6; //start at (5) is fixed outcome
		$last = $income + sizeof($data["income"]) + 6 + sizeof($data["outcome"]) + 1;
		$spreadsheet = new Spreadsheet();

		foreach (self::excelColumnRange('A', 'CA') as $value) {
			$alphabet[] = $value;
		}

		$employeeList = self::setEmployeeListToArr();

		self::export_template_payroll($spreadsheet, $data['data_pd']);

		$payroll_month = $data["payroll_month"];

		for ($i = 1; $i <= sizeof($payroll_month); $i++) {
			$spreadsheet->createSheet();
			$spreadsheet->setActiveSheetIndex($i)
				->mergeCells('A3:A4')
				->mergeCells('B3:B4')
				->mergeCells('C3:C4')
				->mergeCells('D3:I3')
				->mergeCells('J3:N3')
				->mergeCells('O3:' . $alphabet[$income + sizeof($data['income']) - 1] . '3') //
				->mergeCells($alphabet[$income + sizeof($data['income']) + 1] . '3:' . $alphabet[$outcome + sizeof($data['outcome']) - 1] . '3')
				->mergeCells('A2:' . $alphabet[$last] . '2')
				->mergeCells('A1:' . $alphabet[$last] . '1');



			$spreadsheet->getActiveSheet()->setTitle($payroll_month[$i - 1]);

			$sheet = $spreadsheet->getActiveSheet();
			/** Set value */
			$sheet->getCell('A1')
				->setValue('งวดเงินเดือนประจำเดือนที่ ' . $payroll_month[$i - 1]);

			$sheet->getCell('A2')
				->setValue('Key:' . $key_gen);

			$sheet->getCell('A3')
				->setValue('รหัสพนักงาน');

			$sheet->getCell('B3')
				->setValue('G ID');

			$sheet->getCell('C3')
				->setValue('รายชื่อพนักงาน');

			$sheet->getCell('D3')
				->setValue('ประสิทธิภาพ');

			$sheet->getCell('J3')
				->setValue('OT');

			$sheet->getCell('O3')
				->setValue('รายได้');

			$sheet->getCell($alphabet[$income + sizeof($data['income']) + 1] . '3')
				->setValue('รายหัก');

			$sheet->setCellValue('D4', 'วัน')
				->setCellValue('E4', 'ชม.')
				->setCellValue('F4', 'สาย')
				->setCellValue('G4', 'ขาดงาน')
				->setCellValue('H4', 'ลาไม่รับค่าจ้าง')
				->setCellValue('I4', 'ออกก่อน')
				->setCellValue('J4', '1')
				->setCellValue('K4', '1.5')
				->setCellValue('L4', '2')
				->setCellValue('M4', '2.5')
				->setCellValue('N4', '3')
				->setCellValue('O4', 'เงินเดือน')
				->setCellValue('P4', 'เบี้ยขยัน')
				->setCellValue($alphabet[$income + sizeof($data['income'])] . '3', 'รวมรายได้')
				->setCellValue($alphabet[$income + sizeof($data['income']) + 1] . '4', 'หักออกก่อน')
				->setCellValue($alphabet[$income + sizeof($data['income']) + 2] . '4', 'หักขาดงาน')
				->setCellValue($alphabet[$income + sizeof($data['income']) + 3] . '4', 'หักลาไม่รับค่าจ้าง')
				->setCellValue($alphabet[$income + sizeof($data['income']) + 4] . '4', 'ภาษี')
				->setCellValue($alphabet[$income + sizeof($data['income']) + 5] . '4', 'ประกันสังคม')
				->setCellValue($alphabet[$outcome + sizeof($data['outcome'])] . '3', 'รวมรายหัก')
				->setCellValue($alphabet[$outcome + sizeof($data['outcome']) + 1] . '3', 'เงินได้สุทธิ');



			foreach ($data['income'] as $key => $value) {
				$sheet->setCellValue($alphabet[$income + $key] . '4', $value);

				if ($i == 1) $arr_header[] = $value;
			}

			if ($i == 1) {
				$arr_header[] = '';
				$arr_header[] = 'หักออกก่อน';
				$arr_header[] = 'หักขาดงาน';
				$arr_header[] = 'หักลาไม่รับค่าจ้าง';
				$arr_header[] = 'ภาษี';
				$arr_header[] = 'ประกันสังคม';
			}

			foreach ($data['outcome'] as $key => $value) {
				$sheet->setCellValue($alphabet[$outcome + $key] . '4', $value);

				if ($i == 1) $arr_header[] = $value;
			}

			if ($i == 1) {
				$insert = [];
				$insert = [
					'com_id' => $this->session->userdata('company_id'),
					'generate_key' => $key_gen,
					'field_set' => serialize($arr_header),
				];

				$this->db->insert('geerang_hrm.payroll_import_generate', $insert);
			}

			foreach ($data['data_pd'] as $key => $value) {
				$sheet->setCellValue('A' . ($start_at + $key), $employeeList[$value]->employee_code);
				$sheet->setCellValue('B' . ($start_at + $key), $value);
				$sheet->setCellValue('C' . ($start_at + $key), $employeeList[$value]->first_name . ' ' . $employeeList[$value]->last_name);
			}

			foreach ($sheet->getColumnIterator() as $column) {
				$sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
			}

			$sheet->getStyle('A1:' . $alphabet[$last] . (4 + sizeof($data['data_pd'])))->getAlignment()->setHorizontal('center');
		}

		$writer = new Xlsx($spreadsheet);

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="payroll_template.xlsx"');
		ob_end_clean();
		$writer->save('php://output');
	}
}