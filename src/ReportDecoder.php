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

use ReportDecoder\TypeDecoder\MetarDecoder;
use ReportDecoder\TypeDecoder\TafDecoder;
use ReportDecoder\Decoders\DecodeType;
use ReportDecoder\Entity\DecodedMetar;

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
    private $_report_type = 'metar'; // Assume metar by default

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
        $this->_decoded = new DecodedMetar($report);

        $clean_report = trim(strtoupper($report));
        $clean_report = preg_replace('#=$#', '', $clean_report);
        $clean_report = preg_replace('#[ ]{2,}#', ' ', $clean_report) . ' ';

        $type_decoder = new DecodeType();

        if (is_null($report_type)) {
            $parse_attempt = $type_decoder->parse($clean_report, $this->_decoded);
            if (!is_null($parse_attempt['result'])) {
                $this->report_chunks['type'] = $parse_attempt['result'];
                $clean_report = $parse_attempt['report'];

                if (strpos(strtolower($parse_attempt['result']), 'taf') !== false) {
                    $this->_report_type = 'taf';
                }
            }
        } else {
            $this->_report_type = $report_type;
        }

        if ($this->_report_type == 'metar') {
            $metar = new MetarDecoder($this->_decoded);
            $metar->consume($clean_report);
        } else {
            $taf = new TafDecoder($this->_decoded);
            $taf->consume($clean_report);
        }

        return $this->_decoded;
    }
}
