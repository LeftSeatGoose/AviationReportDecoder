<?php

/**
 * DecodedMetar.php
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

/**
 * Decoded metar information
 *
 * @category Metar
 * @package  ReportDecoder\Entity
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */
class DecodedMetar
{
    private $_raw_metar;

    private $_decoding_exceptions = array();

    private $_type;

    private $_icao;

    private $_datetime;

    private $_reporter;

    private $_surface_wind;

    private $_visibility;
    private $_cavok;

    private $_runways_visual_range;

    private $_present_weather;

    private $_clouds;

    private $_air_temperature;
    private $_dew_point_temperature;

    private $_pressure;

    private $_remarks;

    /**
     * Construct
     * 
     * @param String $raw_metar The raw metar
     */
    public function __construct($raw_metar)
    {
        $this->_raw_metar = $raw_metar;

        $this->_cavok = false;

        $this->_decoding_exceptions = array();
    }

    /**
     * Checks if decoding was successful
     * 
     * @return Boolean
     */
    public function isValid()
    {
        return count($this->_decoding_exceptions) == 0;
    }

    /**
     * Adds a decoding exception
     * 
     * @param DecoderException $exception Exception object
     * 
     * @return null
     */
    public function addDecodingException($exception)
    {
        $this->_decoding_exceptions[] = $exception;
    }

    /**
     * Gets decoding exceptions
     * 
     * @return Array
     */
    public function getDecodingExceptions()
    {
        return $this->_decoding_exceptions;
    }

    /**
     * Resets the decoding exception
     * 
     * @return null
     */
    public function resetDecodingExceptions()
    {
        $this->_decoding_exceptions = array();
    }

    /**
     * Gets the raw metar
     * 
     * @return String
     */
    public function getRawMetar()
    {
        return trim($this->_raw_metar);
    }

    /**
     * Sets the type
     * 
     * @param String $type Metar type
     * 
     * @return null
     */
    public function setType($type)
    {
        $this->_type = $type;
    }

    /**
     * Gets the metar type
     * 
     * @return String
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * Sets the ICAO
     * 
     * @param String $icao ICAO
     * 
     * @return null
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
     * @param String $datetime DateTime
     * 
     * @return null
     */
    public function setDateTime($datetime)
    {
        $this->_datetime = $datetime;
    }

    /**
     * Gets the observation time
     * 
     * @return String
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
     * @return null
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
     * @return null
     */
    public function setSurfaceWind(EntityWind $wind)
    {
        $this->_surface_wind = $wind;
    }

    /**
     * Gets the surface wind
     * 
     * @return String
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
     * @return null
     */
    public function setVisibility(EntityVisibility $visibility)
    {
        $this->_visibility = $visibility;
    }

    /**
     * Gets the visibility
     * 
     * @return String
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
     * @return null
     */
    public function setCavok($cavok)
    {
        $this->_cavok = $cavok;
    }

    /**
     * Gets if the station is CAVOK
     * 
     * @return String
     */
    public function getCavok()
    {
        return $this->_cavok;
    }

    /**
     * Gets the runways visual range
     * 
     * @return String
     */
    public function getRunwaysVisualRange()
    {
        return $this->_runways_visual_range;
    }

    /**
     * Sets the Runway Visual Range
     * 
     * @param Array $runways Runways Visual Range
     * 
     * @return null
     */
    public function setRunwaysVisualRange(array $runways)
    {
        $this->_runways_visual_range = $runways;
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
     * @return null
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
     * @return null
     */
    public function setClouds(array $clouds)
    {
        $this->_clouds = $clouds;
    }

    /**
     * Gets the air temperature
     * 
     * @return String
     */
    public function getAirTemperature()
    {
        return $this->_air_temperature;
    }

    /**
     * Sets the Air temperature
     * 
     * @param String $temperature Temperature
     * 
     * @return null
     */
    public function setAirTemperature($temperature)
    {
        $this->_air_temperature = $temperature;
    }

    /**
     * Gets the dew point
     * 
     * @return String
     */
    public function getDewPointTemperature()
    {
        return $this->_dew_point_temperature;
    }

    /**
     * Sets the Dew Point
     * 
     * @param String $temperature Dew Point
     * 
     * @return null
     */
    public function setDewPointTemperature($temperature)
    {
        $this->_dew_point_temperature = $temperature;
    }

    /**
     * Gets the pressure
     * 
     * @return String
     */
    public function getPressure()
    {
        return $this->_pressure;
    }

    /**
     * Sets the Pressure
     * 
     * @param double $pressure Pressure
     * 
     * @return null
     */
    public function setPressure($pressure)
    {
        $this->_pressure = $pressure;
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

    /**
     * Sets the Remarks
     * 
     * @param String $remarks Remarks
     * 
     * @return null
     */
    public function setRemarks($remarks)
    {
        $this->_remarks = $remarks;
    }
}
