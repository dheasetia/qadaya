<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    protected $fillable = [
        'issue_number',
        'office',
        'issue_date',
        'age',
        'has_future_appointment',
        'status',
        'money_claimed',
        'sessions',
    ];
}
