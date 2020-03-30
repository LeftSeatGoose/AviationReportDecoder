<?php
namespace ReportDecoder;

require dirname(__DIR__) . '/vendor/autoload.php';

use ReportDecoder\TypeDecoder\MetarDecoder;
use ReportDecoder\TypeDecoder\TafDecoder;
use ReportDecoder\Decoders\DecodeType;
use ReportDecoder\Entity\DecodedMetar;

$i = new ReportDecoder();
$i->parse('METAR AMD CYBW 270100Z AUTO 28014G19KT 180V250 9SM R17L/M1000VM2600FT/U +TSRA BR BKN010 OVC005 03/M09 A2948 RMK SLP036');

class ReportDecoder {

    private $error_reporting = true;

    private $decoder = null;
    private $decoded = null;
    private $raw_report = null;
    private $clean_report = null;

    private $report_type = 'metar'; // Assume metar by default
    
    public function parse($raw_report) {
        $this->raw_report = $raw_report;
        $this->decoded = new DecodedMetar($raw_report);

        $clean_report = trim(strtoupper($raw_report));
        $clean_report = preg_replace('#=$#', '', $clean_report);
        $clean_report = preg_replace('#[ ]{2,}#', ' ', $clean_report).' ';
        $this->clean_report = $clean_report;

        $type_decoder = new DecodeType();

        $parse_attempt = $type_decoder->parse($clean_report, $this->decoded);
        if(!is_null($parse_attempt['result'])) {
            $this->report_chunks['type'] = $parse_attempt['result'];
            $clean_report = $parse_attempt['report'];
            
            if(strpos(strtolower($parse_attempt['result']), 'taf') !== false) {
                $this->report_type = 'taf';
            }
        }

        if($this->report_type == 'metar') {
            $metar = new MetarDecoder($this->decoded);
            $this->decoder = $metar->consume($clean_report);
        } else {
            $taf = new TafDecoder($this->decoded);
            $this->decoder = $taf->consume($clean_report);
        }
    }

}
?>