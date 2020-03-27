<?php
namespace ReportDecoder\Decoders;

use ReportDecoder\Decoders\Decoder;

class DecodeType extends Decoder {
    
    public function getExpression() {
        return '/^((METAR|TAF|SPECI)( (COR|AMD)){0,1})|((PROV TAF))/';
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
            'name' => 'type',
            'result' => $result,
            'report' => $report,
        );
    }

}
?>