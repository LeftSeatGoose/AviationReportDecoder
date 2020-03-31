<?php

/**
 * DecodeCloud.php
 *
 * PHP version 7.2
 *
 * @category Metar
 * @package  ReportDecoder\Decoders
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */

namespace ReportDecoder\Decoders;

use ReportDecoder\Decoders\Decoder;
use ReportDecoder\Exceptions\DecoderException;

/**
 * Decodes Cloud chunk
 *
 * @category Metar
 * @package  ReportDecoder\Decoders
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */
class DecodeCloud extends Decoder
{
    /**
     * Returns the expression for matching the chunk
     * 
     * @return String
     */
    public function getExpression()
    {
        $no_cloud = '(NSC|NCD|CLR|SKC)';
        $layer = '(VV|FEW|SCT|BKN|OVC)([0-9]{3})(CB|TCU)?';

        return "/^($no_cloud|($layer)( $layer)?( $layer)?( "
            . "$layer)?( $layer)?( $layer)?)( )/";
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
        $match = array_map('trim', $result['match']);
        $report = $result['report'];

        if (!$match) {
            throw new DecoderException(
                $report,
                $result['report'],
                'Bad format for cloud information',
                $this
            );
        } else {
            $clouds = array();
            for ($i = 4; $i <= sizeof($match); $i += 3) {
                if (empty($match[$i])) {
                    continue;
                }

                $clouds[] = array(
                    'cloud' => $match[$i],
                    'alititude' => $match[++$i],
                    'tip' => $match[$i] . ' ' . $match[++$i] . 'ft AGL'
                );
            }

            $decoded->setClouds($clouds);
            $result = array(
                'cloud' => $match[0]
            );
        }

        return array(
            'name' => 'clouds',
            'result' => $result,
            'report' => $report,
        );
    }
}