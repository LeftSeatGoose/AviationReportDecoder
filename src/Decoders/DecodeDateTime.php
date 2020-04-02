<?php

/**
 * DecodeDateTime.php
 *
 * PHP version 7.2
 *
 * @category Metar
 * @package  ReportDecoder\Decoders
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */

namespace ReportDecoder\Decoders;

use ReportDecoder\Decoders\Decoder;
use ReportDecoder\Entity\EntityDateTime;

/**
 * Decodes DateTime chunk
 *
 * @category Metar
 * @package  ReportDecoder\Decoders
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */
class DecodeDateTime extends Decoder
{
    /**
     * Returns the expression for matching the chunk
     * 
     * @return String
     */
    public function getExpression()
    {
        return '/^([0-9]{2})([0-9]{2})([0-9]{2})Z/';
    }

    /**
     * Parses the chunk using the expression
     * 
     * @param String       $report  Remaining report string
     * @param DecodedMetar $decoded DecodedMetar object
     * 
     * @return Array
     */
    public function parse($report, &$decoded)
    {
        $result = $this->matchChunk($report);
        $match = $result['match'];
        $report = $result['report'];

        if (!$match) {
            $result = null;
        } else {
            $decoded->setDateTime(
                new EntityDateTime(
                    $match[2],
                    $match[2] . ':' . $match[3]
                )
            );

            $date = new \DateTime($match[2] . ':' . $match[3]);
            $result = array(
                'text' => $match[0],
                'tip' => 'Weather observed '
                    . $date->format('Y-m-d H:i') . ' UTC'
            );
        }

        return array(
            'name' => 'datetime',
            'result' => $result,
            'report' => $report
        );
    }
}
