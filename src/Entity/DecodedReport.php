<?php

/**
 * DecodedReport.php
 *
 * PHP version 7.2
 *
 * @category Entity
 * @package  ReportDecoder\Entity
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */

namespace ReportDecoder\Entity;

use ReportDecoder\Exceptions\DecoderException;

/**
 * Decoded report information
 *
 * @category Entity
 * @package  ReportDecoder\Entity
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */
abstract class DecodedReport
{
    private $_report_chunks = array();

    private $_raw_report;

    private $_decoding_exceptions = array();

    private $_type;

    /**
     * Construct
     * 
     * @param String  $raw_report The raw report
     */
    public function __construct($raw_report)
    {
        $this->_raw_report = $raw_report;
        $this->_decoding_exceptions = array();
    }

    /**
     * Gets the report chunks
     * 
     * @return Array
     */
    public function getReportChunks()
    {
        return $this->_report_chunks;
    }

    /**
     * Adds report chunk
     * 
     * @param Array $chunk Report chunk
     * 
     * @return Void
     */
    public function addReportChunk($chunk)
    {
        $this->_report_chunks[] = $chunk;
    }

    /**
     * Checks if decoding was successful
     * 
     * @return Boolean
     */
    public function isValid()
    {
        return count($this->_decoding_exceptions) == 0;
    }

    /**
     * Adds a decoding exception
     * 
     * @param DecoderException $exception Exception object
     * 
     * @return Void
     */
    public function addDecodingException(DecoderException $exception)
    {
        $this->_decoding_exceptions[] = $exception;
    }

    /**
     * Gets decoding exceptions
     * 
     * @return Array
     */
    public function getDecodingExceptions()
    {
        return $this->_decoding_exceptions;
    }

    /**
     * Resets the decoding exception
     * 
     * @return Void
     */
    public function resetDecodingExceptions()
    {
        $this->_decoding_exceptions = array();
    }

    /**
     * Gets the raw report
     * 
     * @return String
     */
    public function getRawReport()
    {
        return trim($this->_raw_report);
    }

    /**
     * Sets the type
     * 
     * @param String $type Report type
     * 
     * @return Void
     */
    public function setType($type)
    {
        $this->_type = $type;
    }

    /**
     * Gets the report type
     * 
     * @return String
     */
    public function getType()
    {
        return $this->_type;
    }
}
