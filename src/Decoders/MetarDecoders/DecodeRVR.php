<?php

/**
 * DecodeRVR.php
 *
 * PHP version 7.2
 *
 * @category Metar
 * @package  ReportDecoder\Decoders\MetarDecoders
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */

namespace ReportDecoder\Decoders\MetarDecoders;

use ReportDecoder\Decoders\Decoder;
use ReportDecoder\Decoders\DecoderInterface;
use ReportDecoder\Entity\EntityRVR;
use ReportDecoder\Entity\Value;
use ReportDecoder\Exceptions\DecoderException;

/**
 * Decodes RVR chunk
 *
 * @category Metar
 * @package  ReportDecoder\Decoders\MetarDecoders
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */
class DecodeRVR extends Decoder implements DecoderInterface
{
    /**
     * Returns the expression for matching the chunk
     * 
     * @return String
     */
    public function getExpression()
    {
        $runway = 'R([0-9]{2}[LCR]?)\/([PM]?([0-9]{4})'
            . 'V)?[PM]?([0-9]{4})(FT)?\/?([UDN]?)';

        return "/^($runway)( $runway)?( $runway)?( $runway)?( )/";
    }

    /**
     * Parses the chunk using the expression
     * 
     * @param String        $report  Remaining report string
     * @param DecodedReport $decoded DecodedReport object
     * 
     * @throws DecoderException
     * 
     * @return Array
     */
    public function parse($report, &$decoded)
    {
        $result = $this->matchChunk($report);
        $match = $result['match'];
        $remaining_report = $result['report'];

        if (!$match) {
            $result = null;
        } else {
            $runways = array();

            for ($i = 1; $i <= 20; $i += 7) {
                if ($match[$i] != null) {

                    $qfu_as_int = Value::toInt($match[$i + 1]);
                    if ($qfu_as_int > 36 || $qfu_as_int < 1) {
                        throw new DecoderException(
                            $report,
                            $remaining_report,
                            'Invalid runway QFU runway visual range information',
                            $this
                        );
                    }

                    if ($match[$i + 5] == 'FT') {
                        $range_unit = Value::UNIT_FEET;
                    } else {
                        $range_unit = Value::UNIT_METRE;
                    }

                    if ($match[$i + 3] != null) {
                        // RVR is variable
                        $rvr_entity = EntityRVR::initWithVariable(
                            $range_unit,
                            $match[$i + 6],
                            Value::toInt($match[$i + 3]),
                            Value::toInt($match[$i + 4])
                        );
                    } else {
                        // RVR has runway designation
                        $rvr_entity = EntityRVR::initWithRunway(
                            $range_unit,
                            $match[$i + 6],
                            $match[$i + 1],
                            Value::toInt($match[$i + 4])
                        );
                    }

                    $decoded->setRunwayVisualRange($rvr_entity);
                }
            }

            $result = array(
                'text' => $match[0],
                'tip' => 'Runways visual range'
            );
        }

        return array(
            'name' => 'rvr',
            'result' => $result,
            'report' => $remaining_report
        );
    }
}
