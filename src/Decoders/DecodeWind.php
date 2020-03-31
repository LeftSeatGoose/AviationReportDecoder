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

namespace ReportDecoder\Decoders;

use ReportDecoder\Decoders\Decoder;
use ReportDecoder\Entity\EntityWind;
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
class DecodeWind extends Decoder
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
                        'unit' => $match[5]
                    )
                )
            );

            $result = array(
                'wind' => $match[0],
                'tip' => 'Wind direction: ' . $match[1] . '\nWind speed: '
                    . Value::toInt($match[2]) . $match[5] . '\n'
                    . !empty(Value::toInt($match[4])) ? 'Wind gust: '
                    . Value::toInt($match[4]) . $match[5] : ''
            );
        }

        return array(
            'name' => 'wind',
            'result' => $result,
            'report' => $report,
        );
    }
}
