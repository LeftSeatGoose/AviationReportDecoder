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
    private $_evolution_type;
    private $_issue_time;
    private $_validity_start;
    private $_validity_end;
    private $_surface_wind;
    private $_visibility;
    private $_cavok;
    private $_present_weather;
    private $_clouds;

    /**
     * Set the evolution type
     * 
     * @param String $evolution_type Evolution type
     * 
     * @return Void
     */
    public function setEvolutionType($evolution_type)
    {
        $this->_evolution_type = $evolution_type;
    }

    /**
     * Get the evolution type
     * 
     * @return String
     */
    public function getEvolutionType()
    {
        return $this->_evolution_type;
    }

    /**
     * Set the issue time
     * 
     * @param EntityDateTime $issue_time Issue time
     * 
     * @return Void
     */
    public function setIssueTime(EntityDateTime $issue_time)
    {
        $this->_issue_time = $issue_time;
    }

    /**
     * Get the issue time
     * 
     * @return EntityDateTime
     */
    public function getIssueTime()
    {
        return $this->_issue_time;
    }

    /**
     * Set the evolution validity start
     * 
     * @param String $validity_start From date
     * 
     * @return Void
     */
    public function setValidityFrom($validity_start)
    {
        $this->_validity_start = $validity_start;
    }

    /**
     * Get the evolution validity start
     * 
     * @return String
     */
    public function getValidityFrom()
    {
        return $this->_validity_start;
    }

    /**
     * Set the evolution validity end
     * 
     * @param String $validity_end Validity end
     * 
     * @return Void
     */
    public function setValidityTo($validity_end)
    {
        $this->_validity_end = $validity_end;
    }

    /**
     * Get the evolution validity end
     * 
     * @return String
     */
    public function getValidityTo()
    {
        return $this->_validity_end;
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
