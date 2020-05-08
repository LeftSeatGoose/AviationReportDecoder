<?php

/**
 * EntityQNH.php
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
 * Pressure information
 *
 * @category Entity
 * @package  ReportDecoder\Entity
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */
class EntityQNH
{

    private $_pressure = null;
    private $_unit = null;

    /**
     * Construct
     * 
     * @param Double $pressure Station pressure
     * @param String $unit     Pressure unit
     */
    public function __construct($pressure,  $unit)
    {
        $this->_pressure = $pressure;
        $this->_unit = $unit;
    }

    /**
     * Gets the pressure
     * 
     * @return Double
     */
    public function getPressure()
    {
        return $this->_pressure;
    }

    /**
     * Gets the pressure unit
     * 
     * @return String
     */
    public function getUnit()
    {
        return $this->_unit;
    }
}
