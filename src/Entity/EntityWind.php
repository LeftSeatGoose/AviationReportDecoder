<?php
namespace ReportDecoder\Entity;

class EntityWind {

    private $wind = null;
    private $direction = null;
    private $speed = null;
    private $gust = null;
    private $unit = null;

    public function __construct($wind) {
        $this->wind = $wind['text'];
        $this->direction = $wind['direction'];
        $this->speed = $wind['speed'];
        $this->gust = $wind['gust'];
        $this->unit = $wind['unit'];
    }

    public function wind() {
        return $this->wind;
    }

    public function direction() {
        return $this->direction;
    }

    public function speed() {
        return $this->speed;
    }

    public function gust() {
        return $this->gust;
    }

    public function unit() {
        return $this->unit;
    }
}
?>