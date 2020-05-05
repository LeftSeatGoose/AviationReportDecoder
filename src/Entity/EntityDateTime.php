<?php

/**
 * EntityDateTime.php
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
 * DateTime information
 *
 * @category Entity
 * @package  ReportDecoder\Entity
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */
class EntityDateTime
{
    private $_datetime = null;

    /**
     * Construct
     * 
     * @param String $day  Day of observation
     * @param String $time Time of observation
     */
    public function __construct($day = null, $time = null)
    {
        $now = new \DateTime();
        $datetime = sprintf(
            '%s-%s-%s %sZ',
            $now->format('Y'),
            $now->format('m'),
            is_null($day) ? $now->format('d') : $day,
            is_null($time) ? $now->format('H:i') : $time
        );
        $this->_datetime = new \DateTime($datetime, new \DateTimeZone('UTC'));
    }

    /**
     * Gets and formats the DateTime
     * 
     * @param String $format Output format
     * 
     * @return String
     */
    public function value($format = 'Y-m-d H:i e')
    {
        return $this->_datetime->format($format);
    }
}
