<?php
namespace ReportDecoder\Entity;

class EntityDateTime {

    private $datetime = null;
    private $day = null;
    private $time = null;

    public function __construct($day, $time) {
        $this->day = $day;
        $this->time = $time;
        
        $now = new \DateTime();
        $datetime = sprintf('%s-%s-%s %sZ', $now->format('Y'), $now->format('m'), $day, $time);
        $this->datetime = new \DateTime($datetime);
        $this->datetime->setTimezone(new \DateTimeZone('UTC'));
    }

    public function datetime() {
        return $this->datetime->format('Y-m-d H:i:s T');
    }

}
?>