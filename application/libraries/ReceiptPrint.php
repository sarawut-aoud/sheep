<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// IMPORTANT - Replace the following line with your path to the escpos-php autoload script
require_once __DIR__ . '/../../vendor/autoload.php';

use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\Printer;

class ReceiptPrint
{

    private $CI;
    private $connector;
    private $printer;

    // TODO: printer settings
    // Make this configurable by printer (32 or 48 probably)
    private $printer_width = 32;

    function __construct()
    {
        $this->CI = &get_instance(); // This allows you to call models or other CI objects with $this->CI->... 
    }

    function connect($ip_address, $port = null)
    {
        if ($port) {
            $this->connector = new NetworkPrintConnector($ip_address, $port);
        } else {
            $this->connector = new NetworkPrintConnector($ip_address);
        }
        $this->printer = new Printer($this->connector);
    }

    private function check_connection()
    {
        if (!$this->connector or !$this->printer or !is_a($this->printer, 'Mike42\Escpos\Printer')) {
            throw new Exception("Tried to create receipt without being connected to a printer.");
        }
    }

    public function close_after_exception()
    {
        if (isset($this->printer) && is_a($this->printer, 'Mike42\Escpos\Printer')) {
            $this->printer->close();
        }
        $this->connector = null;
        $this->printer = null;
        $this->emc_printer = null;
    }

    // Calls printer->text and adds new line
    private function add_line($text = "", $should_wordwrap = true)
    {
        $text = $should_wordwrap ? wordwrap($text, $this->printer_width) : $text;
        $this->printer->text($text . "\n");
    }


    public function print_test_receipt($text = "")
    {

        $this->check_connection();
        $this->printer->setJustification(Printer::JUSTIFY_CENTER);
        $this->printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
        $this->add_line("TESTING");
        $this->add_line("Receipt Print");
        $this->printer->selectPrintMode();
        $this->add_line(); // blank line
        $this->add_line($text);
        $this->add_line(); // blank line
        $this->add_line(date('Y-m-d H:i:s'));
        $this->printer->cut(Printer::CUT_PARTIAL);
        $this->printer->close();
    }
}
