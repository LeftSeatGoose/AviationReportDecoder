<?php
namespace ReportDecoder\Decoders;

use ReportDecoder\Decoders\Decoder;

class DecodeRemarks extends Decoder {
    public function getExpression() {
        return '/RMK.*/';
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
            'name' => 'remarks',
            'result' => $result,
            'report' => $report,
        );
    }
}
?>