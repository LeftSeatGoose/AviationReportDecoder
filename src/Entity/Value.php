<?php

/**
 * Value.php
 *
 * PHP version 7.2
 *
 * @category ReportDecoder
 * @package  ReportDecoder\Entity
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */

namespace ReportDecoder\Entity;

/**
 * Value definitions
 *
 * @category ReportDecoder
 * @package  ReportDecoder\Entity
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */
abstract class Value
{
    public const UNIT_HPA = 'hPa';
    public const UNIT_INHG = 'inHg';
    public const UNIT_SM = 'SM';
    public const UNIT_KM = 'KM';
    public const UNIT_KT = 'KT';
    public const UNIT_MPH = 'MPH';
    public const UNIT_KPH = 'KPH';

    /**
     * Formats a metar int as a php int
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
}
