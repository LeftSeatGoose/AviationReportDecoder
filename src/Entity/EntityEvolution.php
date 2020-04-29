<?php

/**
 * EntityEvolution.php
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

use ReportDecoder\Entity\DecodedReport;

/**
 * Evolution entity
 *
 * @category Entity
 * @package  ReportDecoder\Entity
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */
class EntityEvolution extends DecodedReport
{
    private $_from_day;
    private $_from_time;
    private $_to_day;
    private $_to_time;
    private $_probability;
    private $_surface_wind;
    private $_visibility;
    private $_cavok;
    private $_present_weather;
    private $_clouds;

    /**
     * Set the evolution from date
     * 
     * @param String $from_day From date
     * 
     * @return Void
     */
    public function setFromDay($from_day)
    {
        $this->_from_day = $from_day;
    }

    /**
     * Get the evolution from date
     * 
     * @return String
     */
    public function getFromDay()
    {
        return $this->_from_day;
    }

    /**
     * Set the evolution from time
     * 
     * @param String $from_time From time
     * 
     * @return Void
     */
    public function setFromTime($from_time)
    {
        $this->_from_time = $from_time;
    }

    /**
     * Get the evolution from time
     * 
     * @return String
     */
    public function getFromTime()
    {
        return $this->_from_time;
    }

    /**
     * Set the evolution to date
     * 
     * @param String $to_day To date
     * 
     * @return String
     */
    public function setToDay($to_day)
    {
        $this->_to_day = $to_day;

        return $this;
    }

    /**
     * Get the evolution to date
     * 
     * @return String
     */
    public function getToDay()
    {
        return $this->_to_day;
    }

    /**
     * Set the evolution to time
     * 
     * @param String $to_time To time
     * 
     * @return Void
     */
    public function setToTime($to_time)
    {
        $this->_to_time = $to_time;
    }

    /**
     * Get the evolution to time
     * 
     * @return String
     */
    public function getToTime()
    {
        return $this->_to_time;
    }

    /**
     * Set probability
     * 
     * @param EntityEvolution $probability Probability
     * 
     * @return Void
     */
    public function setProbability($probability)
    {
        $this->_probability = $probability;
    }

    /**
     * Get probability
     * 
     * @return EntityEvolution
     */
    public function getProbability()
    {
        return $this->_probability;
    }

    /**
     * Sets the surface wind
     * 
     * @param EntityWind $wind Surface wind
     * 
     * @return Void
     */
    public function setSurfaceWind(EntityWind $wind)
    {
        $this->_surface_wind = $wind;
    }

    /**
     * Gets the surface wind entity
     * 
     * @return EntityWind
     */
    public function getSurfaceWind()
    {
        return $this->_surface_wind;
    }

    /**
     * Sets the Visibility
     * 
     * @param EntityVisibility $visibility Visiblity
     * 
     * @return Void
     */
    public function setVisibility(EntityVisibility $visibility)
    {
        $this->_visibility = $visibility;
    }

    /**
     * Gets the visibility entity
     * 
     * @return EntityVisibility
     */
    public function getVisibility()
    {
        return $this->_visibility;
    }

    /**
     * Set Cavok
     * 
     * @param Boolean $cavok Cavok
     * 
     * @return Void
     */
    public function setCavok($cavok)
    {
        $this->_cavok = $cavok;
    }

    /**
     * Get Cavok
     * 
     * @return Boolean
     */
    public function getCavok()
    {
        return $this->_cavok;
    }

    /**
     * Gets present weather
     * 
     * @return String
     */
    public function getPresentWeather()
    {
        return $this->_present_weather;
    }

    /**
     * Sets the Present Weather
     * 
     * @param String $weather Present Weather
     * 
     * @return Void
     */
    public function setPresentWeather($weather)
    {
        $this->_present_weather = $weather;
    }

    /**
     * Gets the clouds
     * 
     * @return String
     */
    public function getClouds()
    {
        return $this->_clouds;
    }

    /**
     * Sets the Clouds
     * 
     * @param Array $clouds clouds
     * 
     * @return Void
     */
    public function setClouds(array $clouds)
    {
        $this->_clouds = $clouds;
    }
}
