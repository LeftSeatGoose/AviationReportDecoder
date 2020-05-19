<?php

/**
 * DecodeDateTime.php
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
use ReportDecoder\Entity\EntityDateTime;
use ReportDecoder\Exceptions\DecoderException;

/**
 * Decodes IssueTime chunk
 *
 * @category Taf
 * @package  ReportDecoder\Decoders\TafDecoders
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */
class DecodeIssueTime extends Decoder implements DecoderInterface
{
    /**
     * Returns the expression for matching the chunk
     * 
     * @return String
     */
    public function getExpression()
    {
        return '/^([0-9]{2})([0-9]{2})([0-9]{2})Z?/';
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
                'Bad format for issue time information',
                $this
            );
        }

        try {
            $datetime = new EntityDateTime(
                $match[2],
                $match[2] . ':' . $match[3]
            );
        } catch (\Exception $exception) {
            throw new DecoderException(
                $match[0],
                $report,
                'Bad format for issue time decoding.',
                $decoded
            );
        }

        $decoded->setIssueTime($datetime);

        $result = array(
            'text' => $match[0],
            'tip' => 'Report issued at '
                . $datetime->value() . ' UTC'
        );

        return array(
            'name' => 'issuetime',
            'result' => $result,
            'report' => $remaining_report
        );
    }
}
