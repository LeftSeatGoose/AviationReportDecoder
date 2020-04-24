<?php

/**
 * DecoderInterface.php
 *
 * PHP version 7.2
 *
 * @category ReportDecoder
 * @package  ReportDecoder\Decoders
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */

namespace ReportDecoder\Decoders;

/**
 * Interface for the decoding class
 *
 * @category ReportDecoder
 * @package  ReportDecoder\Decoders
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */
interface DecoderInterface
{
    /**
     * Returns the expression for matching the chunk
     * 
     * @return String
     */
    public function getExpression();

    /**
     * Parses the chunk using the expression
     * 
     * @param String  $report  Remaining report string
     * @param Decoded $decoded Decoded report object
     * 
     * @return Array
     */
    public function parse($report, &$decoded);
}
