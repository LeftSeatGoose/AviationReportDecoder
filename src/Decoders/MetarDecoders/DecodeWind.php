<?php

/**
 * DecodeWind.php
 *
 * PHP version 7.2
 *
 * @category Metar
 * @package  ReportDecoder\Decoders
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */

namespace ReportDecoder\Decoders\MetarDecoders;

use ReportDecoder\Decoders\Decoder;
use ReportDecoder\Decoders\DecoderInterface;
use ReportDecoder\Entity\MetarEntities\EntityWind;
use ReportDecoder\Entity\Value;
use ReportDecoder\Exceptions\DecoderException;

/**
 * Decodes Wind chunk
 *
 * @category Metar
 * @package  ReportDecoder\Decoders
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
        return '/^([0-9]{3}|VRB)?([0-9]{2,3})(G?([0-9]{2,3}))'
            . '?(KT|MPH|KPH)( ([0-9]{3})V([0-9]{3}))?/';
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
                'Bad format for wind information',
                $this
            );
        } else {
            $decoded->setSurfaceWind(
                new EntityWind(
                    array(
                        'text' => $match[0],
                        'direction' => $match[1],
                        'speed' => Value::toInt($match[2]),
                        'gust' => Value::toInt($match[4]),
                        'unit' => $match[5],
                        'variable' => isset($match[6]),
                        'var_from' => isset($match[6]) ? $match[7] : 0,
                        'var_to' => isset($match[6]) ? $match[8] : 0
                    )
                )
            );

            $tip = 'Wind direction: ' . trim($match[1]) . '°, ';
            if (isset($match[6])) {
                $tip .= 'Variable from ' . $match[7] . '° to ' . $match[8] . '°, ';
            }
            $tip .= 'Wind speed: ' . Value::toInt($match[2]) . $match[5];
            if (!empty(Value::toInt($match[4]))) {
                $tip .=  ', Wind gust: ' . Value::toInt($match[4]) . $match[5];
            }

            $result = array(
                'text' => $match[0],
                'tip' => $tip
            );
        }

        return array(
            'name' => 'wind',
            'result' => $result,
            'report' => $report,
        );
    }
}
