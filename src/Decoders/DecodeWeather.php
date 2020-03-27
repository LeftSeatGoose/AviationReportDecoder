<?php
namespace ReportDecoder\Decoders;

use ReportDecoder\Decoders\Decoder;

class DecodeWeather extends Decoder {

    public static $carac_dic = array(
        'TS', 'FZ', 'SH', 'BL', 'DR', 'MI', 'BC', 'PR',
    );

    public static $type_dic = array(
        'DZ', 'RA', 'SN', 'SG',
        'PL', 'DS', 'GR', 'GS',
        'UP', 'IC', 'FG', 'BR',
        'SA', 'DU', 'HZ', 'FU',
        'VA', 'PY', 'DU', 'PO',
        'SQ', 'FC', 'DS', 'SS'
    );

    public function getExpression() {
        $carac_regexp = implode('|', self::$carac_dic);
        $type_regexp = implode('|', self::$type_dic);
        $pw_regexp = "([-+]|VC)?($carac_regexp)?($type_regexp)?($type_regexp)?($type_regexp)?";

        return "/^($pw_regexp )?($pw_regexp )?($pw_regexp )?/";
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
            'name' => 'weather',
            'result' => $result,
            'report' => $report,
        );
    }
}
?>