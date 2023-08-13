<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

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
            $post = $this->input->post(NULL, false);
        } else {
            $post = $this->input->get(NULL, false);
        }
        $id = urldecode(decrypt($post->encrypt_id));
        $$orientation = $post->page ? $post->page : "";



        // $status_document = $this->db->
        $message = ob_get_contents();
        $filename = 'รายงานข้อมูลการซื้อ-ขาย';
        $header = "รายงานข้อมูลการซื้อ-ขาย";
        $message = $this->parser->parse('reports/pdf', $this->data, TRUE);


        $message = preg_replace('/<a class="(.*?)">(.*?)<\/a>/', '<p class="$1">$2</p>', $message); //สำหรับเปลี่ยน tag a เป็น p เพราะ mpdf ไม่รองรับสีตัวอักษรบน tag a
        $message = preg_replace('/<label class="(.*?)">(.*?)<\/label>/', '<span>$2</span>', $message); //สำหรับเปลี่ยน tag label เป็น span เพราะ mpdf ไม่รองรับการจัดตำแหน่ง inline

        $this->header = '<table style="margin-top:0;padding:0 35px; width:100%">
                        <tr>
                            
                            <td valign="top" style="padding-left:10px;">
                                <span style="font-size:22px; font-weight:bold;">SHEEP Online<br>
                                <span style="font-size:18px; font-weight:bold;"> ________________________<br>
                                <span style="font-size:18px; font-weight:bold;">' . $header . '<br>
                            </td>
                            <td valign="center"  width="80px" style="padding-left:10px;text-align:right;">
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
}
