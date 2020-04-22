<?php

/**
 * DecodedTaf.php
 *
 * PHP version 7.2
 *
 * @category Taf
 * @package  ReportDecoder\Entity
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */

namespace ReportDecoder\Entity\TafEntities;

/**
 * Decoded taf information
 *
 * @category Taf
 * @package  ReportDecoder\Entity
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */
class DecodedTaf
{
    private $_taf_chunks = array();

    private $_raw_taf;

    private $_decoding_exceptions = array();

    /**
     * Construct
     * 
     * @param String $raw_taf The raw taf
     */
    public function __construct($raw_taf)
    {
        $this->_raw_taf = $raw_taf;

        $this->_cavok = false;

        $this->_decoding_exceptions = array();
    }
}
