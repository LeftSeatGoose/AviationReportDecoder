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

use ReportDecoder\ReportTypes\MetarDecoder;
use ReportDecoder\ReportTypes\TafDecoder;
use ReportDecoder\Entity\DecodedMetar;
use ReportDecoder\Entity\DecodedTaf;

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
    public const REPORT_METAR = 'metar';
    public const REPORT_TAF = 'taf';

    private $_decoded = null;

    /**
     * Gets the decoded report
     * 
     * @param String      $report  Raw report
     * @param TypeDecoder $decoder Type decoder
     * 
     * @return DecodedReport|Boolean
     */
    private function _getDecodedReport($report, $decoder)
    {
        $clean_report = trim(strtoupper($report));
        $clean_report = preg_replace('/=$/', '', $clean_report);
        $clean_report = preg_replace('/[ ]{2,}/', ' ', $clean_report);
        $clean_report = str_replace(array("\r\n", "\n", "\r"), ' ', $clean_report);

        $decoder->consume($clean_report);

        return $this->_decoded;
    }

    /**
     * Gets a decoded metar
     * 
     * @param String $report Raw report
     * 
     * @return DecodedMetar|Boolean
     */
    public function getDecodedMetar($report)
    {
        $this->_decoded = new DecodedMetar($report);
        $this->_decoded->setType(self::REPORT_METAR);
        return $this->_getDecodedReport($report, new MetarDecoder($this->_decoded));
    }

    /**
     * Gets a decoded taf
     * 
     * @param String $report Raw report
     * 
     * @return DecodedTaf|Boolean
     */
    public function getDecodedTaf($report)
    {
        $this->_decoded = new DecodedTaf($report);
        $this->_decoded->setType(self::REPORT_TAF);
        return $this->_getDecodedReport($report, new TafDecoder($this->_decoded));
    }
}
