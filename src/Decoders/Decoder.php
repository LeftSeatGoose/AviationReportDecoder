<?php
namespace ReportDecoder\Decoders;

abstract class Decoder {

    public function match_chunk($report) {
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
?>