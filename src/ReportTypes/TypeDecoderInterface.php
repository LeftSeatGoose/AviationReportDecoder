<?php

/**
 * TypeDecoderInterface.php
 *
 * PHP version 7.2
 *
 * @category TypeDecoder
 * @package  ReportDecoder\ReportTypes
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */

namespace ReportDecoder\ReportTypes;

/**
 * Includes the decoder chain for decoding a report string
 *
 * @category TypeDecoder
 * @package  ReportDecoder\ReportTypes
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */
interface TypeDecoderInterface
{
    /**
     * Constructor
     * 
     * @param DecodedReport $decoded_report Object decoded data is stored in
     */
    public function __construct($decoded_report);

    /**
     * Consume a chunk
     * 
     * @param String $report Report to decode
     * 
     * @return DecodedReport
     */
    public function consume($report);
}
