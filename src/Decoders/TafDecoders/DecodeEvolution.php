<?php

/**
 * DecodeEvolution.php
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
use ReportDecoder\Entity\Value;
use ReportDecoder\Exceptions\DecoderException;

/**
 * Decodes Evolution chunk
 *
 * @category Taf
 * @package  ReportDecoder\Decoders\TafDecoders
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */
class DecodeEvolution extends Decoder implements DecoderInterface
{
    /**
     * Returns the expression for matching the chunk
     * 
     * @return String
     */
    public function getExpression()
    {
        return '/(BECMG+|TEMPO+|FM+|((PROB)[034]{2})+)/';
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
            // If evolution is a probability
            if (isset($match[3])) {
                $tip = $match[3] . '% probability';
            } else {
                $tip = Value::EVOLUTION_TEXT[$match[1]];
            }

            $result = array(
                'text' => $match[0],
                'tip' => $tip
            );
        }

        return array(
            'name' => 'evolution',
            'result' => $result,
            'report' => $report,
        );
    }
}
