<?php

/**
 * DecodeWeather.php
 *
 * PHP version 7.2
 *
 * @category Metar
 * @package  ReportDecoder\Decoders
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */

namespace ReportDecoder\Decoders;

use ReportDecoder\Decoders\Decoder;
use ReportDecoder\Entity\Value;

/**
 * Decodes Weather chunk
 *
 * @category Metar
 * @package  ReportDecoder\Decoders
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */
class DecodeWeather extends Decoder
{
    private static $_carac_dic = array(
        'TS', 'FZ', 'SH', 'BL', 'DR', 'MI', 'BC', 'PR',
    );

    private static $_type_dic = array(
        'DZ', 'RA', 'SN', 'SG',
        'PL', 'DS', 'GR', 'GS',
        'UP', 'IC', 'FG', 'BR',
        'SA', 'DU', 'HZ', 'FU',
        'VA', 'PY', 'DU', 'PO',
        'SQ', 'FC', 'DS', 'SS'
    );

    /**
     * Returns the expression for matching the chunk
     * 
     * @return String
     */
    public function getExpression()
    {
        $carac_regexp = implode('|', self::$_carac_dic);
        $type_regexp = implode('|', self::$_type_dic);
        $pw_regexp = "([-+]|VC)?($carac_regexp)?($type_regexp)"
            . "?($type_regexp)?($type_regexp)?";

        return "/^($pw_regexp )?($pw_regexp )?($pw_regexp )?/";
    }
    /**
     * Parses the chunk using the expression
     * 
     * @param String       $report  Remaining report string
     * @param DecodedMetar $decoded DecodedMetar object
     * 
     * @return Array
     */
    public function parse($report, &$decoded)
    {
        $result = $this->matchChunk($report);
        $match = $result['match'];
        $report = $result['report'];

        if (!$match) {
            $result = null;
        } else {
            $decoded->setPresentWeather($match[0]);
            $result = array(
                'text' => $match[0],
                'tip' => Value::weatherCodeToText($match[0])
            );
        }

        return array(
            'name' => 'weather',
            'result' => $result,
            'report' => $report,
        );
    }
}
