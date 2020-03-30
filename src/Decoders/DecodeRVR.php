<?php
namespace ReportDecoder\Decoders;

use ReportDecoder\Decoders\Decoder;
use ReportDecoder\Entity\EntityRVR;
use ReportDecoder\Entity\Value;

class DecodeRVR extends Decoder {
    public function getExpression() {
        return '/^R([0-9]{2}[LCR]?)\/(([PM]?([0-9]{4}))V)?([PM]?([0-9]{4}))(FT)?\/?([UDN]?)/';
    }

    public function parse($report, &$decoded) {
        $result = $this->match_chunk($report);
        $match = $result['match'];
        $report = $result['report'];

        if(!$match) {
            $result = null;
        } else {
            if(empty($match[2])) {
                $result = array(
                    'runway' => Value::toInt($match[5]),
                    'unit' => $match[7],
                    'trend' => $match[8]
                );
            } else {
                $result = array(
                    'variable' => array(
                        'from' => Value::toInt($match[3]),
                        'to' => Value::toInt($match[5])
                    ),
                    'unit' => $match[7],
                    'trend' => $match[8]
                );
            }

            $decoded->setRunwaysVisualRange($result);
            $result = $match[0];
        }

        return array(
            'name' => 'rvr',
            'result' => $result,
            'report' => $report,
        );
    }
}
?>