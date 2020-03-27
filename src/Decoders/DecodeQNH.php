<?php
namespace ReportDecoder\Decoders;

use ReportDecoder\Decoders\Decoder;
use ReportDecoder\Entity\Value;

class DecodeQNH extends Decoder {

    private static $units = array(
        'A' => Value::UNIT_INHG,
        'Q' => Value::UNIT_HPA
    );

    public function getExpression() {
        return '/^(Q|A)([0-9]{4})/';
    }

    public function parse($report) {
        $result = $this->match_chunk($report);
        $match = $result['match'];
        $report = $result['report'];
        
        if(!$match) {
            throw new DecoderException($report, $result['report'], 'Bad format for pressure information', $this);
        } else {
            $pressure = $match[2];

            if($match[1] == 'A') {
                $pressure = $pressure / 100;
            }

            $result = array(
                'text' => $match[0],
                'unit' => Value::toInt($match[1]),
                'pressure' => $pressure
            );
        }

        return array(
            'name' => 'pressure',
            'result' => $result,
            'report' => $report,
        );
    }
}
?>