<?php
namespace ReportDecoder\Decoders;

use ReportDecoder\Decoders\Decoder;
use ReportDecoder\Exceptions\DecoderException;

class DecodeVisibility extends Decoder {
    public function getExpression() {
        return '/^(CAVOK|([0-9]{4})(NDV)?|M?([0-9]{0,2}) ?(([1357])\/(2|4|8|16))?SM|( ([0-9]{4})(N|NE|E|SE|S|SW|W|NW)?)?|([0-9][05])(KM)?(NDV)?)/';
    }

    public function parse($report) {
        $result = $this->match_chunk($report);
        $match = $result['match'];
        $report = $result['report'];
        
        if(!$match) {
            throw new DecoderException($report, $result['report'], 'Bad format for visiblity information', $this);
        } else {
            $cavok = false;

            if(strtolower($match[0]) == 'cavok') {
                $result = array(
                    'cavok' => true
                );
            } else {
                $result = array(
                    'cavok' => false,
                    'distance' => $match[0]
                );
            }
        }

        return array(
            'name' => 'visibility',
            'result' => $result,
            'report' => $report,
        );
    }
}
?>