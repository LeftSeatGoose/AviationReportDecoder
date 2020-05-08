<?php

/**
 * EntityCloud.php
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
 * Cloud information
 *
 * @category Entity
 * @package  ReportDecoder\Entity
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */
class EntityCloud
{

    private $_cloud_abbv = null;
    private $_cloud_type = null;
    private $_height_ft = null;

    /**
     * Construct
     * 
     * @param String $cloud_abbv Abbreviation for the cloud type
     * @param Int    $height_ft  Cloud height in feet
     */
    public function __construct($cloud_abbv,  $height_ft)
    {
        $this->_cloud_abbv = $cloud_abbv;
        $this->_height_ft = $height_ft;
        if (isset(Value::CLOUD_TEXT[$cloud_abbv])) {
            $this->_cloud_type = Value::CLOUD_TEXT[$cloud_abbv];
        }
    }

    /**
     * Gets the abbreviation
     * 
     * @return String
     */
    public function getAbbv()
    {
        return $this->_cloud_abbv;
    }

    /**
     * Gets the cloud type
     * 
     * @return String|Null
     */
    public function getType()
    {
        return $this->_cloud_type;
    }

    /**
     * Gets the cloud height in feet
     * 
     * @return Int
     */
    public function getHeight()
    {
        return $this->_height_ft;
    }
}
