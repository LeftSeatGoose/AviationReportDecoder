<?php
namespace ReportDecoder\Exceptions;

class DecoderException extends \Exception {
    private $metar_chunk;

    private $remaining_metar;

    private $chunk_decoder_class;

    public function __construct($metar_chunk, $remaining_metar, $message, $chunk_decoder) {
        parent::__construct($message);
        $this->metar_chunk = trim($metar_chunk);
        $this->remaining_metar = $remaining_metar;
        $r_class = new \ReflectionClass($chunk_decoder);
        $this->chunk_decoder_class = $r_class->getShortName();
    }

    public function getChunkDecoder() {
        return $this->chunk_decoder_class;
    }

    public function getChunk() {
        return $this->metar_chunk;
    }

    public function getRemainingMetar() {
        return $this->remaining_metar;
    }
}
?>