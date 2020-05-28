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
    private $_direction = null;
    private $_is_greater = null;
    private $_ndv = null;
    private $_sector_visibilities = array();

    /**
     * Construct
     * 
     * @param Value   $distance   Distance
     * @param Int     $direction  Visibility direction
     * @param Boolean $is_greater If the visibility is greater than the value
     */
    public function __construct($distance, $direction = null, $is_greater = false)
    {
        $this->_distance = $distance;
        $this->_direction = $direction;
        $this->_is_greater = $is_greater;
    }

    /**
     * Gets the distance
     * 
     * @return Value
     */
    public function getDistance()
    {
        return $this->_distance;
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
     * Gets if the visibility is greater than the value
     * 
     * @return Boolean
     */
    public function getIsGreater()
    {
        return $this->_is_greater;
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
     * @param Value  $distance  Visibility distance
     * @param String $direction Visibility direction
     * 
     * @return Void
     */
    public function setSectorVisibility($distance, $direction)
    {
        $this->_sector_visibilities[] = new EntityVisibility(
            $distance,
            $direction
        );
    }

    /**
     * Gets the sector visibilities
     * 
     * @return EntityVisibility[]
     */
    public function getSectorVisibility()
    {
        return $this->_sector_visibilities;
    }
}
