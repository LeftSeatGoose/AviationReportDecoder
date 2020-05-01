<?php

/**
 * Value.php
 *
 * PHP version 7.2
 *
 * @category Entity
 * @package  ReportDecoder\Entity
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */

namespace ReportDecoder\Entity;

/**
 * Value definitions
 *
 * @category Entity
 * @package  ReportDecoder\Entity
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */
abstract class Value
{
    public const REPORT_METAR = 'metar';
    public const REPORT_TAF = 'taf';
    public const REPORT_TYPES = array(self::REPORT_METAR, self::REPORT_TAF);

    public const UNIT_HPA = 'hPa';
    public const UNIT_INHG = 'inHg';
    public const UNIT_SM = 'SM';
    public const UNIT_KM = 'KM';
    public const UNIT_KT = 'KT';
    public const UNIT_MPH = 'MPH';
    public const UNIT_KPH = 'KPH';

    public const EVOLUTION_TEXT = array(
        'BECMG' => 'Becoming',
        'TEMPO' => 'Temporary',
        'FM' => 'From',
        'PROB' => 'Probability'
    );

    private const WEATHER_TEXT = array(
        'P' => 'More than',
        'M' => 'Less than',
        'B' => 'Began',
        'E' => 'Ended',
        'TS' => 'Thunderstorm',
        'FZ' => 'Freezing',
        'SH' => 'Showering',
        'BL' => 'Blowing',
        'DR' => 'Low Drifting',
        'MI' => 'Shallow',
        'PR' => 'Partial',
        'DZ' => 'Drizzle',
        'RA' => 'Rain',
        'SN' => 'Snow',
        'SG' => 'Snow Grains',
        'PL' => 'Ice Pellets',
        'DS' => 'Dust storm',
        'GR' => 'Hail (>5mm)',
        'GS' => 'Small Hail / Snow Pellets (<5mm)',
        'UP' => 'Unknown Precipitation',
        'IC' => 'Ice Crystals',
        'FG' => 'Fog',
        'BR' => 'Mist',
        'SA' => 'Sand',
        'DU' => 'Dust',
        'HZ' => 'Haze',
        'FU' => 'Smoke',
        'VA' => 'Volcanic Ash',
        'PY' => 'Spray',
        'PO' => 'Well-Developed Dust/Sand',
        'SQ' => 'Squalls Moderate',
        'FC' => 'Funnel Cloud',
        'DS' => 'Sandstorm'
    );

    /**
     * Formats a report int as a php int
     * 
     * @param String $value Int to format
     * 
     * @return Int
     */
    public static function toInt($value)
    {
        $letter_signs = array('P', 'M');
        $numeric_signs = array('', '-');

        $value_numeric = str_replace($letter_signs, $numeric_signs, $value);

        if (preg_match('#^[\-0-9]#', $value_numeric)) {
            return intval($value_numeric);
        } else {
            return;
        }
    }

    /**
     * Converts weather code to readable text
     * 
     * @param String $weather The weather code to be converted
     * 
     * @return String|Boolean
     */
    public static function weatherCodeToText($weather)
    {
        $exp = implode('|', array_keys(self::WEATHER_TEXT));
        $pw_regexp = "/^([-+]|VC)?($exp)?($exp)?($exp)?($exp)?/";

        if (!preg_match($pw_regexp, $weather, $match)) {
            return false;
        }

        unset($match[0]);

        $match[1] = str_replace('+', 'Heavy', $match[1]);
        $match[1] = str_replace('-', 'Light', $match[1]);
        $match[1] = str_replace('VC', 'In the vicinity', $match[1]);

        $output = $match[1] . ' ';
        $i = 0;
        foreach ($match as $code) {
            if (++$i == 1) {
                continue;
            }
            $output .= self::WEATHER_TEXT[$code] . ' ';
        }

        return trim($output);
    }
}
