<?php

/**
 * EntityVisibility.php
 *
 * PHP version 7.2
 *
 * @category Metar
 * @package  ReportDecoder\Entity
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */

namespace ReportDecoder\Entity;

use ReportDecoder\Entity\Value;

/**
 * Visibility information
 *
 * @category Metar
 * @package  ReportDecoder\Entity
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */
class EntityVisibility
{

    private $_distance = null;

    /**
     * Construct
     * 
     * @param Int $visibility Visibility of station
     */
    public function __construct($visibility)
    {
        $multiplier = 1;
        if ($visibility['unit'] != Value::UNIT_SM) {
            if ($visibility['unit'] == Value::UNIT_KM) {
                $multiplier = 0.621371;
            }
        }

        $this->_distance = $visibility['distance'] * $multiplier;
    }

    /**
     * Gets the visibility
     * 
     * @return Int
     */
    public function getDistance()
    {
        return $this->_distance;
    }
}
