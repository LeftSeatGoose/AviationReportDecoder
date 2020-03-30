<?php
namespace ReportDecoder\Decoders;

use ReportDecoder\Decoders\Decoder;
use ReportDecoder\Entity\EntityWind;
use ReportDecoder\Exceptions\DecoderException;

class DecodeWind extends Decoder {
    public function getExpression() {
        return '/^([0-9]{3}|VRB)?([0-9]{2,3})(G?([0-9]{2,3}))?(KT|MPH|MPS|KPH)( ([0-9]{3})V([0-9]{3}))?/';
    }

    public function parse($report, &$decoded) {
        $result = $this->match_chunk($report);
        $match = $result['match'];
        $report = $result['report'];
        
        if(!$match) {
            throw new DecoderException($report, $result['report'], 'Bad format for wind information', $this);
        } else {
            $reporter = $match[0];
            
            $result = array(
                'text' => $match[0],
                'direction' => $match[1],
                'speed' => $match[2],
                'gust' => $match[4],
                'unit' => $match[5]
            );

            $decoded->setSurfaceWind(new EntityWind($result));
        }

        return array(
            'name' => 'wind',
            'result' => $result,
            'report' => $report,
        );
    }
}
?>