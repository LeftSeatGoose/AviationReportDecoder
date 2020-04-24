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
use ReportDecoder\Decoders\MetarDecoders\DecodeWind;
use ReportDecoder\Decoders\TafDecoders\DecodeICAO;
use ReportDecoder\Decoders\TafDecoders\DecodeIssueTime;
use ReportDecoder\Decoders\TafDecoders\DecodeValidity;
use ReportDecoder\Exceptions\DecoderException;

/**
 * Includes the decoder chain for decoding a taf string
 *
 * @category Taf
 * @package  ReportDecoder\ReportTypes
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */
class TafDecoder
{
    private $_decoder = null;
    private $_decoded_taf = null;

    /**
     * Constructor
     * 
     * @param DecodedTaf $decoded_taf Object decoded data is stored in
     */
    public function __construct($decoded_taf)
    {
        $this->_decoded_taf = $decoded_taf;

        $this->_decoder = array(
            new DecodeType(),
            new DecodeICAO(),
            new DecodeIssueTime(),
            new DecodeValidity(),
            new DecodeWind()
        );
    }

    /**
     * Consume a chunk
     * 
     * @param String $report Taf to decode
     * 
     * @return DecodedTaf
     */
    public function consume($report)
    {
        foreach ($this->_decoder as $chunk) {
            try {
                $parse_attempt = $chunk->parse($report, $this->_decoded_taf);
            } catch (DecoderException $ex) {
                $this->decoder->addDecodingException($ex);
            }

            if (is_null($parse_attempt['result'])) {
                continue;
            }

            $this->_decoded_taf->addReportChunk($parse_attempt['result']);

            if (!empty($parse_attempt['report'])) {
                $report = $parse_attempt['report'];
            } else {
                break;
            }
        }

        return $this->_decoded_taf;
    }
}
