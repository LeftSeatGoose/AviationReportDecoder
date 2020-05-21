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
    private $_is_variable = false;
    private $_var_from = null;
    private $_var_to = null;

    /**
     * Construct
     * 
     * @param Value $direction Wind direction
     * @param Value $speed     Wind speed
     * @param Value $gust      Wind gust
     * @param Value $var_from  Direction variable start
     * @param Value $var_to    Direction variable end
     */
    public function __construct(
        $direction,
        $speed,
        $gust,
        $var_from = null,
        $var_to = null
    ) {
        $this->_direction = $direction;
        $this->_speed = $speed;
        $this->_gust = $gust;

        if (!is_null($var_from)) {
            $this->_is_variable = true;
        }
        $this->_var_from = $var_from;
        $this->_var_to = $var_to;
    }

    /**
     * Gets the wind direction
     * 
     * @return Value
     */
    public function getDirection()
    {
        return $this->_direction;
    }

    /**
     * Gets the wind speed
     * 
     * @return Value
     */
    public function getSpeed()
    {
        return $this->_speed;
    }

    /**
     * Gets the gust speed
     * 
     * @return Value
     */
    public function getGust()
    {
        return $this->_gust;
    }

    /**
     * Gets if the wind is variable
     * 
     * @return Boolean
     */
    public function getWindVariable()
    {
        return $this->_is_variable;
    }

    /**
     * Gets the variable direction start
     * 
     * @return Value
     */
    public function getVarFrom()
    {
        return $this->_var_from;
    }

    /**
     * Gets the variable direction end
     * 
     * @return Value
     */
    public function getVarTo()
    {
        return $this->_var_to;
    }
}
