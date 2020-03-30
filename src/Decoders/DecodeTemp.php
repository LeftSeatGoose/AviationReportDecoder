<?php
namespace ReportDecoder\Decoders;

use ReportDecoder\Decoders\Decoder;
use ReportDecoder\Entity\Value;

class DecodeTemp extends Decoder {
    public function getExpression() {
        return '/^(M?[0-9]{2})\/(M?[0-9]{2})?/';
    }

    public function parse($report, &$decoded) {
        $result = $this->match_chunk($report);
        $match = $result['match'];
        $report = $result['report'];
        
        if(!$match) {
            $result = null;
        } else {
            $result = $match[0];

            $decoded->setAirTemperature(Value::toInt($match[1]));
            $decoded->setDewPointTemperature(Value::toInt($match[2]));
        }

        return array(
            'name' => 'temp',
            'result' => $result,
            'report' => $report,
        );
    }
}
?>