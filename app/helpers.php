<?php

function getPercentOfSum($sum, $percent)
{
    return ($percent / 100) * $sum;
}

function getFormattedTime($value)
{
    try {
        $dt = new DateTime($value);
    } catch (Exception $e) {
    }

    $formatter = new IntlDateFormatter('bg_BG', IntlDateFormatter::FULL, IntlDateFormatter::SHORT);
    $formatter->setPattern('E dd, MMMM, yyyy - HH:mm ');

    return $formatter->format($dt);
}
