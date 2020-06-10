<?php

/**
 * TafDecoder.php
 *
 * PHP version 7.2
 *
 * @category Taf
 * @package  ReportDecoder\ReportTypes
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */

namespace ReportDecoder\ReportTypes;

use ReportDecoder\Decoders\DecodeType;
use ReportDecoder\Decoders\TafDecoders\DecodeICAO;
use ReportDecoder\Decoders\TafDecoders\DecodeIssueTime;
use ReportDecoder\Decoders\TafDecoders\DecodePeriod;
use ReportDecoder\Decoders\TafDecoders\DecodeWind;
use ReportDecoder\Decoders\TafDecoders\DecodeVisibility;
use ReportDecoder\Decoders\TafDecoders\DecodeWeather;
use ReportDecoder\Decoders\TafDecoders\DecodeCloud;
use ReportDecoder\Decoders\TafDecoders\EvolutionDecoder;
use ReportDecoder\Decoders\TafDecoders\DecodeRemarks;

/**
 * Includes the decoder chain for decoding a taf string
 *
 * @category Taf
 * @package  ReportDecoder\ReportTypes
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */
class TafDecoder extends TypeDecoder implements TypeDecoderInterface
{
    /**
     * Constructor
     * 
     * @param DecodedReport $decoded_report Object decoded data is stored in
     */
    public function __construct($decoded_report)
    {
        $this->decoded_report = $decoded_report;

        $this->decoder = [
            new DecodeType(),
            new DecodeICAO(),
            new DecodeIssueTime(),
            new DecodePeriod(),
            new DecodeWind(),
            new DecodeVisibility(),
            new DecodeWeather(),
            new DecodeCloud(),
            new EvolutionDecoder(),
            new DecodeRemarks()
        ];
    }
}
