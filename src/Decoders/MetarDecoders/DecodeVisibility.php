<?php

/**
 * DecodeVisibility.php
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
use ReportDecoder\Entity\EntityVisibility;
use ReportDecoder\Entity\Value;
use ReportDecoder\Exceptions\DecoderException;

/**
 * Decodes Visibility chunk
 *
 * @category Metar
 * @package  ReportDecoder\Decoders\MetarDecoders
 * @author   Jamie Thirkell <jamie@jamieco.ca>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html  GNU v3.0
 * @link     https://github.com/TipsyAviator/AviationReportDecoder
 */
class DecodeVisibility extends Decoder implements DecoderInterface
{
    /**
     * Returns the expression for matching the chunk
     * 
     * @return String
     */
    public function getExpression()
    {
        $cavok = 'CAVOK';
        $visibility = '([0-9]{4})(NDV)?';
        $minimum_visibility = '( ([0-9]{4})(N|NE|E|SE|S|SW|W|NW)?)?';
        $us_visibility = 'M?([0-9]{0,2}) ?(([1357])\/(2|4|8|16))?SM';
        $km_visibility = '([0-9][05])(KM)?(NDV)?';
        $no_info = '\/\/\/\/';

        return "/^($cavok|$visibility$minimum_visibility"
            . "$minimum_visibility$minimum_visibility"
            . "$minimum_visibility|$us_visibility|"
            . "$km_visibility|$no_info)( )/";
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
            throw new DecoderException(
                $report,
                $remaining_report,
                'Bad format for visibility information',
                $this
            );
        }

        $cavok = false;

        if ($match[1] ==  'CAVOK') {
            $decoded->setCavok(true);
            $result = null;
        } elseif ($match[1] == '////') {
            $decoded->setCavok(false);
            $result = [
                'text' => $match[0],
                'tip' => 'Ground visibility not measured'
            ];
        } else {
            $decoded->setCavok(false);

            if ($match[2] != null) {
                // ICAO Visibility
                $visibility = new EntityVisibility(
                    new Value(
                        Value::toInt($match[2]),
                        Value::UNIT_METRE
                    )
                );

                $visibility->setNDV($match[3] != null);

                if ($match[4] != null) {
                    $visibility->setSectorVisibility(
                        new Value(
                            Value::toInt($match[5]),
                            Value::UNIT_METRE
                        ),
                        $match[6]
                    );
                }
                if ($match[7] != null) {
                    $visibility->setSectorVisibility(
                        new Value(
                            Value::toInt($match[8]),
                            Value::UNIT_METRE
                        ),
                        $match[9]
                    );
                }
                if ($match[10] != null) {
                    $visibility->setSectorVisibility(
                        new Value(
                            Value::toInt($match[11]),
                            Value::UNIT_METRE
                        ),
                        $match[12]
                    );
                }
                if ($match[13] != null) {
                    $visibility->setSectorVisibility(
                        new Value(
                            Value::toInt($match[14]),
                            Value::UNIT_METRE
                        ),
                        $match[15]
                    );
                }

                $decoded->setVisibility($visibility);
            } else if ($match[20] != null) {
                // KM Visibility
                $decoded->setVisibility(
                    new EntityVisibility(
                        new Value(
                            Value::toInt($match[20]),
                            Value::UNIT_KILOMETRE
                        )
                    )
                );
            } else {
                // US Visibility
                $main = intval($match[16]);
                $frac_top = intval($match[18]);
                $frac_bot = intval($match[19]);

                if ($frac_bot != 0) {
                    $vis_value = $main + $frac_top / $frac_bot;
                } else {
                    $vis_value = $main;
                }

                $decoded->setVisibility(
                    new EntityVisibility(
                        new Value(
                            Value::toInt($vis_value),
                            Value::UNIT_STATUTE_MILE
                        )
                    )
                );
            }

            $result = [
                'text' => $match[0],
                'tip' => 'Ground visibility is ' . $match[0]
            ];
        }

        return [
            'name' => 'visibility',
            'result' => $result,
            'report' => $remaining_report
        ];
    }
}
