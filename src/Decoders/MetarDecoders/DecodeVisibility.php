<?php

/**
 * DecodeVisibility.php
 *
 * PHP version 7.2
 *
 * @category Metar
 * @package  ReportDecoder\Decoders
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */

namespace ReportDecoder\Decoders\MetarDecoders;

use ReportDecoder\Decoders\Decoder;
use ReportDecoder\Entity\MetarEntities\EntityVisibility;
use ReportDecoder\Entity\Value;
use ReportDecoder\Exceptions\DecoderException;

/**
 * Decodes Visibility chunk
 *
 * @category Metar
 * @package  ReportDecoder\Decoders
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */
class DecodeVisibility extends Decoder
{
    /**
     * Returns the expression for matching the chunk
     * 
     * @return String
     */
    public function getExpression()
    {
        return '/^(CAVOK|([0-9]{4})(NDV)?|M?([0-9]{0,2}) ?(([1357])\/(2|4|8|16))?'
            . '(SM)|( ([0-9]{4})(N|NE|E|SE|S|SW|W|NW)?)|([0-9][05])(KM)?(NDV)?)/';
    }
    /**
     * Parses the chunk using the expression
     * 
     * @param String       $report  Remaining report string
     * @param DecodedMetar $decoded DecodedMetar object
     * 
     * @return Array
     */
    public function parse($report, &$decoded)
    {
        $result = $this->matchChunk($report);
        $match = $result['match'];
        $report = $result['report'];

        if (!$match) {
            throw new DecoderException(
                $report,
                $result['report'],
                'Bad format for visiblity information',
                $this
            );
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
