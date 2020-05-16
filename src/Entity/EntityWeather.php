<?php

/**
 * EntityWeather.php
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
 * Weather information
 *
 * @category Entity
 * @package  ReportDecoder\Entity
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */
class EntityWeather
{
    private $_code = null;

    /**
     * Construct
     * 
     * @param Int $code Weather Code
     */
    public function __construct($code)
    {
        $this->_code = $code;
    }

    /**
     * Gets the weather code
     * 
     * @return Int
     */
    public function getCode()
    {
        return $this->_code;
    }

    /**
     * Gets the user friendly weather text
     * 
     * @return String
     */
    public function getText()
    {
        return Value::weatherCodeToText($this->_code);
    }
}
