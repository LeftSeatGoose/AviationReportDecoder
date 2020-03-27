<?php
namespace ReportDecoder\Decoders;

use ReportDecoder\Decoders\Decoder;

class DecodeICAO extends Decoder {
    public function getExpression() {
        return '/^([A-Z0-9]{4})/';
    }

    public function parse($report) {
        $result = $this->match_chunk($report);
        $match = $result['match'];
        $report = $result['report'];
        
        if(!$match) {
            $result = null;
        } else {
            $result = $match[0];
        }

        return array(
            'name' => 'icao',
            'result' => $result,
            'report' => $report,
        );
    }
}
?>