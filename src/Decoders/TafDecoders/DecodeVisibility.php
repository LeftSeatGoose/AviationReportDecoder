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

/**
 * Decodes Visibility chunk
 *
 * @category Taf
 * @package  ReportDecoder\Decoders\Taf Decoders
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
        $cavok = "";
        $visibility = "([0-9]{4})";
        $us_visibility = "M?(P)?([0-9]{0,2}) ?(([1357])/(2|4|8|16))?SM";
        $no_info = "////";

        return "/^(CAVOK|([0-9]{4})|M?(P)?([0-9]{0,2}) ?(([1357])\/(2|4|8|16))?SM)/";
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
            $cavok = false;

            if (strtolower($match[0]) == 'cavok') {
                $decoded->setCavok(true);
            } else {
                $decoded->setCavok(false);
                $unit = Value::UNIT_SM;
                $distance = $match[4];

                if (isset($match[13])) {
                    $unit = Value::UNIT_KM;
                    $distance = $match[12];
                }

                $visiblity = new EntityVisibility(
                    array(
                        'visibility' => Value::toInt($distance),
                        'unit' => $unit
                    )
                );
                $decoded->setVisibility($visiblity);

                $result = array(
                    'text' => $match[0],
                    'tip' => 'Ground visibility is ' . $match[0]
                );
            }
        }

        return array(
            'name' => 'visibility',
            'result' => $result,
            'report' => $report,
        );
    }
}
