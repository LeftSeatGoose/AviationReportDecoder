<?php
namespace ReportDecoder\Entity;

class DecodedMetar {
    private $raw_metar;

    private $decoding_exceptions = array();

    private $type;

    private $icao;

    private $datetime;

    private $reporter;

    private $surface_wind;

    private $visibility;
    private $cavok;

    private $runways_visual_range;

    private $present_weather;

    private $clouds;

    private $air_temperature;
    private $dew_point_temperature;

    private $pressure;
    
    private $remarks;

    public function __construct($raw_metar) {
        $this->raw_metar = $raw_metar;

        $this->cavok = false;

        $this->decoding_exceptions = array();
    }

    public function isValid() {
        return count($this->decoding_exceptions) == 0;
    }

    public function addDecodingException($exception) {
        $this->decoding_exceptions[] = $exception;
    }

    public function getDecodingExceptions() {
        return $this->decoding_exceptions;
    }

    public function resetDecodingExceptions() {
        $this->decoding_exceptions = array();
    }

    public function getRawMetar() {
        return trim($this->raw_metar);
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function getType() {
        return $this->type;
    }

    public function setIcao($icao) {
        $this->icao = $icao;
    }

    public function getIcao() {
        return $this->icao;
    }

    public function setDateTime($datetime) {
        $this->datetime = $datetime;
    }

    public function getDateTime() {
        return $this->datetime;
    }

    public function setReporter($reporter) {
        $this->reporter = $reporter;
    }

    public function getReporter() {
        return $this->reporter;
    }

    public function setSurfaceWind(EntityWind $surface_wind) {
        $this->surface_wind = $surface_wind;
    }

    public function getSurfaceWind() {
        return $this->surface_wind;
    }

    public function setVisibility($visibility) {
        $this->visibility = $visibility;
    }

    public function getVisibility() {
        return $this->visibility;
    }

    public function setCavok($cavok) {
        $this->cavok = $cavok;
    }

    public function getCavok() {
        return $this->cavok;
    }

    public function getRunwaysVisualRange() {
        return $this->runways_visual_range;
    }

    public function setRunwaysVisualRange(array $runways) {
        $this->runways_visual_range = $runways;
    }

    public function getPresentWeather() {
        return $this->present_weather;
    }

    public function setPresentWeather($weather) {
        $this->present_weather = $weather;
    }

    public function getClouds() {
        return $this->clouds;
    }

    public function setClouds(array $clouds) {
        $this->clouds = $clouds;
    }

    public function getAirTemperature() {
        return $this->air_temperature;
    }

    public function setAirTemperature($temperature) {
        $this->air_temperature = $temperature;
    }

    public function getDewPointTemperature() {
        return $this->dew_point_temperature;
    }

    public function setDewPointTemperature($temperature) {
        $this->dew_point_temperature = $temperature;
    }

    public function getPressure() {
        return $this->pressure;
    }

    public function setPressure($pressure) {
        $this->pressure = $pressure;
    }

    public function getRemarks() {
        return $this->remarks;
    }

    public function setRemarks($remarks) {
        $this->remarks = $remarks;
    }
}
?>