<?php
namespace ReportDecoder\Decoders;

use ReportDecoder\Decoders\Decoder;
use ReportDecoder\Entity\EntityCloud;
use ReportDecoder\Exceptions\DecoderException;

class DecodeCloud extends Decoder {

    public function getExpression() {
        $no_cloud = '(NSC|NCD|CLR|SKC)';
        $layer = '(VV|FEW|SCT|BKN|OVC)([0-9]{3})(CB|TCU)?';
        
        return "/^($no_cloud|($layer)( $layer)?( $layer)?( $layer)?( $layer)?( $layer)?)( )/";
    }

    public function parse($report, &$decoded) {
        $result = $this->match_chunk($report);
        $match = array_map('trim', $result['match']);
        $report = $result['report'];
        
        if(!$match) {
            throw new DecoderException($report, $result['report'], 'Bad format for cloud information', $this);
        } else {
            $clouds = array();
            for($i = 4; $i <= sizeof($match); $i += 3) {
                if(empty($match[$i])) continue;
    
                $clouds[] = array(
                    'cloud' => $match[$i],
                    'alititude' => $match[++$i]
                );
            }

            $decoded->setClouds($clouds);
            $result = $match[0];
        }

        return array(
            'name' => 'clouds',
            'result' => $result,
            'report' => $report,
        );
    }
}
?>