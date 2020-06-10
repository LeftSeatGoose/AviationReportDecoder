<?php

/**
 * DecodedEvolution.php
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
class DecodedEvolution extends DecodedReport
{
    private $_issue_time;
    private $_validity_start;
    private $_validity_end;
    private $_surface_wind;
    private $_visibility;
    private $_cavok;
    private $_present_weather;
    private $_clouds;

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
     * @param EntityDateTime $validity_start From date
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
     * @return EntityDateTime
     */
    public function getValidityFrom()
    {
        return $this->_validity_start;
    }

    /**
     * Set the evolution validity end
     * 
     * @param EntityDateTime $validity_end Validity end
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
     * @return EntityDateTime
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
}
