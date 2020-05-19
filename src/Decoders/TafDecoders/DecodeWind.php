<?php

/**
 * DecodeWind.php
 *
 * PHP version 7.2
 *
 * @category Taf
 * @package  ReportDecoder\Decoders\TafDecoders
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */

namespace ReportDecoder\Decoders\TafDecoders;

use ReportDecoder\Decoders\Decoder;
use ReportDecoder\Decoders\DecoderInterface;
use ReportDecoder\Entity\EntityWind;
use ReportDecoder\Entity\Value;
use ReportDecoder\Exceptions\DecoderException;

/**
 * Decodes Wind chunk
 *
 * @category Taf
 * @package  ReportDecoder\Decoders\TafDecoders
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */
class DecodeWind extends Decoder implements DecoderInterface
{
    /**
     * Returns the expression for matching the chunk
     * 
     * @return String
     */
    public function getExpression()
    {
        $direction = '([0-9]{3}|VRB|\/\/\/)';
        $speed = 'P?([\/0-9]{2,3}|\/\/)';
        $speed_variations = '(GP?([0-9]{2,3}))?';
        $unit = '(KT|MPS|KPH)';
        $direction_variations = '( ([0-9]{3})V([0-9]{3}))?';

        return "/^$direction$speed$speed_variations$unit$direction_variations/";
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
        $remaining_report = $result['report'];

        if (!$match) {
            throw new DecoderException(
                $report,
                $remaining_report,
                'Bad format for wind information',
                $this
            );
        }

        $decoded->setSurfaceWind(
            new EntityWind(
                $match[1],
                Value::toInt($match[2]),
                Value::toInt($match[4]),
                $match[5],
                isset($match[6]) ? $match[7] : null,
                isset($match[6]) ? $match[8] : null
            )
        );

        if ($match[1] == '///' && $match[2] == '//') {
            $tip = 'No information measured for surface wind';
        } else {
            $tip = 'Wind direction: ' . trim($match[1]) . '°, ';
            if (isset($match[6])) {
                $tip .= 'Variable from ' . $match[7] . '° to ' . $match[8] . '°, ';
            }
            $tip .= 'Wind speed: ' . Value::toInt($match[2]) . $match[5];
            if (!empty(Value::toInt($match[4]))) {
                $tip .=  ', Wind gust: ' . Value::toInt($match[4]) . $match[5];
            }
        }

        $result = array(
            'text' => $match[0],
            'tip' => $tip
        );

        return array(
            'name' => 'wind',
            'result' => $result,
            'report' => $remaining_report
        );
    }
}
