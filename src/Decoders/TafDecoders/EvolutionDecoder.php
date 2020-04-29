<?php

/**
 * EvolutionDecoder.php
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

use ReportDecoder\ReportTypes\TypeDecoder;
use ReportDecoder\Decoders\ChunkDecoderInterface;
use ReportDecoder\Decoders\TafDecoders\DecodeEvolution;
use ReportDecoder\Decoders\TafDecoders\DecodeIssueTime;
use ReportDecoder\Decoders\TafDecoders\DecodeForecastPeriod;
use ReportDecoder\Decoders\TafDecoders\DecodePeriod;
use ReportDecoder\Decoders\TafDecoders\DecodeWind;
use ReportDecoder\Decoders\TafDecoders\DecodeVisibility;
use ReportDecoder\Decoders\TafDecoders\DecodeWeather;
use ReportDecoder\Decoders\TafDecoders\DecodeCloud;
use ReportDecoder\Exceptions\DecoderException;

/**
 * Decodes Evolution chunk
 *
 * @category Taf
 * @package  ReportDecoder\Decoders\TafDecoders
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */
class EvolutionDecoder extends TypeDecoder implements ChunkDecoderInterface
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->decoder = array(
            new DecodeEvolution(),
            new DecodeIssueTime(),
            new DecodeForecastPeriod(),
            new DecodePeriod(),
            new DecodeWind(),
            new DecodeVisibility(),
            new DecodeWeather(),
            new DecodeCloud()
        );
    }

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
    public function parse($report, &$decoded)
    {
        $this->decoded_report = $decoded;

        $evolution = new DecodeEvolution();
        while (!empty($has_evolution = $evolution->parse($report, $decoded)['result'])) {
            $report = $this->consume($report);
        }
    }

    /**
     * Consume a chunk
     * 
     * @param String $report Report to decode
     * 
     * @return DecodedReport
     */
    public function consume($report)
    {
        foreach ($this->decoder as $chunk) {
            try {
                $parse_attempt = $chunk->parse($report, $this->decoded_report);

                if (is_null($parse_attempt['result'])) {
                    continue;
                }

                $this->decoded_report->addReportChunk($parse_attempt['result']);

                $report = $parse_attempt['report'];
                if (!empty($report)) {
                    $report = $parse_attempt['report'];
                } else {
                    break;
                }
            } catch (DecoderException $ex) {
                $this->decoded_report->addDecodingException($ex);
            }
        }

        return $report;
    }
}
