<?php

/**
 * DecodeQNH.php
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
use ReportDecoder\Entity\Value;
use ReportDecoder\Exceptions\DecoderException;

/**
 * Decodes QNH chunk
 *
 * @category Metar
 * @package  ReportDecoder\Decoders
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */
class DecodeQNH extends Decoder
{

    private static $_units = array(
        'A' => Value::UNIT_INHG,
        'Q' => Value::UNIT_HPA
    );

    /**
     * Returns the expression for matching the chunk
     * 
     * @return String
     */
    public function getExpression()
    {
        return '/^(Q|A)([0-9]{4})/';
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
            throw new DecoderException(
                $report,
                $result['report'],
                'Bad format for pressure information',
                $this
            );
        } else {
            $pressure = $match[2];

            if ($match[1] == 'A') {
                $pressure = $pressure / 100;
            }

            $decoded->setPressure($pressure . self::$_units[$match[1]]);

            $result = array(
                'pressure' => $match[0],
                'tip' => 'Pressure is ' . $pressure . ' ' . self::$_units[$match[1]]
            );
        }

        return array(
            'name' => 'pressure',
            'result' => $result,
            'report' => $report,
        );
    }
}
