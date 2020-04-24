<?php

/**
 * DecodeValidity.php
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

/**
 * Decodes Validity chunk
 *
 * @category Taf
 * @package  ReportDecoder\Decoders\TafDecoders
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */
class DecodeValidity extends Decoder implements DecoderInterface
{
    /**
     * Returns the expression for matching the chunk
     * 
     * @return String
     */
    public function getExpression()
    {
        return '/^(([0-9]{2})([0-9]{2})(\/)([0-9]{2})([0-9]{2}))|(([0-9]{2})([0-9]{2})([0-9]{2}))/';
    }

    /**
     * Parses the chunk using the expression
     * 
     * @param String     $report  Remaining report string
     * @param DecodedTaf $decoded DecodedTaf object
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
            // DateTime format 1
            if (isset($match[4]) && $match[3] == '/') {
                $from = new EntityDateTime($match[2], $match[3] . ':00');
                $to = new EntityDateTime($match[5], $match[6] . ':00');
            }
            // DateTime format 2
            else {
                $from = new EntityDateTime($match[8], $match[9] . ':00');
                $to = new EntityDateTime($match[8] + 1, $match[10] . ':00');
            }

            $decoded->setValidity($from, $to);
            $result = array(
                'text' => $match[0],
                'tip' => 'Report valid from '
                    . $from->value() . 'UTC to '
                    . $to->value() . 'UTC'
            );
        }

        return array(
            'name' => 'validity',
            'result' => $result,
            'report' => $report
        );
    }
}
