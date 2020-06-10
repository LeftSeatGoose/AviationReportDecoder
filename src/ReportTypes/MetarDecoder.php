<?php

/**
 * MetarDecoder.php
 *
 * PHP version 7.2
 *
 * @category Metar
 * @package  ReportDecoder\ReportTypes
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */

namespace ReportDecoder\ReportTypes;

use ReportDecoder\Decoders\DecodeType;
use ReportDecoder\Decoders\MetarDecoders\DecodeICAO;
use ReportDecoder\Decoders\MetarDecoders\DecodeDateTime;
use ReportDecoder\Decoders\MetarDecoders\DecodeReporter;
use ReportDecoder\Decoders\MetarDecoders\DecodeWind;
use ReportDecoder\Decoders\MetarDecoders\DecodeVisibility;
use ReportDecoder\Decoders\MetarDecoders\DecodeRVR;
use ReportDecoder\Decoders\MetarDecoders\DecodeWeather;
use ReportDecoder\Decoders\MetarDecoders\DecodeCloud;
use ReportDecoder\Decoders\MetarDecoders\DecodeTemp;
use ReportDecoder\Decoders\MetarDecoders\DecodeQNH;
use ReportDecoder\Decoders\MetarDecoders\DecodeRemarks;
use ReportDecoder\ReportTypes\TypeDecoderInterface;

/**
 * Includes the decoder chain for decoding a metar string
 *
 * @category Metar
 * @package  ReportDecoder\ReportTypes
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */
class MetarDecoder extends TypeDecoder implements TypeDecoderInterface
{

    protected $decoder = null;
    protected $decoded_report = null;

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
            new DecodeDateTime(),
            new DecodeReporter(),
            new DecodeWind(),
            new DecodeVisibility(),
            new DecodeRVR(),
            new DecodeWeather(),
            new DecodeCloud(),
            new DecodeTemp(),
            new DecodeQNH(),
            new DecodeRemarks()
        ];
    }
}
