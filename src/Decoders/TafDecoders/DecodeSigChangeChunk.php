<?php

/**
 * DecodeSigChangeChunk.php
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
use ReportDecoder\Decoders\TafDecoders\DecoderChunks\SigChange\SigChangeChunk;

/**
 * Decodes Signifigant Change chunk
 *
 * @category Taf
 * @package  ReportDecoder\Decoders\TafDecoders
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */
class DecodeSigChangeChunk extends Decoder implements DecoderInterface
{
    /**
     * Returns the expression for matching the chunk
     * 
     * @return String
     */
    public function getExpression()
    {
        return '/^PROB([0-9]{2})/';
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
        $match = array_map('trim', $result['match']);
        $report = $result['report'];

        if (!$match) {
            $result = null;
        } else {
            // Decode the rest of this chunk

            $result = array(
                'text' => $match[0],
                'tip' => $match[1] . '% probability of significant change to mean conditions'
            );
        }

        return array(
            'name' => 'significant_change',
            'result' => $result,
            'report' => $report,
        );
    }
}
