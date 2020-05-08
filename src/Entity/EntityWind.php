<?php

/**
 * EntityWind.php
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
 * Wind information
 *
 * @category Entity
 * @package  ReportDecoder\Entity
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */
class EntityWind
{
    private $_direction = null;
    private $_speed = null;
    private $_gust = null;
    private $_unit = null;
    private $_var_from = null;
    private $_var_to = null;

    /**
     * Construct
     * 
     * @param Int|String $direction Wind direction
     * @param Int        $speed     Wind speed
     * @param Int        $gust      Wind gust
     * @param String     $unit      Wind speed unit
     * @param Int        $var_from  Direction variable start
     * @param Int        $var_to    Direction variable end
     */
    public function __construct(
        $direction,
        $speed,
        $gust,
        $unit,
        $var_from = null,
        $var_to = null
    ) {
        $this->_direction = $direction;
        $this->_speed = $speed;
        $this->_gust = $gust;
        $this->_unit = $unit;
        $this->_var_from = $var_from;
        $this->_var_to = $var_to;
    }

    /**
     * Gets the wind direction
     * 
     * @return String
     */
    public function getDirection()
    {
        return $this->_direction;
    }

    /**
     * Gets the wind speed
     * 
     * @return Int
     */
    public function getSpeed()
    {
        return $this->_speed;
    }

    /**
     * Gets the gust speed
     * 
     * @return Int
     */
    public function getGust()
    {
        return $this->_gust;
    }

    /**
     * Gets the speed unit
     * 
     * @return String
     */
    public function getUnit()
    {
        return $this->_unit;
    }

    /**
     * Gets the variable direction start
     * 
     * @return String
     */
    public function getVarFrom()
    {
        return $this->_var_from;
    }

    /**
     * Gets the variable direction end
     * 
     * @return String
     */
    public function getVarTo()
    {
        return $this->_var_to;
    }
}
