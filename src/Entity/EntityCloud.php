<?php
namespace ReportDecoder\Entity;

class EntityCloud {
    
    private $clouds;

    public function __construct($clouds) {
        for($i = 4; $i <= sizeof($clouds); $i += 3) {
            if(empty($clouds[$i])) continue;

            $this->clouds[] = array(
                'cloud' => $clouds[$i],
                'alititude' => $clouds[++$i]
            );
        }
    }

}
?>