<?php

/**
 * DecodeWeather.php
 *
 * PHP version 7.2
 *
 * @category Metar
 * @package  ReportDecoder\Exceptions
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */

namespace ReportDecoder\Exceptions;

/**
 * Decodes Weather chunk
 *
 * @category Metar
 * @package  ReportDecoder\Exceptions
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */
class DecoderException extends \Exception
{
    private $_chunk;

    private $_remaining;

    private $_chunk_decoder_class;

    /**
     * Construct
     * 
     * @param String  $chunk         Report being parsed
     * @param String  $remaining     Remaining report
     * @param String  $message       Exception message
     * @param Decoder $chunk_decoder Instance that exception occurred in
     */
    public function __construct($chunk, $remaining, $message, $chunk_decoder)
    {
        parent::__construct($message);
        $this->_chunk = trim($chunk);
        $this->_remaining = $remaining;
        $r_class = new \ReflectionClass($chunk_decoder);
        $this->_chunk_decoder_class = $r_class->getShortName();
    }

    /**
     * Gets the chunk decoder
     * 
     * @return Decoder
     */
    public function getChunkDecoder()
    {
        return $this->_chunk_decoder_class;
    }

    /**
     * Gets the chunk
     * 
     * @return String
     */
    public function getChunk()
    {
        return $this->_chunk;
    }

    /**
     * Gets the remaining report
     * 
     * @return String
     */
    public function getRemaining()
    {
        return $this->_remaining;
    }
}
