<?php

namespace App\Models\Traits;

use IntlDateFormatter;

trait HumanTime
{
    public function getFormattedTime($value)
    {
        $dt = new \DateTime($value);

        $formatter = new IntlDateFormatter('bg_BG', IntlDateFormatter::FULL, IntlDateFormatter::SHORT);
        $formatter->setPattern('E dd, MMMM, yyyy - HH:mm ');

        return $formatter->format($dt);
    }

    public function getFromMySQL($value)
    {
        $dt = new \DateTime($value);

        $formatter = new IntlDateFormatter('bg_BG', IntlDateFormatter::FULL, IntlDateFormatter::SHORT);
        $formatter->setPattern('YYYY-MM-DD hh:mm:ss');

        return $formatter->format($dt);
    }

    public function updatedAtAsText($date)
    {
        if (!$date) {
            return null;
        }

        $fmt = new IntlDateFormatter(
            'bg',
            IntlDateFormatter::FULL,
            IntlDateFormatter::NONE,
            null,
            null,
            "dd MMMM yyyy"
        );

        return $fmt->format($date->getTimestamp());
    }
}
