<?php

/**
 * DecodedTaf.php
 *
 * PHP version 7.2
 *
 * @category Taf
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
 * @category Taf
 * @package  ReportDecoder\Entity
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */
class DecodedTaf extends DecodedReport
{
    private $_icao;

    private $_issuetime;

    private $_validity;

    private $_surface_wind;

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
     * @param EntityDateTime $issuetime
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
     * Sets the Validity entity
     * 
     * @param EntityDateTime $validity
     * 
     * @return Void
     */
    public function setValidity(EntityDateTime $validity)
    {
        $this->_validity = $validity;
    }

    /**
     * Gets the Validity entity
     * 
     * @return EntityDateTime
     */
    public function getValidity()
    {
        return $this->_validity;
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
}
