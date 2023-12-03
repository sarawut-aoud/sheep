<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . '/third_party/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Reports extends CRUD_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('reports/Report_model', 'report');


        $this->pd_id = $this->session->userdata('pd_id');
        if (!$this->session->userdata('pd_id')) {
            redirect('/home', 'refresh');
        }
        $this->setJs('/assets/lib/pdfjs/pdf.js');
        $this->setJs('/assets/plugins/jszip/jszip.min.js');
        $this->setJs('assets/plugins/pdfmake/pdfmake.min.js');
        $this->setJs('assets/js/vfs_fonts.js');
    }
    public function sale_purchase()
    {
        $this->index();
    }
    public function index()
    {
        $this->setBread(
            ['class' => '', 'ref' => base_url('dashboard'), 'name' => 'หน้าแรก'],
            ['class' => 'active', 'ref' => '#', 'name' => 'รายงานข้อมูลการซื้อ-ขาย']
        );
        $this->setJs('/assets/js_modules/report.js?ft=' . time());
        $this->renderview('reports/view');
    }
    public function sale_purchase_all()
    {
        $this->data['is_admin'] = true;
        $this->setBread(
            ['class' => '', 'ref' => base_url('dashboard'), 'name' => 'หน้าแรก'],
            ['class' => 'active', 'ref' => '#', 'name' => 'รายงานข้อมูลการซื้อ-ขายทั้งหมด']
        );
        $this->setJs('/assets/js_modules/report.js?ft=' . time());
        $this->renderview('reports/preview');
    }
    public function virtualization()
    {
        $this->setBread(
            ['class' => '', 'ref' => base_url('dashboard'), 'name' => 'หน้าแรก'],
            ['class' => 'active', 'ref' => '#', 'name' => 'Data Virtualization']
        );

        $this->setJs('/assets/js/chart.js');
        $this->setJs('/assets/js_modules/virtuali.js?ft=' . time());
        $this->renderview('reports/virtuali');
    }
    public function exportpdf()
    {
        $this->load->library('m_pdf');
        $this->data['m_pdf'] = true;
        if (count($_POST) > 0) {
            $post = (object)$this->input->post(NULL, false);
        } else {
            $post =  (object)$this->input->get(NULL, false);
        }
        $id = urldecode(decrypt($post->encrypt_id));
        $orientation = $post->page ? $post->page : "L";

        $this->data['datestart'] = date('Y-m-d', strtotime($post->date_start));
        $this->data['dateend'] = date('Y-m-d', strtotime($post->date_end));
        $this->data['data'] = $this->report->get_data((object)['data' => ['date_start' => $post->date_start, 'date_end' => $post->date_end]]);

        // $status_document = $this->db->
        $message = ob_get_contents();
        $filename = 'รายงานข้อมูลการซื้อ-ขาย';
        $header = "รายงานข้อมูลการซื้อ-ขาย";
        $message = $this->parser->parse('reports/pdf', $this->data, TRUE);


        $message = preg_replace('/<a class="(.*?)">(.*?)<\/a>/', '<p class="$1">$2</p>', $message); //สำหรับเปลี่ยน tag a เป็น p เพราะ mpdf ไม่รองรับสีตัวอักษรบน tag a
        $message = preg_replace('/<label class="(.*?)">(.*?)<\/label>/', '<span>$2</span>', $message); //สำหรับเปลี่ยน tag label เป็น span เพราะ mpdf ไม่รองรับการจัดตำแหน่ง inline
        $img = FCPATH .  './assets/images/icon.png';
        $this->header = '<table style="margin-top:0;padding:0 35px; width:100%">
                        <tr>
                            <td style="width:10%;vertical-align:middle">
                                <img alt="Image " style="width:100px" src="' . $img . '">
                            </td>
                            <td valign="top" style="width:10%;padding-left:10px;vertical-align:middle">
                                <span style="font-size:22px; font-weight:bold;">แอปพลิเคชันบริหารจัดการข้อมูลแพะคอกกลาง<br>
                                <span style="font-size:18px; font-weight:bold;"> ________________________<br>
                                <span style="font-size:18px; font-weight:bold;">' . $header . '<br>
                            </td>
                            <td class="text-center" style="width:60%;font-size:22px; font-weight:bold;">
                                บัญชีการซื้อขายแพะ - มูลแพะ
                                <br>
                                ระหว่างวันที่ ' . Datethai($post->date_start, '') . '-' . Datethai($post->date_end, '') . '
                            </td>
                            <td valign="center"  style="width:20%;padding-left:10px;text-align:right;">
                                <b>{PAGENO}/ {nb}</b><br>
                            </td>
                              
                        </tr> 
                    </table>  
                    <hr> ';
        // $this->footer = '   <pagebreak>
        //                     <hr>
        //                     <table style="margin-bottom:0;margin-top:0;padding:0 35px; width:100%">
        //                         <tr>
        //                              <td align="left" >
        //                              ' . $companyname->company_name . '
        //                              <br>' . $companyname->address . ' ' . $companyname->location . '  รหัสไปรษณีย์ ' . $companyname->zipcode . '
        //                              <br> โทร : ' .  $companyname->mobile . ' <br>
        //                              </td> 
        //                         </tr>

        //                     </table>';


        ob_clean();
        $this->m_pdf->load([
            'orientation' => $orientation,
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font_size' => '16px',
            'autoMarginPadding' => 0,
            'bleedMargin' => 0,
            'nonPrintMargin' => 0,
            'margBuffer' => 0,
            'margin_left' => 0,
            'margin_right' => 0,
            'margin_top' => 0,
            'margin_bottom' => 15,
            'setAutoTopMargin' => 'stretch',
            'setAutoBottomMargin ' => 'stretch',
            'default_font' => 'niramit',
            'defaultheaderline' => 0,
            'defaultfooterline' => 0,
            'margin_footer' => 0
        ]);

        $this->m_pdf->use_kwt = true;

        $this->m_pdf->SetHTMLHeader($this->header);
        $this->m_pdf->SetHTMLFooter($this->footer);
        $this->m_pdf->WriteHTML($message);
        $pdfFilePath = $filename . ".pdf";
        $this->m_pdf->Output($pdfFilePath, "I");
    }
    public function get_data()
    {
        $post = (object) $this->input->post();
        try {

            $result = $this->report->get_data($post);
            $this->setRes(true, $result, 200);
        } catch (Exception $e) {
            $this->response(__METHOD__);
        }
    }
    public function get_dataReport()
    {
        $post = (object) $this->input->post();
        try {

            $result = $this->report->get_dataReport($post);
            $this->setRes(true, $result, 200);
        } catch (Exception $e) {
            $this->response(__METHOD__);
        }
    }
    public function get_countsheep()
    {
        $post = (object) $this->input->post();

        try {
            $result  = $this->report->get_countsheep($post);
            $this->setRes(true, $result, 200);
        } catch (Exception $e) {
            $this->response(__METHOD__);
        }
    }
    public function get_countsheep_gender()
    {
        $post = (object) $this->input->post();
        try {
            $result  = $this->report->get_countsheep_gender($post);
            $this->setRes(true, $result, 200);
        } catch (Exception $e) {
            $this->response(__METHOD__);
        }
    }
    public function get_sumtotalprice()
    {
        $post = (object) $this->input->post();
        try {
            $result  = $this->report->get_sumtotalprice($post);
            $this->setRes(true, $result, 200);
        } catch (Exception $e) {
            $this->response(__METHOD__);
        }
    }
    public function get_sumprice()
    {
        $post = (object) $this->input->post();
        try {
            $result  = $this->report->get_sumprice($post);
            $this->setRes(true, $result, 200);
        } catch (Exception $e) {
            $this->response(__METHOD__);
        }
    }
    public function exportExcel()
    {
        if (count($_POST) > 0) {
            $post = (object)$this->input->post(NULL, false);
        } else {
            $post =  (object)$this->input->get(NULL, false);
        }
        if (!$post->date_start && !$post->date_end) redirect('/Reports');
        $datestart = date('Y-m-d', strtotime($post->date_start));
        $dateend = date('Y-m-d', strtotime($post->date_end));
        $data = $this->report->get_data((object)['data' => ['date_start' => $post->date_start, 'date_end' => $post->date_end]]);
        $column = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't',];
        $spreadsheet = new Spreadsheet();

        $i = 0;
        $spreadsheet->createSheet();
        $spreadsheet->getActiveSheet()->setTitle('sheet1');
        $spreadsheet->setActiveSheetIndex($i)
            ->mergeCells('A1:V1');
        $spreadsheet->setActiveSheetIndex($i)
            ->mergeCells('A2:A3');
        $spreadsheet->setActiveSheetIndex($i)
            ->mergeCells('B2:B3');
        $spreadsheet->setActiveSheetIndex($i)
            ->mergeCells('C2:F2');
        $spreadsheet->setActiveSheetIndex($i)
            ->mergeCells('G2:J2');
        $spreadsheet->setActiveSheetIndex($i)
            ->mergeCells('K2:N2');
        $spreadsheet->setActiveSheetIndex($i)
            ->mergeCells('O2:R2');
        $spreadsheet->setActiveSheetIndex($i)
            ->mergeCells('S2:U2');
        $spreadsheet->setActiveSheetIndex($i)
            ->mergeCells('V2:V3');


        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle('A1')
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getCell('A1')
            ->setValue('บัญชีการซื้อขายแพะ - มูลแพะประระหว่างวันที่  ' . Datethai($datestart, '') . '-' . Datethai($dateend, ''));

        $sheet->getCell('A2')
            ->setValue('วัน / เดือน / ปี ')->getStyle('A2')
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getCell('B2')
            ->setValue('ชื่อ - สกุล')->getStyle('B2')
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $this->setCell($sheet, 'C2', 'พ่อพันธุ์');
        $this->setCell($sheet, 'C3', 'จำนวน');
        $this->setCell($sheet, 'D3', 'กิโลกรัม');
        $this->setCell($sheet, 'E3', 'ราคา');
        $this->setCell($sheet, 'F3', 'รวม');

        $sheet->getCell('F2')
            ->setValue('แม่พันธุ์')->getStyle('F2')
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $this->setCell($sheet, 'G3', 'จำนวน');
        $this->setCell($sheet, 'H3', 'กิโลกรัม');
        $this->setCell($sheet, 'I3', 'ราคา');
        $this->setCell($sheet, 'J3', 'รวม');

        $sheet->getCell('I2')
            ->setValue('แพะปลด พ่อ แม่')->getStyle('I2')
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $this->setCell($sheet, 'K3', 'จำนวน');
        $this->setCell($sheet, 'L3', 'กิโลกรัม');
        $this->setCell($sheet, 'M3', 'ราคา');
        $this->setCell($sheet, 'N3', 'รวม');

        $sheet->getCell('M2')
            ->setValue('แพะขุน')->getStyle('M2')
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $this->setCell($sheet, 'O3', 'จำนวน');
        $this->setCell($sheet, 'P3', 'กิโลกรัม');
        $this->setCell($sheet, 'Q3', 'ราคา');
        $this->setCell($sheet, 'R3', 'รวม');

        $sheet->getCell('Q2')
            ->setValue('มูลแพะ')->getStyle('Q2')
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $this->setCell($sheet, 'S3', 'จำนวน');
        $this->setCell($sheet, 'T3', 'ราคา');
        $this->setCell($sheet, 'U3', 'รวม');

        $sheet->getCell('V2')
            ->setValue('รวมเงิน')->getStyle('T2')
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);



        for ($index = 0; $index < sizeof($data); $index++) {

            $sumprice[] =  $data[$index]->pricetotal;
            $sum0[] =  $data[$index]->rowdata[0]->amount;
            $sum1[] =  $data[$index]->rowdata[1]->amount;
            $sum2[] =  $data[$index]->rowdata[2]->amount;
            $sum3[] =  $data[$index]->rowdata[3]->amount;
            $sum4[] =  $data[$index]->rowdata[4]->amount;

            $weight0[] = $data[$index]->rowdata[0]->weight;
            $weight1[] = $data[$index]->rowdata[1]->weight;
            $weight2[] = $data[$index]->rowdata[2]->weight;
            $weight3[] = $data[$index]->rowdata[3]->weight;
            $weight4[] = $data[$index]->rowdata[4]->weight;

            $price0[] = $data[$index]->rowdata[0]->price;
            $price1[] = $data[$index]->rowdata[1]->price;
            $price2[] = $data[$index]->rowdata[2]->price;
            $price3[] = $data[$index]->rowdata[3]->price;
            $price4[] = $data[$index]->rowdata[4]->price;



            $total0[] = $data[$index]->rowdata[0]->totlal;
            $total1[] = $data[$index]->rowdata[1]->totlal;
            $total2[] = $data[$index]->rowdata[2]->totlal;
            $total3[] = $data[$index]->rowdata[3]->totlal;
            $total4[] = $data[$index]->rowdata[4]->totlal;

            $this->setCell($sheet, 'A' . (4 + $index), Datethai($data[$index]->saledate, '', true), 'right');

            $this->setCell($sheet, 'B' . (4 + $index), $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name'), 'right');
            $this->setCell($sheet, 'C' . (4 + $index),  $data[$index]->rowdata[0]->amount, 'right');
            $this->setCell($sheet, 'D' . (4 + $index),  $data[$index]->rowdata[0]->weight, 'right');
            $this->setCell($sheet, 'E' . (4 + $index),  $data[$index]->rowdata[0]->price, 'right');
            $this->setCell($sheet, 'F' . (4 + $index),  $data[$index]->rowdata[0]->totlal, 'right');

            $this->setCell($sheet, 'G' . (4 + $index),  $data[$index]->rowdata[1]->amount, 'right');
            $this->setCell($sheet, 'H' . (4 + $index),  $data[$index]->rowdata[1]->weight, 'right');
            $this->setCell($sheet, 'I' . (4 + $index),  $data[$index]->rowdata[1]->price, 'right');
            $this->setCell($sheet, 'J' . (4 + $index),  $data[$index]->rowdata[1]->totlal, 'right');

            $this->setCell($sheet, 'K' . (4 + $index),  $data[$index]->rowdata[2]->amount, 'right');
            $this->setCell($sheet, 'L' . (4 + $index),  $data[$index]->rowdata[2]->weight, 'right');
            $this->setCell($sheet, 'M' . (4 + $index),  $data[$index]->rowdata[2]->price, 'right');
            $this->setCell($sheet, 'N' . (4 + $index),  $data[$index]->rowdata[2]->totlal, 'right');

            $this->setCell($sheet, 'O' . (4 + $index),  $data[$index]->rowdata[3]->amount, 'right');
            $this->setCell($sheet, 'P' . (4 + $index),  $data[$index]->rowdata[3]->weight, 'right');
            $this->setCell($sheet, 'Q' . (4 + $index),  $data[$index]->rowdata[3]->price, 'right');
            $this->setCell($sheet, 'R' . (4 + $index),  $data[$index]->rowdata[3]->totlal, 'right');

            $this->setCell($sheet, 'S' . (4 + $index),  $data[$index]->rowdata[4]->amount, 'right');
            $this->setCell($sheet, 'T' . (4 + $index),  $data[$index]->rowdata[4]->price, 'right');
            $this->setCell($sheet, 'U' . (4 + $index),  $data[$index]->rowdata[4]->totlal, 'right');

            $this->setCell($sheet, 'V' . (4 + $index), $data[$index]->pricetotal, 'right');

            $lastindex = 4 + $index + 1;
        }

        $spreadsheet->setActiveSheetIndex($i)
            ->mergeCells('A' . $lastindex . ':B' . $lastindex);
        $this->setCell($sheet, 'A' . $lastindex, 'ยอดรวม');

        $this->setCell($sheet, 'C' . $lastindex,  array_sum($sum0), 'right');
        $this->setCell($sheet, 'D' . $lastindex,  number_format(array_sum($weight0), 2), 'right');
        $this->setCell($sheet, 'E' . $lastindex,  number_format(array_sum($price0), 2), 'right');
        $this->setCell($sheet, 'F' . $lastindex,  number_format(array_sum($total0), 2), 'right');


        $this->setCell($sheet, 'G' . $lastindex,  array_sum($sum1), 'right');
        $this->setCell($sheet, 'H' . $lastindex,  number_format(array_sum($weight1), 2), 'right');
        $this->setCell($sheet, 'I' . $lastindex,  number_format(array_sum($price1), 2), 'right');
        $this->setCell($sheet, 'J' . $lastindex,  number_format(array_sum($total1), 2), 'right');



        $this->setCell($sheet, 'K' . $lastindex,  array_sum($sum2), 'right');
        $this->setCell($sheet, 'L' . $lastindex,  number_format(array_sum($weight2), 2), 'right');
        $this->setCell($sheet, 'M' . $lastindex,  number_format(array_sum($price2), 2), 'right');
        $this->setCell($sheet, 'N' . $lastindex,  number_format(array_sum($total2), 2), 'right');


        $this->setCell($sheet, 'O' . $lastindex,  array_sum($sum3), 'right');
        $this->setCell($sheet, 'P' . $lastindex,  number_format(array_sum($weight3), 2), 'right');
        $this->setCell($sheet, 'Q' . $lastindex,  number_format(array_sum($price3), 2), 'right');
        $this->setCell($sheet, 'R' . $lastindex,  number_format(array_sum($total3), 2), 'right');

        $this->setCell($sheet, 'S' . $lastindex,  array_sum($sum4), 'right');
        $this->setCell($sheet, 'T' . $lastindex,  number_format(array_sum($price4), 2), 'right');
        $this->setCell($sheet, 'U' . $lastindex,  number_format(array_sum($total4), 2), 'right');

        $this->setCell($sheet, 'V' . $lastindex,  number_format(array_sum($sumprice), 2), 'right');



        $writer = new Xlsx($spreadsheet);

        $writer->save('Real-time Data Management Application for  Goat Collecting Stall.xlsx');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Real-time Data Management Application for  Goat Collecting Stall.xlsx"');
        ob_end_clean();
        $writer->save('php://output');
    }
    private function setCell($sheet, $cell, $text, $style = 'center')
    {
        if (strtolower($style) == 'center') {
            $sheet->getCell($cell)
                ->setValue($text)->getStyle($cell)
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        } else if (strtolower($style) == 'right') {
            $sheet->getCell($cell)
                ->setValue($text)->getStyle($cell)
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        } else if (strtolower($style) == 'left') {
            $sheet->getCell($cell)
                ->setValue($text)->getStyle($cell)
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        }
    }
}
