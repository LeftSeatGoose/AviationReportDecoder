<?php

/**
 * DecodeVisibility.php
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
use ReportDecoder\Entity\EntityVisibility;
use ReportDecoder\Entity\Value;
use ReportDecoder\Exceptions\DecoderException;

/**
 * Decodes Visibility chunk
 *
 * @category Taf
 * @package  ReportDecoder\Decoders\TafDecoders
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */
class DecodeVisibility extends Decoder implements DecoderInterface
{
    /**
     * Returns the expression for matching the chunk
     * 
     * @return String
     */
    public function getExpression()
    {
        $cavok = "CAVOK";
        $visibility = "([0-9]{4})";
        $us_visibility = "M?(P)?([0-9]{0,2}) ?(([1357])\/(2|4|8|16))?SM";
        $no_info = "\/\/\/\/";

        return "/^($cavok|$visibility|$us_visibility|$no_info)( )/";
    }

    /**
     * Parses the chunk using the expression
     * 
     * @param String        $report  Remaining report string
     * @param DecodedReport $decoded DecodedReport object
     * 
     * @throws DecodingException
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
                'Bad format for visibility information',
                $this
            );
        }

        $cavok = false;

        if ($match[1] ==  'CAVOK') {
            $decoded->setCavok(true);
            $result = null;
        } elseif ($match[1] == '////') {
            $decoded->setCavok(false);
            $result = array(
                'text' => $match[0],
                'tip' => 'Ground visibility not measured'
            );
        } else {
            $decoded->setCavok(false);

            if (trim($match[2]) != null) {
                // ICAO Visibility
                $decoded->setVisibility(
                    new EntityVisibility(
                        Value::toInt($match[2]),
                        Value::UNIT_METRE
                    )
                );
            } else {
                // US Visibility
                $main = intval($match[4]);
                $is_greater = $match[3] === 'P' ? true : false;
                $frac_top = intval($match[6]);
                $frac_bot = intval($match[7]);
                if ($frac_bot != 0) {
                    $vis_value = $main + $frac_top / $frac_bot;
                } else {
                    $vis_value = $main;
                }

                $decoded->setVisibility(
                    new EntityVisibility(
                        Value::toInt($vis_value),
                        Value::UNIT_SM
                    )
                );
            }

            $result = array(
                'text' => $match[0],
                'tip' => 'Ground visibility is ' . $match[0]
            );
        }

        return array(
            'name' => 'visibility',
            'result' => $result,
            'report' => $remaining_report
        );
    }
}
