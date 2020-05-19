<?php

/**
 * DecodeVisibility.php
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
use ReportDecoder\Entity\EntityVisibility;
use ReportDecoder\Entity\Value;
use ReportDecoder\Exceptions\DecoderException;

/**
 * Decodes Visibility chunk
 *
 * @category Metar
 * @package  ReportDecoder\Decoders\MetarDecoders
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
        $cavok = 'CAVOK';
        $visibility = '([0-9]{4})(NDV)?';
        $us_visibility = 'M?([0-9]{0,2}) ?(([1357])\/(2|4|8|16))?SM';
        $minimum_visibility = '( ([0-9]{4})(N|NE|E|SE|S|SW|W|NW)?)?';
        $km_visibility = '([0-9][05])(KM)?(NDV)?';
        $no_info = '\/\/\/\/';

        return "/^($cavok|$visibility$minimum_visibility|"
            . "$us_visibility|$km_visibility|$no_info)( )/";
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
            $result = null;
        } else {
            $decoded->setCavok(false);

            if ($match[2] != null) {
                // ICAO Visibility
                $distance = $match[2];
                $unit = Value::UNIT_METRE;
            } else if ($match[11] != null) {
                // KM Visibility
                $distance = $match[11];
                $unit = Value::UNIT_KM;
            } else {
                // US Visibility
                $main = intval($match[7]);
                $frac_top = intval($match[9]);
                $frac_bot = intval($match[10]);

                if ($frac_bot != 0) {
                    $vis_value = $main + $frac_top / $frac_bot;
                } else {
                    $vis_value = $main;
                }

                $distance = $vis_value;
                $unit = Value::UNIT_SM;
            }

            $decoded->setVisibility(
                new EntityVisibility(
                    Value::toInt($distance),
                    $unit
                )
            );

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
