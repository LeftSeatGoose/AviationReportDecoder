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

    private $decoder = null;
    private $decoded_metar = null;

    public function __construct($decoded_metar) {
        $this->decoded_metar = $decoded_metar;

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
            $parse_attempt = $chunk->parse($report, $this->decoded_metar);
            
            if(is_null($parse_attempt['result'])) continue;

            if($chunk instanceof DecodeVisibility && $parse_attempt['result']['cavok'] !== false) {
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
        
        return $this->decoded_metar;
    }
}
?>