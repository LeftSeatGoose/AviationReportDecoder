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
    private $_trend = null;
    private $_range = null;
    private $_range_variable = false;
    private $_variable_from = null;
    private $_variable_to = null;

    /**
     * Construct
     * 
     * @param Int $trend Range trend
     */
    private function __construct($trend)
    {
        $this->_trend = $trend;
    }

    /**
     * Initiate the class with variable information
     * 
     * @param Int   $trend         Range trend
     * @param Value $variable_from Range variable from
     * @param Value $variable_to   Range variable to
     * 
     * @return EntityRVR
     */
    public static function initWithVariable($trend, $variable_from, $variable_to)
    {
        $obj = new EntityRVR($trend);
        $obj->_range_variable = true;
        $obj->_variable_from = $variable_from;
        $obj->_variable_to = $variable_to;
        return $obj;
    }

    /**
     * Initiate the class with variable information
     * 
     * @param Int   $trend  Range trend
     * @param Int   $runway Runway
     * @param Value $range  Visual Range
     * 
     * @return EntityRVR
     */
    public static function initWithRunway($trend, $runway, $range)
    {
        $obj = new EntityRVR($trend);
        $obj->_runway = $runway;
        $obj->_range = $range;
        return $obj;
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
     * Gets of the range is variable
     * 
     * @return Boolean
     */
    public function getRangeVariable()
    {
        return $this->_range_variable;
    }

    /**
     * Gets the visual range
     * 
     * @return Value
     */
    public function getRange()
    {
        return $this->_range;
    }

    /**
     * Gets the variable start
     * 
     * @return Value
     */
    public function getVariableFrom()
    {
        return $this->_variable_from;
    }

    /**
     * Gets variable end
     * 
     * @return Value
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
