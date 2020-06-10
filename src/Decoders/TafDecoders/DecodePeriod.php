<?php

/**
 * DecodePeriod.php
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
 * Decodes Period chunk
 *
 * @category Taf
 * @package  ReportDecoder\Decoders\TafDecoders
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */
class DecodePeriod extends Decoder implements DecoderInterface
{
    /**
     * Returns the expression for matching the chunk
     * 
     * @return String
     */
    public function getExpression()
    {
        return '/^([0-9]{4}\/[0-9]{4}\s?|[0-9]{6}\s?){1}Z?/';
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
            if (strpos($match[1], '/') !== false) {
                $periodArr = explode('/', $match[1]);
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

                $tip = 'Valid from ' . $decoded->getValidityFrom()->value('d H:ie')
                    . ' to ' . $decoded->getValidityTo()->value('d H:ie');
            } else {
                $decoded->setValidityFrom(
                    new EntityDateTime(
                        intval(mb_substr($match[1], 0, 2)),
                        mb_substr($match[1], 2, 2) . ':'
                            . mb_substr($match[1], 4, 2)
                    )
                );

                $tip = 'Valid from ' . $decoded->getValidityFrom()->value('d H:ie');
            }


            $result = [
                'text' => $match[1],
                'tip' => $tip
            ];
        }

        return [
            'name' => 'period',
            'result' => $result,
            'report' => $remaining_report
        ];
    }
}
