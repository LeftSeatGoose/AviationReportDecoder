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
        return '/(BECMG\s+|TEMPO\s+|FM\s*|PROB\s*([034]{2}\s+)){1}/';
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
            $remaining_report = preg_replace(
                '/(\S+\s+)(.*)/',
                '',
                $report
            );
            $result = null;
        } else {
            if (strpos(trim($match[1]), 'PROB') !== false) {
                $evo_type = 'PROB';
                $tip = trim($match[2]) . '% probability of evolution';
            } else {
                $evo_type = trim($match[1]);
                $tip = Value::EVOLUTION_TEXT[$evo_type];
            }

            $decoded->setType($evo_type);

            $result = [
                'text' => $match[0],
                'tip' => $tip
            ];
        }

        return [
            'name' => 'evolution',
            'result' => $result,
            'report' => $remaining_report
        ];
    }
}
