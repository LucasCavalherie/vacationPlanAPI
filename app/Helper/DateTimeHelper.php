<?php

namespace App\Helper;

use Carbon\Carbon;

abstract class DateTimeHelper
{
    static function formatDate(Carbon $date): string
    {
        return Carbon::parse($date)->format('Y-m-d');
    }
}
