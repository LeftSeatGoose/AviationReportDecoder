<?php
namespace ReportDecoder\Decoders;

use ReportDecoder\Decoders\Decoder;

class DecodeTemp extends Decoder {
    public function getExpression() {
        return '/^(M?[0-9]{2})\/(M?[0-9]{2})?/';
    }

    public function parse($report) {
        $result = $this->match_chunk($report);
        $match = $result['match'];
        $report = $result['report'];
        
        if(!$match) {
            $result = null;
        } else {
            $result = array(
                'text' => $match[0],
                'temp' => str_replace('M', '-', $match[1]),
                'due' => str_replace('M', '-', $match[2])
            );
        }

        return array(
            'name' => 'temp',
            'result' => $result,
            'report' => $report,
        );
    }
}
?>