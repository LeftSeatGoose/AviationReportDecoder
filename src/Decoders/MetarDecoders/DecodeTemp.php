<?php

/**
 * DecodeTemp.php
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
use ReportDecoder\Entity\Value;
use ReportDecoder\Exceptions\DecoderException;

/**
 * Decodes Temperature chunk
 *
 * @category Metar
 * @package  ReportDecoder\Decoders\MetarDecoders
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */
class DecodeTemp extends Decoder implements DecoderInterface
{
    /**
     * Returns the expression for matching the chunk
     * 
     * @return String
     */
    public function getExpression()
    {
        return '/^(M?[0-9]{2})\/(M?[0-9]{2})?/';
    }

    /**
     * Parses the chunk using the expression
     * 
     * @param String        $report  Remaining report string
     * @param DecodedReport $decoded DecodedReport object
     * 
     * @throws DecoderException
     * 
     * @return Array
     */
    public function parse($report, &$decoded)
    {
        $result = $this->matchChunk($report);
        $match = $result['match'];
        $remaining_report = $result['report'];

        if (!$match) {
            throw new DecoderException(
                $report,
                $remaining_report,
                'Bad format for temperature information',
                $this
            );
        }

        $decoded->setAirTemperature(
            new Value(
                Value::toInt($match[1]),
                Value::UNIT_CELSIUS
            )
        );

        $decoded->setDewPointTemperature(
            new Value(
                Value::toInt($match[2]),
                Value::UNIT_CELSIUS
            )
        );

        $result = array(
            'text' => $match[0],
            'tip' => 'Temperature is ' . Value::toInt($match[1])
                . '°C and dew point is ' . Value::toInt($match[2]) . '°C'
        );

        return array(
            'name' => 'temp',
            'result' => $result,
            'report' => $remaining_report
        );
    }
}
