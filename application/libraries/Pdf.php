<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'third_party/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

class Pdf
{
    private $dompdf;
    
    public function __construct()
    {
        $this->dompdf = new Dompdf();
    }
    
    public function generate($html, $filename = 'document.pdf', $stream = TRUE)
    {
        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper('A4', 'portrait');
        $this->dompdf->render();
        
        if ($stream) {
            $this->dompdf->stream($filename, array("Attachment" => 1));
        } else {
            return $this->dompdf->output();
        }
    }
    
    public function setPaper($size, $orientation)
    {
        $this->dompdf->setPaper($size, $orientation);
    }
    
    public function load_html($html)
    {
        $this->dompdf->loadHtml($html);
    }
    
    public function render()
    {
        $this->dompdf->render();
    }
    
    public function stream($filename, $options)
    {
        $this->dompdf->stream($filename, $options);
    }
}