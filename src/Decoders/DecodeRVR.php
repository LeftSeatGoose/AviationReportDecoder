<?php
namespace ReportDecoder\Decoders;

use ReportDecoder\Decoders\Decoder;

class DecodeRVR extends Decoder {
    public function getExpression() {
        return '/R([0-9]{2}[LCR]?)\/([PM]?([0-9]{4})V)?[PM]?([0-9]{4})(FT)?\/?([UDN]?)/';
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
                'runway' => $match[1],
                'distance' => $match[4],
                'unit' => $match[5],
                'trend' => $match[6]
            );
        }

        return array(
            'name' => 'rvr',
            'result' => $result,
            'report' => $report,
        );
    }
}
?>