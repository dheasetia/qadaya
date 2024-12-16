<?php

namespace App\Exports;

use App\Models\Issue;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EasyIssueExport implements FromQuery
{

    use Exportable;

    public $office;
    public function __construct(string $office)
    {
        $this->office = $office;
    }

    public function query()
    {
        return Issue::query()->where('office', $this->office)->where('money_claimed', '<=', 50000);
    }

    public function view()
    {
        return view('exports.excel.easy_issues', [
            'issues' => $this->query(),
            'office' => $this->office,
        ]);
    }
}
