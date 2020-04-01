<?php

/**
 * DecodeType.php
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

/**
 * Decodes Type chunk
 *
 * @category Metar
 * @package  ReportDecoder\Decoders
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */
class DecodeType extends Decoder
{
    /**
     * Returns the expression for matching the chunk
     * 
     * @return String
     */
    public function getExpression()
    {
        return '/^((METAR|TAF|SPECI)( (COR|AMD)){0,1})|((PROV TAF))/';
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
            $decoded->setType($match[0]);

            $result = array(
                'text' => $match[0],
                'tip' => 'Type of report'
            );
        }

        return array(
            'name' => 'type',
            'result' => $result,
            'report' => $report,
        );
    }
}
