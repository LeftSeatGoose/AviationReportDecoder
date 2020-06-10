<?php

/**
 * DecodeWeather.php
 *
 * PHP version 7.2
 *
 * @category Metar
 * @package  ReportDecoder\Decoders\MetarDecoders
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */

namespace ReportDecoder\Decoders\MetarDecoders;

use ReportDecoder\Decoders\Decoder;
use ReportDecoder\Decoders\DecoderInterface;
use ReportDecoder\Entity\EntityWeather;
use ReportDecoder\Entity\Value;

/**
 * Decodes Weather chunk
 *
 * @category Metar
 * @package  ReportDecoder\Decoders\MetarDecoders
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */
class DecodeWeather extends Decoder implements DecoderInterface
{
    private static $_carac_dic = [
        'TS', 'FZ', 'SH', 'BL', 'DR', 'MI', 'BC', 'PR'
    ];

    private static $_type_dic = [
        'DZ', 'RA', 'SN', 'SG',
        'PL', 'DS', 'GR', 'GS',
        'UP', 'IC', 'FG', 'BR',
        'SA', 'DU', 'HZ', 'FU',
        'VA', 'PY', 'DU', 'PO',
        'SQ', 'FC', 'DS', 'SS'
    ];

    /**
     * Returns the expression for matching the chunk
     * 
     * @return String
     */
    public function getExpression()
    {
        $carac_regexp = implode('|', self::$_carac_dic);
        $type_regexp = implode('|', self::$_type_dic);
        $pw_regexp = "([-+]|VC)?(NSW)?($carac_regexp)?($type_regexp)"
            . "?($type_regexp)?($type_regexp)?";

        return "/^($pw_regexp )?($pw_regexp )?($pw_regexp )?/";
    }

    /**
     * Parses the chunk using the expression
     * 
     * @param String        $report  Remaining report string
     * @param DecodedReport $decoded DecodedReport object
     * 
     * @return Array
     */
    public function parse($report, &$decoded)
    {
        $result = $this->matchChunk($report);
        $match = $result['match'];
        $remaining_report = $result['report'];

        if (!$match || (isset($match[0]) && $match[0] == '')) {
            $result = null;
        } else {
            $weather = trim($match[0]);
            $weather_components = explode(' ', $weather);

            $weather_text = [];
            $weather_tips = [];
            $decoded_weather = [];

            foreach ($weather_components as $component) {
                $weather_text[] = $component;
                $weather_tips[] = Value::weatherCodeToText($component);
                $decoded_weather[] = new EntityWeather($component);
            }

            $decoded->setPresentWeather($decoded_weather);
            $result = [
                'text' => $weather_text,
                'tip' => $weather_tips
            ];
        }

        return [
            'name' => 'weather',
            'result' => $result,
            'report' => $remaining_report
        ];
    }
}
