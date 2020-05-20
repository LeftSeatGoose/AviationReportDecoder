<?php

/**
 * EntityVisibility.php
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
 * Visibility information
 *
 * @category Entity
 * @package  ReportDecoder\Entity
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */
class EntityVisibility
{
    private $_distance = null;
    private $_unit = null;
    private $_direction = null;
    private $_ndv = null;
    private $_sector_visibilities = array();

    /**
     * Construct
     * 
     * @param Int $distance  Distance
     * @param Int $unit      Distance unit
     * @param Int $direction Visibility direction
     */
    public function __construct($distance, $unit, $direction = null)
    {
        $this->_distance = $distance;
        $this->_unit = $unit;
        $this->_direction = $direction;
    }

    /**
     * Gets the distance
     * 
     * @return Int
     */
    public function getDistance()
    {
        return $this->_distance;
    }

    /**
     * Gets the unit
     * 
     * @return String
     */
    public function getUnit()
    {
        return $this->_unit;
    }

    /**
     * Gets the visibility direction
     * 
     * @return Int
     */
    public function getDirection()
    {
        return $this->_direction;
    }

    /**
     * Sets if the visibility has 
     * no directional variation
     * 
     * @param Boolean $ndv Has NDV
     * 
     * @return Void
     */
    public function setNDV($ndv)
    {
        return $this->_ndv = $ndv;
    }

    /**
     * Gets if the visibility has 
     * no directional variation
     * 
     * @return Boolean
     */
    public function getNDV()
    {
        return $this->_ndv;
    }

    /**
     * Sets a sector visibility
     * 
     * @param Int    $distance  Visibility distance
     * @param String $unit      Unit
     * @param String $direction Visibility direction
     * 
     * @return Void
     */
    public function setSectorVisibility($distance, $unit, $direction)
    {
        $this->_sector_visibilities[] = new EntityVisibility(
            $distance,
            $unit,
            $direction
        );
    }

    /**
     * Gets the sector visibilities
     * 
     * @return EntityVisibility
     */
    public function getSectorVisibility()
    {
        return $this->_sector_visibilities;
    }
}
