<?php

/**
 * ReportDecoder.php
 *
 * PHP version 7.2
 *
 * @category ReportDecoder
 * @package  ReportDecoder
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */

namespace ReportDecoder;

require dirname(__DIR__) . '/vendor/autoload.php';

use ReportDecoder\ReportTypes\MetarDecoder;
use ReportDecoder\ReportTypes\TafDecoder;
use ReportDecoder\Decoders\DecodeType;
use ReportDecoder\Entity\Value;
use ReportDecoder\Entity\DecodedMetar;
use ReportDecoder\Entity\DecodedTaf;

$decoder = new ReportDecoder();
var_dump($decoder->getDecodedReport('TAF CYBW 292338Z 3000/3004 20012KT P6SM SCT090 OVC220 BECMG 3000/3002 20015G25KT RMK FCST BASED ON AUTO OBS. NXT FCST WILL BE ISSUED AT 301145Z '));

/**
 * Decodes a Report
 *
 * @category ReportDecoder
 * @package  ReportDecoder
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */
class ReportDecoder
{
    private $_decoded = null;

    /**
     * Gets the decoded report
     * 
     * @param String $report      Raw report
     * @param String $report_type The type of report to be decoded (optional)
     * 
     * @return DecodedMetar|DecodedTaf|Boolean
     */
    public function getDecodedReport($report, $report_type = null)
    {
        $clean_report = trim(strtoupper($report));
        $clean_report = preg_replace('#=$#', '', $clean_report);
        $clean_report = preg_replace('#[ ]{2,}#', ' ', $clean_report) . ' ';

        if (is_null($report_type)) {
            // Get the report type to determine which decoder chain to use
            $type_decoder = new DecodeType();

            // If the type is included in the report string, then use that to decode
            if (
                preg_match($type_decoder->getExpression(), $clean_report, $match)
                && !is_null($match[2])
            ) {
                $report_type = strtolower($match[2]);
                if (!in_array($report_type, Value::REPORT_TYPES)) {
                    return false; // Unsupported report type, decoding failed
                }
            } else {
                // No type in report string so attempt decoding to determine type

                $type = false;
                foreach (Value::REPORT_TYPES as $report_type) {
                    $decoder = $this->instantiateDecoder($report_type, $report)->consume($clean_report);
                    if ($this->_decoded->isValid()) {
                        $this->_decoded->setType($report_type);
                        return $this->_decoded;
                    }
                }

                return false; // Unable to determine type, decoding failed
            }
        } else {
            $report_type = $report_type;
        }

        $this->instantiateDecoder($report_type, $report)->consume($clean_report);
        $this->_decoded->setType($report_type);
        return $this->_decoded;
    }


    /**
     * Insantiates the report decoder
     *
     * @param String $report_type The report type
     * @param String $raw_report  The raw report string
     * 
     * @return TypeDecoder|Boolean
     */
    private function instantiateDecoder($report_type, $raw_report)
    {
        if ($report_type == Value::REPORT_METAR) {
            $this->_decoded = new DecodedMetar($raw_report);
            return new MetarDecoder($this->_decoded);
        } else if ($report_type == Value::REPORT_TAF) {
            $this->_decoded = new DecodedTaf($raw_report);
            return new TafDecoder($this->_decoded);
        } else {
            return false;
        }
    }
}
