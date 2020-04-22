<?php

/**
 * EntityWind.php
 *
 * PHP version 7.2
 *
 * @category Metar
 * @package  ReportDecoder\Entity
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */

namespace ReportDecoder\Entity\MetarEntities;

/**
 * Wind information
 *
 * @category Metar
 * @package  ReportDecoder\Entity
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */
class EntityWind
{

    private $_wind = null;
    private $_direction = null;
    private $_speed = null;
    private $_gust = null;
    private $_unit = null;
    private $_variable = null;
    private $_var_from = null;
    private $_var_to = null;

    /**
     * Construct
     * 
     * @param Array $wind Wind information
     */
    public function __construct($wind)
    {
        $this->_wind = $wind['text'];
        $this->_direction = $wind['direction'];
        $this->_speed = $wind['speed'];
        $this->_gust = $wind['gust'];
        $this->_unit = $wind['unit'];
        $this->_variable = $wind['variable'];
        $this->_var_from = $wind['var_from'];
        $this->_var_to = $wind['var_to'];
    }

    /**
     * Gets the wind text
     * 
     * @return String
     */
    public function getWind()
    {
        return $this->_wind;
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
     * Gets if the wind is variable
     * 
     * @return String
     */
    public function getVariable()
    {
        return $this->_variable;
    }

    /**
     * Gets the start variable direction
     * 
     * @return String
     */
    public function getVarFrom()
    {
        return $this->_var_from;
    }

    /**
     * Gets the end variable direction
     * 
     * @return String
     */
    public function getVarTo()
    {
        return $this->_var_to;
    }
}
