<?php
namespace App\Enums;

enum Category: string
{
    case ALL_CASES = 'جمبع القضايا';
    case EASY_CASES = 'الفضايا اليسيرة';
    case BIG_CASES = 'القضايا غير اليسيرة';
    case ABANDONED_CASES = 'الفضايا المتعثرة';
    case SHORT_CASES = 'القضايا أقل من 180 يوما';
    case OVERLONG_CASES = 'القضايا أكثر من 180 يوما';
    case MORE_THAN_FIVE_SESSIONS_CASES = 'القضايا أكثر من 5 جلسات';
    case LESS_THAN_FIVE_SESSIONS_CASES = 'القضايا لا تتجاوز 5 جلسات';
    case NO_FUTURE_APPOINTMENT_CASES = 'القضايا ليس لها موعد قادم';
    case HAS_FUTURE_APPOINTMENT_CASES = 'القضايا لها موعد قادم';
    case UNDER_CONSIDERATION = 'قيد النظر';
}
