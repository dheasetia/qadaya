<?php

namespace App\Exports;

use App\Enums\Category;
use App\Models\Issue;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class IssueExport implements FromQuery, WithMapping, WithHeadings, WithColumnFormatting, ShouldAutoSize, WithStyles, WithTitle, WithEvents
{
    use Exportable;

    public $office;
    public $category;

    public function __construct($office, $category)
    {
        $this->office = $office;
        $this->category = $category;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        $query = Issue::where('office', $this->office);
        $issues = $query;
        switch ($this->category) {
            case Category::ABANDONED_CASES->value:
                $issues = $query->where('money_claimed', '<=', 50000)->where('age', '>', 180);
                break;
            case Category::BIG_CASES->value:
                $issues = $query->where('money_claimed', '>', 50000);
                break;
            case Category::EASY_CASES->value:
                $issues = $query->where('money_claimed', '<=', 50000);
                break;
            case Category::OVERLONG_CASES->value:
                $issues = $query->where('age', '>', 180);
                break;
            case Category::SHORT_CASES->value:
                $issues = $query->where('age', '<=', 180);
                break;
            case Category::LESS_THAN_FIVE_SESSIONS_CASES->value:
                $issues = $query->where('sessions', '<=', 5);
                break;
            case Category::MORE_THAN_FIVE_SESSIONS_CASES->value:
                $issues = $query->where('sessions', '>', 5);
                break;
            case Category::NO_FUTURE_APPOINTMENT_CASES->value:
                $issues = $query->where('has_future_appointment', 'لا');
                break;
            case Category::HAS_FUTURE_APPOINTMENT_CASES->value:
                $issues = $query->where('has_future_appointment', 'نعم');
                break;
            default:
                $issues = $query;
        }
        return $issues;
    }
    public function map($issue): array
    {
        return [
            $issue->issue_number,
            $issue->money_claimed == 0 ? '0' : $issue->money_claimed,
            $issue->has_future_appointment,
            $issue->sessions == 0 ? '0' : $issue->sessions,
            $issue->age,
        ];
    }
    public function headings(): array
    {
        return [
            'رقم القضية',
            'مبلغ المطالبة',
            'لها موعد قادم',
            'الجلسات',
            'عدد الأيام منذ قيد القضية'
        ];
    }
    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => [
                'font' => [
                    'bold' => true,
                    'size' => 16
                ],
                'alignment' => [
                    'horizontal'    => Alignment::HORIZONTAL_CENTER,
                    'vertical'     => Alignment::VERTICAL_CENTER
                ]
            ],
        ];
    }

    public function title(): string
    {
        return $this->category;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->setRightToLeft(true);
            }
        ];
    }
}
