<?php

/**
 * DecodedTaf.php
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
 * Decoded taf information
 *
 * @category Entity
 * @package  ReportDecoder\Entity
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */
class DecodedTaf extends DecodedReport
{
    private $_icao;

    private $_issuetime;

    private $_validity_from;
    private $_validity_to;

    private $_surface_wind;

    private $_cavok;

    private $_visibility;

    private $_present_weather;

    private $_clouds;

    private $_evolutions = array();

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
     * Sets the IssueTime
     * 
     * @param EntityDateTime $issuetime Issue time entity
     * 
     * @return Void
     */
    public function setIssueTime(EntityDateTime $issuetime)
    {
        $this->_issuetime = $issuetime;
    }

    /**
     * Gets the EntityDateTime entity
     * 
     * @return EntityDateTime
     */
    public function getIssueTime()
    {
        return $this->_issuetime;
    }

    /**
     * Sets the Validity from entity
     * 
     * @param EntityDateTime $validity Validity entity
     * 
     * @return Void
     */
    public function setValidityFrom(EntityDateTime $validity)
    {
        $this->_validity_from = $validity;
    }

    /**
     * Gets the Validity from entity
     * 
     * @return EntityDateTime
     */
    public function getValidityFrom()
    {
        return $this->_validity_from;
    }

    /**
     * Sets the Validity to entity
     * 
     * @param EntityDateTime $validity Validity entity
     * 
     * @return Void
     */
    public function setValidityTo(EntityDateTime $validity)
    {
        $this->_validity_to = $validity;
    }

    /**
     * Gets the Validity to entity
     * 
     * @return EntityDateTime
     */
    public function getValidityTo()
    {
        return $this->_validity_to;
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
     * @return String
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

    /**
     * Gets the clouds
     * 
     * @return Array
     */
    public function getEvolutions()
    {
        return $this->_evolutions;
    }

    /**
     * Sets an evolution
     * 
     * @param EntityEvolution $evolution Evolution entity
     * 
     * @return Void
     */
    public function setEvolution(EntityEvolution $evolution)
    {
        $this->_evolutions[] = $evolution;
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
     * @return Void
     */
    public function setRemarks($remarks)
    {
        $this->_remarks = $remarks;
    }
}
