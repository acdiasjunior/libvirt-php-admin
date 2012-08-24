<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DateTime
 * Example usage
 *   $di = new DateIntervalEnhanced('PT3600S');
 *   $di->recalculate();
 *   // outputs 1:0:0 instead of 0:0:3600 now!
 *   echo $di->format('%H:%i:%s');
 * @author juniordias
 *
 */

namespace LibvirtAdmin;

class DateInterval extends \DateInterval
{
    /* Keep in mind that a year is seen in this class as 365 days, and a month is seen as 30 days.
      It is not possible to calculate how many days are in a given year or month without a point of
      reference in time. */

    public function toSeconds()
    {
        return ($this->y * 365 * 24 * 60 * 60) +
            ($this->m * 30 * 24 * 60 * 60) +
            ($this->d * 24 * 60 * 60) +
            ($this->h * 60 * 60) +
            ($this->i * 60) +
            $this->s;
    }

    public function recalculate()
    {
        $seconds = $this->to_seconds();
        $this->y = floor($seconds / 60 / 60 / 24 / 365);
        $seconds -= $this->y * 31536000;
        $this->m = floor($seconds / 60 / 60 / 24 / 30);
        $seconds -= $this->m * 2592000;
        $this->d = floor($seconds / 60 / 60 / 24);
        $seconds -= $this->d * 86400;
        $this->h = floor($seconds / 60 / 60);
        $seconds -= $this->h * 3600;
        $this->i = floor($seconds / 60);
        $seconds -= $this->i * 60;
        $this->s = $seconds;
    }

    /**
     * A sweet interval formatting, will use the two biggest interval parts.
     * On small intervals, you get minutes and seconds.
     * On big intervals, you get months and days.
     * Only the two biggest parts are used.
     *
     * @param DateTime $start
     * @param DateTime|null $end
     * @return string
     */
    public function formatDateDiff($start, $end = null)
    {
        if (!($start instanceof DateTime)) {
            $start = new DateTime($start);
        }

        if ($end === null) {
            $end = new DateTime();
        }

        if (!($end instanceof DateTime)) {
            $end = new DateTime($start);
        }

        $interval = $end->diff($start);
        $doPlural = function($nb, $str) {
                return $nb > 1 ? $str . 's' : $str;
            }; // adds plurals

        $format = array();
        if ($interval->y !== 0) {
            $format[] = "%y " . $doPlural($interval->y, "year");
        }
        if ($interval->m !== 0) {
            $format[] = "%m " . $doPlural($interval->m, "month");
        }
        if ($interval->d !== 0) {
            $format[] = "%d " . $doPlural($interval->d, "day");
        }
        if ($interval->h !== 0) {
            $format[] = "%h " . $doPlural($interval->h, "hour");
        }
        if ($interval->i !== 0) {
            $format[] = "%i " . $doPlural($interval->i, "minute");
        }
        if ($interval->s !== 0) {
            if (!count($format)) {
                return "less than a minute ago";
            } else {
                $format[] = "%s " . $doPlural($interval->s, "second");
            }
        }

        // We use the two biggest parts
        if (count($format) > 1) {
            $format = array_shift($format) . " and " . array_shift($format);
        } else {
            $format = array_pop($format);
        }

        // Prepend 'since ' or whatever you like
        return $interval->format($format);
    }

}
