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
use ReportDecoder\Entity\EntityDateTime;
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
        $type = '(BECMG\s+|TEMPO\s+|FM\s*|PROB\s*([034]{2}\s+)){1}';
        $period = '([0-9]{4}\/[0-9]{4}\s+|[0-9]{6}\s+){1}';

        return "/$type$period/";
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
            $evo_period = trim($match[3]);

            if (strpos(trim($match[1]), 'PROB') !== false) {
                $evo_type = 'PROB';
            } else {
                $evo_type = trim($match[1]);
            }

            $decoded->setType($evo_type);

            // Probability
            if ($evo_type == 'PROB') {
                //$evolution->setProbability(trim($remaining_report));
                $tip = trim($match[2]) . '% probability of evolution';
            } else {
                $tip = Value::EVOLUTION_TEXT[$evo_type];
            }

            // Period
            if (
                $evo_type == 'BECMG'
                || $evo_type == 'TEMPO'
                || $evo_type == 'PROB'
            ) {
                $periodArr = explode('/', $evo_period);
                $decoded->setValidityFrom(
                    new EntityDateTime(
                        intval(mb_substr($periodArr[0], 0, 2)),
                        mb_substr($periodArr[0], 2, 2) . ':00'
                    )
                );
                $decoded->setValidityTo(
                    new EntityDateTime(
                        intval(mb_substr($periodArr[1], 0, 2)),
                        mb_substr($periodArr[1], 2, 2) . ':00'
                    )
                );
            } else {
                $decoded->setValidityFrom(
                    new EntityDateTime(
                        intval(mb_substr($evo_period, 0, 2)),
                        mb_substr($evo_period, 2, 2) . ':'
                            . mb_substr($evo_period, 4, 2)
                    )
                );
            }

            if ($evo_type == 'BECMG' || $evo_type == 'TEMPO') {
                $tip .= ' from ' . $decoded->getValidityFrom()
                    ->value('d H:ie') . ' to '
                    . $decoded->getValidityTo()->value('d H:ie');
            } else if ($evo_type == 'PROB') {
                $tip .= '. Valid from ' . $decoded->getValidityFrom()
                    ->value('d H:ie') . ' to '
                    . $decoded->getValidityTo()->value('d H:ie');
            } else {
                $tip .= ' ' . $decoded->getValidityFrom()->value('d H:ie');
            }

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
