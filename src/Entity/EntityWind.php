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

namespace ReportDecoder\Entity;

use ReportDecoder\Entity\Value;

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

    /**
     * Construct
     * 
     * @param Array $wind Wind information
     */
    public function __construct($wind)
    {
        $this->_wind = $wind['text'];
        $this->_direction = $wind['direction'];

        $multiplier = 1;
        if ($wind['unit'] != Value::UNIT_KT) {
            if ($wind['unit'] == Value::UNIT_KPH) {
                $multiplier = 0.539957;
            }
            if ($wind['unit'] == Value::UNIT_MPH) {
                $multiplier = 0.868976;
            }
        }

        $this->_speed = $wind['speed'] * $multiplier;
        $this->_gust = $wind['gust'] * $multiplier;
    }

    /**
     * Gets the wind text
     * 
     * @return String
     */
    public function getWind()
    {
        return $this->wind;
    }

    /**
     * Gets the wind direction
     * 
     * @return String
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * Gets the wind speed
     * 
     * @return Int
     */
    public function getSpeed()
    {
        return $this->speed;
    }

    /**
     * Gets the gust speed
     * 
     * @return Int
     */
    public function getGust()
    {
        return $this->gust;
    }
}
