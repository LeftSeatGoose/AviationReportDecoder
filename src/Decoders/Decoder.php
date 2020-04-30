<?php

/**
 * Decoder.php
 *
 * PHP version 7.2
 *
 * @category ReportDecoder
 * @package  ReportDecoder\Decoders
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */

namespace ReportDecoder\Decoders;

/**
 * Parent class of decoding objects
 *
 * @category ReportDecoder
 * @package  ReportDecoder\Decoders
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */
abstract class Decoder
{
    /**
     * Indicates whether the decoder classes should
     * add their results to the decoded class
     *
     * @var bool
     */
    protected $edit_decoder = true;

    /**
     * Returns the expression for matching the chunk
     * 
     * @return String
     */
    public function getExpression()
    {
        return '';
    }

    /**
     * Matches the current chunk of the report
     * 
     * @param String $report Remaining report string
     * 
     * @return Array
     */
    public function matchChunk($report)
    {
        $regex = $this->getExpression();

        if (!preg_match($regex, $report, $match)) {
            $match = false;
        }

        $report = trim(preg_replace($regex, '', $report, 1));

        return array(
            'match' => $match,
            'report' => $report
        );
    }
}
