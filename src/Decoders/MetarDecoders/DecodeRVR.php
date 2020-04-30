<?php

/**
 * DecodeDateTime.php
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
 * Decodes DateTime chunk
 *
 * @category Metar
 * @package  ReportDecoder\Decoders\MetarDecoders
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */
class DecodeRVR extends Decoder implements DecoderInterface
{
    /**
     * Returns the expression for matching the chunk
     * 
     * @return String
     */
    public function getExpression()
    {
        return '/^R([0-9]{2}[LCR]?)\/(([PM]?([0-9]{4}))V)'
            . '?([PM]?([0-9]{4}))(FT)?\/?([UDN]?)/';
    }

    /**
     * Parses the chunk using the expression
     * 
     * @param String        $report  Remaining report string
     * @param DecodedReport $decoded DecodedReport object
     * 
     * @return Array
     */
    public function parse($report, &$decoded, $edit_decoder = true)
    {
        $result = $this->matchChunk($report);
        $match = $result['match'];
        $report = $result['report'];

        if (!$match) {
            $result = null;
        } else {
            if (empty($match[2])) {
                $result = array(
                    'runway' => Value::toInt($match[5]),
                    'unit' => $match[7],
                    'trend' => $match[8]
                );
            } else {
                $result = array(
                    'variable' => array(
                        'from' => Value::toInt($match[3]),
                        'to' => Value::toInt($match[5])
                    ),
                    'unit' => $match[7],
                    'trend' => $match[8]
                );
            }

            if ($edit_decoder) {
                $decoded->setRunwaysVisualRange($result);
            }
            $result = array(
                'text' => $match[0],
                'tip' => 'Runways visual range'
            );
        }

        return array(
            'name' => 'rvr',
            'result' => $result,
            'report' => $report,
        );
    }
}
