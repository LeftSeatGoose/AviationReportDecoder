<?php
namespace ReportDecoder;

require dirname(__DIR__) . '/vendor/autoload.php';

use ReportDecoder\TypeDecoder\MetarDecoder;
use ReportDecoder\TypeDecoder\TafDecoder;
use ReportDecoder\Decoders\DecodeType;

$i = new ReportDecoder();
$i->parse('METAR AMD CYBW 270100Z AUTO 28014G19KT 180V250 9SM R17L/2600FT/U +TSRA BR OVC010CB 03/M09 A2948 RMK SLP036');

class ReportDecoder {

    private $error_reporting = true;

    private $report_chunks = array();
    private $decoder = null;
    private $raw_report = null;
    private $clean_report = null;
    private $report_type = 'metar'; // Assume metar by default
    
    public function parse($raw_report) {
        $this->raw_report = $raw_report;

        $clean_report = trim(strtoupper($raw_report));
        $clean_report = preg_replace('#=$#', '', $clean_report);
        $clean_report = preg_replace('#[ ]{2,}#', ' ', $clean_report).' ';
        $this->clean_report = $clean_report;

        $type_decoder = new DecodeType();

        $parse_attempt = $type_decoder->parse($clean_report);
        if(!is_null($parse_attempt['result'])) {
            $this->report_chunks['type'] = $parse_attempt['result'];
            $clean_report = $parse_attempt['report'];
            
            if(strpos(strtolower($parse_attempt['result']), 'taf') !== false) {
                $this->report_type = 'taf';
            }
        }

        if($this->report_type == 'metar') {
            $this->decoder = new MetarDecoder();
        } else {
            $this->decoder = new TafDecoder();
        }

        $this->report_chunks = array_merge($this->report_chunks, $this->decoder->consume($clean_report));

        echo json_encode($this->report_chunks);
    }

}
?>