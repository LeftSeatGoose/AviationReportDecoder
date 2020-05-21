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
class Value
{
    private $_value = null;
    private $_unit = null;

    // Trig Units
    public const UNIT_DEGREE = 'deg';

    // Length Units
    public const UNIT_METRE = 'm';
    public const UNIT_FEET = 'ft';
    public const UNIT_STATUTE_MILE = 'SM';
    public const UNIT_KILOMETRE = 'km';

    // Velocity Units
    public const UNIT_KNOT = 'kt';
    public const UNIT_MILE_PER_HOUR = 'mph';
    public const UNIT_KILOMETRE_PER_HOUR = 'km/h';
    public const UNIT_METRE_PER_SECOND = 'm/s';

    // Pressure Units
    public const UNIT_HECTOPASCAL = 'hPa';
    public const UNIT_INCH_MERCURY = 'inHg';

    // Temperature Units
    public const UNIT_CELSIUS = 'C';

    public const EVOLUTION_TEXT = array(
        'BECMG' => 'Becoming',
        'TEMPO' => 'Temporary',
        'FM' => 'From',
        'PROB' => 'Probability'
    );

    public const CLOUD_TEXT = array(
        'VV' => 'Vertical visibility, indefinite ceiling',
        'FEW' => 'Few',
        'SCT' => 'Scattered',
        'BKN' => 'Broken',
        'OVC' => 'Overcast',
        'CB' => 'Cumulonimbus',
        'TCU' => 'Towering Cumulus'
    );

    public const WEATHER_TEXT = array(
        'TS' => 'thunderstorm',
        'FZ' => 'freezing',
        'SH' => 'showering',
        'BL' => 'blowing',
        'DR' => 'low drifting',
        'MI' => 'shallow',
        'PR' => 'partial',
        'DZ' => 'drizzle',
        'RA' => 'rain',
        'SN' => 'snow',
        'SG' => 'snow Grains',
        'PL' => 'ice Pellets',
        'DS' => 'dust storm',
        'GR' => 'hail (>5mm)',
        'GS' => 'small hail / snow pellets (<5mm)',
        'UP' => 'unknown precipitation',
        'IC' => 'ice crystals',
        'FG' => 'fog',
        'BR' => 'mist',
        'SA' => 'sand',
        'DU' => 'dust',
        'HZ' => 'haze',
        'FU' => 'smoke',
        'VA' => 'volcanic ash',
        'PY' => 'spray',
        'PO' => 'well-developed dust/sand',
        'SQ' => 'squalls moderate',
        'FC' => 'funnel cloud',
        'DS' => 'sandstorm'
    );

    /**
     * Construct
     * 
     * @param Mixed  $value Value
     * @param String $unit  Unit
     */
    public function __construct($value, $unit)
    {
        $this->_value = $value;
        $this->_unit = $unit;
    }

    /**
     * Gets the value
     * 
     * @return Mixed
     */
    public function getValue()
    {
        return $this->_value;
    }

    /**
     * Gets the unit
     * 
     * @return String
     */
    public function getUnit()
    {
        return $this->_unit;
    }

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

        $match[1] = str_replace('VC', '', $match[1], $count);

        $end = '';
        if ($count > 0) {
            $end = 'in the vicinity';
        }
        $start = str_replace('+', 'heavy', $match[1]);
        $start = str_replace('-', 'light', $match[1]);

        $output = $start . ' ';
        $i = 0;
        foreach ($match as $code) {
            if (++$i == 1) {
                continue;
            }
            $output .= self::WEATHER_TEXT[$code] . ' ';
        }
        $output .= $end;

        return ucfirst(trim($output));
    }
}
