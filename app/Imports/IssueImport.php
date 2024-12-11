<?php

namespace App\Imports;

use App\Models\Issue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class IssueImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        $rows->shift();
        foreach ($rows as $row) {
            Issue::create([
                'issue_number' => $row[6],
                'office' => $row[7],
                'issue_date' => $row[5],
                'age' => $row[4],
                'has_future_appointment' => $row[3],
                'status' => $row[2],
                'money_claimed' => $row[1],
                'sessions' => $row[0],
            ]);


//            Issue::create([
//                'issue_number' => $row['رقم القضية'],
//                'office' => $row['الدائرة القضائية'],
//                'issue_date' => $row['تاريخ القيد الهجري'],
//                'age' => $row['عدد الأيام منذ قيد القضية'],
//                'has_future_appointment' => $row['لها موعد قادم'],
//                'status' => $row['حالة القضية'],
//                'money_claimed' => $row['حالة القضية'],
//                'sessions' => $row['عدد الجلسات'],
//            ]);
        }
    }
}
