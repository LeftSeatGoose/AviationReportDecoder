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
use ReportDecoder\Decoders\MetarDecoders\DecodeType;
use ReportDecoder\Entity\MetarEntities\DecodedMetar;
use ReportDecoder\Entity\TafEntities\DecodedTaf;

$decoder = new ReportDecoder();
var_dump($decoder->getDecodedReport('METAR CYBW 220000Z AUTO 26023KT 9SM CLR 15/M01 A2977 RMK SLP095 DENSITY ALT 5000FT'));

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
    private $_report_type;

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

            if (!preg_match($type_decoder->getExpression(), $clean_report, $match) || is_null($match[2])) {
                $this->_report_type = 'metar'; // Assume metar by default
            } else {
                $this->_report_type = strtolower($match[2]);
            }
        } else {
            $this->_report_type = $report_type;
        }

        if ($this->_report_type == 'metar') {
            $this->_decoded = new DecodedMetar($report);

            $metar = new MetarDecoder($this->_decoded);
            $metar->consume($clean_report);
        } else {
            $this->_decoded = new DecodedTaf($report);

            $taf = new TafDecoder($this->_decoded);
            $taf->consume($clean_report);
        }

        return $this->_decoded;
    }
}
