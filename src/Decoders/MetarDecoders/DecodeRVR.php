<?php

/**
 * DecodeRVR.php
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
use ReportDecoder\Entity\EntityRVR;
use ReportDecoder\Entity\Value;

/**
 * Decodes RVR chunk
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
    public function parse($report, &$decoded)
    {
        $result = $this->matchChunk($report);
        $match = $result['match'];
        $remaining_report = $result['report'];

        if (!$match) {
            $result = null;
        } else {
            if (empty($match[2])) {
                $decoded->setRunwaysVisualRange(
                    EntityRVR::initWithRunway(
                        $match[7],
                        $match[8],
                        Value::toInt($match[5])
                    )
                );
            } else {
                $decoded->setRunwaysVisualRange(
                    EntityRVR::initWithVariable(
                        $match[7],
                        $match[8],
                        Value::toInt($match[3]),
                        Value::toInt($match[5])
                    )
                );
            }

            $result = array(
                'text' => $match[0],
                'tip' => 'Runways visual range'
            );
        }

        return array(
            'name' => 'rvr',
            'result' => $result,
            'report' => $remaining_report
        );
    }
}
