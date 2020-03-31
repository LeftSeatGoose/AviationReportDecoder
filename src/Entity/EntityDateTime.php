<?php

/**
 * EntityDateTime.php
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
 * DateTime information
 *
 * @category Metar
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
     * @param Int $day  Day of observation
     * @param Int $time Time of observation
     */
    public function __construct($day, $time)
    {

        $now = new \DateTime();
        $datetime = sprintf(
            '%s-%s-%s %sZ',
            $now->format('Y'),
            $now->format('m'),
            $day,
            $time
        );
        $this->_datetime = new \DateTime($datetime);
        $this->_datetime->setTimezone(new \DateTimeZone('UTC'));
    }

    /**
     * Gets and formats the DateTime
     * 
     * @param String $format Output format
     * 
     * @return String
     */
    public function value($format = 'Y-m-d H:i:s')
    {
        return $this->datetime->format($format);
    }
}
