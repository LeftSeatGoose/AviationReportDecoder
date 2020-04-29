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
var_dump($decoder->getDecodedReport('TAF CYBW 212338Z 091212 26020G30KT P6SM SCT100 BECMG 2200/2202 30015KT FM220200 30016KT P6SM SKC PROB40 0006 2SM TSRA OVC008CB TEMPO 2200/2202 BKN100 RMK FCST BASED ON AUTO OBS. NXT FCST WILL BE ISSUED AT 221145Z'));

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
    private $_report_type = Value::REPORT_METAR;

    /**
     * Gets the decoded report
     * 
     * @param String $report      Raw report
     * @param String $report_type The type of report to be decoded (optional)
     * 
     * @return DecodedMetar|DecodedTaf
     */
    public function getDecodedReport($report, $report_type = null)
    {
        $clean_report = trim(strtoupper($report));
        $clean_report = preg_replace('#=$#', '', $clean_report);
        $clean_report = preg_replace('#[ ]{2,}#', ' ', $clean_report) . ' ';

        if (is_null($report_type)) {
            // Get the report type to determine which decoder chain to use
            $type_decoder = new DecodeType();

            if (
                preg_match($type_decoder->getExpression(), $clean_report, $match)
                && !is_null($match[2])
            ) {
                $this->_report_type = strtolower($match[2]);
            }
        } else {
            $this->_report_type = $report_type;
        }

        if ($this->_report_type == Value::REPORT_METAR) {
            $this->_decoded = new DecodedMetar($report);
            $decoder = new MetarDecoder($this->_decoded);
        } else {
            $this->_decoded = new DecodedTaf($report);
            $decoder = new TafDecoder($this->_decoded);
        }

        $decoder->consume($clean_report);
        return $this->_decoded;
    }
}
