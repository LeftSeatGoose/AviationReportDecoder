<?php
namespace ReportDecoder\TypeDecoder;

use ReportDecoder\Decoders\DecodeICAO;
use ReportDecoder\Decoders\DecodeDateTime;
use ReportDecoder\Decoders\DecodeReporter;
use ReportDecoder\Decoders\DecodeWind;
use ReportDecoder\Decoders\DecodeVisibility;
use ReportDecoder\Decoders\DecodeRVR;
use ReportDecoder\Decoders\DecodeWeather;
use ReportDecoder\Decoders\DecodeCloud;
use ReportDecoder\Decoders\DecodeTemp;
use ReportDecoder\Decoders\DecodeQNH;
use ReportDecoder\Decoders\DecodeRemarks;

class MetarDecoder {

    protected $decoder = null;
    
    private $cavok = false;

    public function __construct() {
        $this->decoder = array(
            new DecodeICAO(),
            new DecodeDateTime(),
            new DecodeReporter(),
            new DecodeWind(),
            new DecodeVisibility(),
            new DecodeRVR(),
            new DecodeWeather(),
            new DecodeCloud(),
            new DecodeTemp(),
            new DecodeQNH(),
            new DecodeRemarks()
        );
    }

    public function consume($report) {
        foreach($this->decoder as $chunk) {
            $parse_attempt = $chunk->parse($report);
            
            if(is_null($parse_attempt['result'])) continue;

            if($chunk instanceof DecodeVisibility && $parse_attempt['result']['cavok'] !== false) {
                $this->cavok = true;
                $this->report_chunks['visibility'] = 'cavok';
            } else {
                $this->report_chunks[$parse_attempt['name']] = $parse_attempt['result'];
            }
            
            if(!empty($parse_attempt['report'])) {
                $report = $parse_attempt['report'];
            } else {
                break;
            }
        }
        
        return $this->report_chunks;
    }
}
?>