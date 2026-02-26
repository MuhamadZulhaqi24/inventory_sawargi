<?php

namespace App\Enums;

enum DatePeriod: string
{
    case TODAY = 'today';
    case YESTERDAY = 'yesterday';
    case THIS_WEEK = 'this_week';
    case THIS_MONTH = 'this_month';
    case LAST_MONTH = 'last_month';
    case CUSTOM = 'custom';

    public function label(): string
    {
        return match($this) {
            self::TODAY => __('messages.today'),
            self::YESTERDAY => __('messages.yesterday'),
            self::THIS_WEEK => __('messages.this_week'),
            self::THIS_MONTH => __('messages.this_month'),
            self::LAST_MONTH => __('messages.last_month'),
            self::CUSTOM => __('messages.custom_period'),
        };
    }
}
