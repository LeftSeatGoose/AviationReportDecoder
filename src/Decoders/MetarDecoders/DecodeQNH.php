<?php

/**
 * DecodeQNH.php
 *
 * PHP version 7.2
 *
 * @category Metar
 * @package  ReportDecoder\Decoders\MetarDecoders
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */

namespace ReportDecoder\Decoders\MetarDecoders;

use ReportDecoder\Decoders\Decoder;
use ReportDecoder\Decoders\DecoderInterface;
use ReportDecoder\Entity\EntityQNH;
use ReportDecoder\Entity\Value;

/**
 * Decodes QNH chunk
 *
 * @category Metar
 * @package  ReportDecoder\Decoders\MetarDecoders
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */
class DecodeQNH extends Decoder implements DecoderInterface
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
     * @param String        $report  Remaining report string
     * @param DecodedReport $decoded DecodedReport object
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
            $pressure = $match[2];

            if ($match[1] == 'A') {
                $pressure = $pressure / 100;
            }

            $decoded->setPressure(
                new EntityQNH(
                    $pressure,
                    self::$_units[$match[1]]
                )
            );

            $result = array(
                'text' => $match[0],
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
