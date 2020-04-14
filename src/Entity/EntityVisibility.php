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
    private $_unit = null;

    /**
     * Construct
     * 
     * @param Int $visibility Visibility of station
     */
    public function __construct($visibility)
    {
        $this->_distance = $visibility['visibility'];
        $this->_unit = $visibility['unit'];
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

    /**
     * Gets the distance unit
     * 
     * @return Int
     */
    public function getUnit()
    {
        return $this->_unit;
    }
}
