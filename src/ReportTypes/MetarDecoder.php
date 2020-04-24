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
use ReportDecoder\Exceptions\DecoderException;

/**
 * Includes the decoder chain for decoding a metar string
 *
 * @category Metar
 * @package  ReportDecoder\ReportTypes
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */
class MetarDecoder
{

    private $_decoder = null;
    private $_decoded_metar = null;

    /**
     * Constructor
     * 
     * @param DecodedMetar $decoded_metar Object decoded data is stored in
     */
    public function __construct($decoded_metar)
    {
        $this->_decoded_metar = $decoded_metar;

        $this->_decoder = array(
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
        );
    }

    /**
     * Consume a chunk
     * 
     * @param String $report Metar to decode
     * 
     * @return DecodedMetar
     */
    public function consume($report)
    {
        foreach ($this->_decoder as $chunk) {
            try {
                $parse_attempt = $chunk->parse($report, $this->_decoded_metar);
            } catch (DecoderException $ex) {
                $this->decoder->addDecodingException($ex);
            }

            if (is_null($parse_attempt['result'])) {
                continue;
            }

            $this->_decoded_metar->addReportChunk($parse_attempt['result']);

            if (!empty($parse_attempt['report'])) {
                $report = $parse_attempt['report'];
            } else {
                break;
            }
        }

        return $this->_decoded_metar;
    }
}
