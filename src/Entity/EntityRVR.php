<?php

/**
 * EntityRVR.php
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
 * RVR information
 *
 * @category Entity
 * @package  ReportDecoder\Entity
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */
class EntityRVR
{

    private $_runway = null;
    private $_unit = null;
    private $_trend = null;
    private $_variable_from = null;
    private $_variable_to = null;

    /**
     * Construct
     * 
     * @param String $unit  Range unit
     * @param Int    $trend Range trend
     */
    private function __construct($unit, $trend)
    {
        $this->_unit = $unit;
        $this->_trend = $trend;
    }

    /**
     * Initiate the class with variable information
     * 
     * @param String $unit          Range unit
     * @param Int    $trend         Range trend
     * @param Int    $variable_from Range variable from
     * @param Int    $variable_to   Range variable to
     * 
     * @return EntityRVR
     */
    public static function initWithVariable(
        $unit,
        $trend,
        $variable_from,
        $variable_to
    ) {
        $obj = new EntityRVR($unit, $trend);
        $obj->_variable_from = $variable_from;
        $obj->_variable_to = $variable_to;
        return $obj;
    }

    /**
     * Initiate the class with variable information
     * 
     * @param String $unit   Range unit
     * @param Int    $trend  Range trend
     * @param Int    $runway Runway
     * 
     * @return EntityRVR
     */
    public static function initWithRunway($unit, $trend, $runway)
    {
        $obj = new EntityRVR($unit, $trend);
        $obj->_runway = $runway;
        return $obj;
    }

    /**
     * Gets the range unit
     * 
     * @return String
     */
    public function getUnit()
    {
        return $this->_unit;
    }

    /**
     * Gets the trend
     * 
     * @return Int
     */
    public function getTrend()
    {
        return $this->_trend;
    }

    /**
     * Gets the variable start
     * 
     * @return Int
     */
    public function getVariableFrom()
    {
        return $this->_variable_from;
    }

    /**
     * Gets variable end
     * 
     * @return Int
     */
    public function getVariableTo()
    {
        return $this->_variable_to;
    }

    /**
     * Gets the runway
     * 
     * @return Int
     */
    public function getRunway()
    {
        return $this->_runway;
    }
}
