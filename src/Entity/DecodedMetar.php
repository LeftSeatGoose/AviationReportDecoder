<?php

/**
 * DecodedMetar.php
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
 * Decoded metar information
 *
 * @category Entity
 * @package  ReportDecoder\Entity
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */
class DecodedMetar extends DecodedReport
{
    private $_icao;

    private $_datetime;

    private $_reporter;

    private $_surface_wind;

    private $_visibility;
    private $_cavok;

    private $_runways_visual_range = [];

    private $_present_weather = [];

    private $_clouds = [];

    private $_air_temperature;
    private $_dew_point_temperature;

    private $_pressure;

    private $_remarks;

    /**
     * Sets the ICAO
     * 
     * @param String $icao ICAO
     * 
     * @return Void
     */
    public function setIcao($icao)
    {
        $this->_icao = $icao;
    }

    /**
     * Gets the station icao
     * 
     * @return String
     */
    public function getIcao()
    {
        return $this->_icao;
    }

    /**
     * Sets the DateTime
     * 
     * @param EntityDateTime $datetime DateTime
     * 
     * @return Void
     */
    public function setDateTime(EntityDateTime $datetime)
    {
        $this->_datetime = $datetime;
    }

    /**
     * Gets the DateTime entity
     * 
     * @return EntityDateTime
     */
    public function getDateTime()
    {
        return $this->_datetime;
    }

    /**
     * Sets the Reporter
     * 
     * @param String $reporter Metar reporter
     * 
     * @return Void
     */
    public function setReporter($reporter)
    {
        $this->_reporter = $reporter;
    }

    /**
     * Gets the reporter
     * 
     * @return String
     */
    public function getReporter()
    {
        return $this->_reporter;
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
     * Sets if station is CAVOK
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
     * Gets if the station is CAVOK
     * 
     * @return Boolean
     */
    public function getCavok()
    {
        return $this->_cavok;
    }

    /**
     * Sets a Runway Visual Range
     * 
     * @param EntityRVR $rvr Runway Visual Range
     * 
     * @return Void
     */
    public function setRunwayVisualRange($rvr)
    {
        $this->_runways_visual_range[] = $rvr;
    }

    /**
     * Gets the runways visual range
     * 
     * @return EntityRVR[]
     */
    public function getRunwaysVisualRange()
    {
        return $this->_runways_visual_range;
    }

    /**
     * Sets the Present Weather
     * 
     * @param Array $weather Present weather
     * 
     * @return Void
     */
    public function setPresentWeather($weather)
    {
        $this->_present_weather = $weather;
    }

    /**
     * Gets present weather
     * 
     * @return Array
     */
    public function getPresentWeather()
    {
        return $this->_present_weather;
    }

    /**
     * Sets the Clouds
     * 
     * @param EntityCloud[] $clouds Clouds
     * 
     * @return EntityCloud[]
     */
    public function setClouds(array $clouds)
    {
        $this->_clouds = $clouds;
    }

    /**
     * Gets the clouds
     * 
     * @return Array
     */
    public function getClouds()
    {
        return $this->_clouds;
    }

    /**
     * Sets the Air temperature
     * 
     * @param Value $temperature Temperature
     * 
     * @return Void
     */
    public function setAirTemperature($temperature)
    {
        $this->_air_temperature = $temperature;
    }

    /**
     * Gets the air temperature
     * 
     * @return Value
     */
    public function getAirTemperature()
    {
        return $this->_air_temperature;
    }

    /**
     * Sets the Dew Point
     * 
     * @param Value $temperature Dew Point
     * 
     * @return Void
     */
    public function setDewPointTemperature($temperature)
    {
        $this->_dew_point_temperature = $temperature;
    }

    /**
     * Gets the dew point
     * 
     * @return Value
     */
    public function getDewPointTemperature()
    {
        return $this->_dew_point_temperature;
    }

    /**
     * Sets the Pressure
     * 
     * @param Value $pressure Pressure
     * 
     * @return Void
     */
    public function setPressure($pressure)
    {
        $this->_pressure = $pressure;
    }

    /**
     * Gets the pressure
     * 
     * @return Value
     */
    public function getPressure()
    {
        return $this->_pressure;
    }

    /**
     * Sets the Remarks
     * 
     * @param String $remarks Remarks
     * 
     * @return Void
     */
    public function setRemarks($remarks)
    {
        $this->_remarks = $remarks;
    }

    /**
     * Gets the remarks
     * 
     * @return String
     */
    public function getRemarks()
    {
        return $this->_remarks;
    }
}
