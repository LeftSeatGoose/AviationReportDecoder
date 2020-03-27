<?php
namespace ReportDecoder\Decoders;

use ReportDecoder\Decoders\Decoder;
use ReportDecoder\Exceptions\DecoderException;

class DecodeReporter extends Decoder {
    public function getExpression() {
        return '/^([A-Z]+)/';
    }

    public function parse($report) {
        $result = $this->match_chunk($report);
        $match = $result['match'];
        $report = $result['report'];
        
        if(!$match) {
            $result = null;
        } else {
            $reporter = $match[0];

            if(strlen($reporter) > 3 && strtolower($reporter) !== 'auto') {
                throw new DecoderException($report, $result['report'], 'Bad format for reporter information', $this);
            }

            $result = $match[0];
        }

        return array(
            'name' => 'reporter',
            'result' => $result,
            'report' => $report,
        );
    }
}
?>