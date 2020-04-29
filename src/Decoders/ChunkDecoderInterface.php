<?php

/**
 * ChunkDecoderInterface.php
 *
 * PHP version 7.2
 *
 * @category Decoders
 * @package  ReportDecoder\Decoders
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */

namespace ReportDecoder\Decoders;

/**
 * Interface for chunk decoders
 *
 * @category Decoders
 * @package  ReportDecoder\Decoders
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */
interface ChunkDecoderInterface
{
    /**
     * Constructor
     */
    public function __construct();

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
    public function parse($report, &$decoded);
}
