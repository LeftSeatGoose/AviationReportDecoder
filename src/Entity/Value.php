<?php
namespace ReportDecoder\Entity;

abstract class Value {
    public const UNIT_HPA = 'hPa';
    public const UNIT_INHG = 'inHg';

    public static function toInt($value)
    {
        $letter_signs = array('P', 'M');
        $numeric_signs = array('', '-');

        $value_numeric = str_replace($letter_signs, $numeric_signs, $value);

        if (preg_match('#^[\-0-9]#', $value_numeric)) {
            return intval($value_numeric);
        } else {
            return;
        }
    }
}
?>