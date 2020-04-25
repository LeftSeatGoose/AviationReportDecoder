<?php

/**
 * TypeDecoder.php
 *
 * PHP version 7.2
 *
 * @category ReportTypes
 * @package  ReportDecoder\ReportTypes
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */

namespace ReportDecoder\ReportTypes;

use ReportDecoder\Exceptions\DecoderException;

/**
 * Includes the decoder chain for decoding a report string
 *
 * @category ReportTypes
 * @package  ReportDecoder\ReportTypes
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */
abstract class TypeDecoder
{
    protected $_decoder = null;
    protected $_decoded_report = null;

    /**
     * Consume a chunk
     * 
     * @param String $report Report to decode
     * 
     * @return DecodedReport
     */
    public function consume($report)
    {
        foreach ($this->_decoder as $chunk) {
            try {
                $parse_attempt = $chunk->parse($report, $this->_decoded_report);
            } catch (DecoderException $ex) {
                $this->_decoded_report->addDecodingException($ex);
            }

            if (is_null($parse_attempt['result'])) {
                continue;
            }

            $this->_decoded_report->addReportChunk($parse_attempt['result']);

            if (!empty($parse_attempt['report'])) {
                $report = $parse_attempt['report'];
            } else {
                break;
            }
        }

        return $this->_decoded_report;
    }
}
