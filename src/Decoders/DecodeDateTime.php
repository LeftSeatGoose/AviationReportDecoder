<?php
namespace ReportDecoder\Decoders;

use ReportDecoder\Decoders\Decoder;

class DecodeDateTime extends Decoder {
    public function getExpression() {
        return '/^([0-9]{2})([0-9]{2})([0-9]{2})Z/';
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
            'name' => 'datetime',
            'result' => $result,
            'report' => $report,
        );
    }
}
?>