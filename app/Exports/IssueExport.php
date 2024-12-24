<?php

namespace App\Exports;

use App\Enums\Category;
use App\Models\Issue;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Sheet;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;

class IssueExport implements FromQuery, WithMapping, WithHeadings, WithTitle, WithEvents, WithColumnFormatting, ShouldAutoSize, WithDrawings
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
                $cellRange = 'A1:E1';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(20);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFill()->setFillType(Fill::FILL_SOLID);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFill()->getStartColor()->setARGB('dddddd');
                $event->sheet->getDelegate()->getStyle($cellRange)->getalignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $row_count = $this->query()->count();
                $all_cell_range = 'A1:E' . $row_count + 1;
                $data_cell_range = 'A2:E' . $row_count + 4;
                $event->sheet->getDelegate()->getStyle($all_cell_range)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                $event->sheet->getDelegate()->getStyle($data_cell_range)->getFont()->setSize(18);


                for ($i = 2; $i < $row_count + 2; $i++) {
                    //easy issues
                    $value = $event->sheet->getDelegate()->getCell('B' . $i)->getValue();
                    if ($value > 50000) {
                        $event->sheet->getDelegate()->getStyle('B' . $i)->getFill()->setFillType(Fill::FILL_SOLID);
                        $event->sheet->getDelegate()->getStyle('B' . $i)->getFill()->getStartColor()->setARGB('fa6e7e');
                        $event->sheet->getDelegate()->getStyle('B' . $i)->getFont()->getColor()->setARGB('d11b2d');
                    } else {
                        $event->sheet->getDelegate()->getStyle('B' . $i)->getFill()->setFillType(Fill::FILL_SOLID);
                        $event->sheet->getDelegate()->getStyle('B' . $i)->getFill()->getStartColor()->setARGB('b0ffe2');
                        $event->sheet->getDelegate()->getStyle('B' . $i)->getFont()->getColor()->setARGB('0d9e53');
                    }

                    //future appointment
                    $appointment_value = $event->sheet->getDelegate()->getCell('C' . $i)->getValue();
                    if ($appointment_value === 'لا') {
                        $event->sheet->getDelegate()->getStyle('C' . $i)->getFill()->setFillType(Fill::FILL_SOLID);
                        $event->sheet->getDelegate()->getStyle('C' . $i)->getFill()->getStartColor()->setARGB('fa6e7e');
                        $event->sheet->getDelegate()->getStyle('C' . $i)->getFont()->getColor()->setARGB('d11b2d');

                    } else {
                        $event->sheet->getDelegate()->getStyle('C' . $i)->getFill()->setFillType(Fill::FILL_SOLID);
                        $event->sheet->getDelegate()->getStyle('C' . $i)->getFill()->getStartColor()->setARGB('b0ffe2');
                        $event->sheet->getDelegate()->getStyle('C' . $i)->getFont()->getColor()->setARGB('0d9e53');

                    }

                    // five sessions
                    $appointment_value = $event->sheet->getDelegate()->getCell('D' . $i)->getValue();
                    if ($appointment_value > 5) {
                        $event->sheet->getDelegate()->getStyle('D' . $i)->getFill()->setFillType(Fill::FILL_SOLID);
                        $event->sheet->getDelegate()->getStyle('D' . $i)->getFill()->getStartColor()->setARGB('fa6e7e');
                        $event->sheet->getDelegate()->getStyle('D' . $i)->getFont()->getColor()->setARGB('d11b2d');

                    } else {
                        $event->sheet->getDelegate()->getStyle('D' . $i)->getFill()->setFillType(Fill::FILL_SOLID);
                        $event->sheet->getDelegate()->getStyle('D' . $i)->getFill()->getStartColor()->setARGB('b0ffe2');
                        $event->sheet->getDelegate()->getStyle('D' . $i)->getFont()->getColor()->setARGB('0d9e53');

                    }

                    // age
                    $age_value = $event->sheet->getDelegate()->getCell('E' . $i)->getValue();
                    if ($appointment_value > 180) {
                        $event->sheet->getDelegate()->getStyle('E' . $i)->getFill()->setFillType(Fill::FILL_SOLID);
                        $event->sheet->getDelegate()->getStyle('E' . $i)->getFill()->getStartColor()->setARGB('fa6e7e');
                        $event->sheet->getDelegate()->getStyle('E' . $i)->getFont()->getColor()->setARGB('d11b2d');

                    } else {
                        $event->sheet->getDelegate()->getStyle('E' . $i)->getFill()->setFillType(Fill::FILL_SOLID);
                        $event->sheet->getDelegate()->getStyle('E' . $i)->getFill()->getStartColor()->setARGB('b0ffe2');
                        $event->sheet->getDelegate()->getStyle('E' . $i)->getFont()->getColor()->setARGB('0d9e53');

                    }

                }
                $event->sheet->getDelegate()->setCellValue('B' . $row_count + 2, 'فضية غير يسيرة');
                $event->sheet->getDelegate()->setCellValue('B' . $row_count + 3, 'فضية يسيرة متعفرة');
                $event->sheet->getDelegate()->setCellValue('B' . $row_count + 4, 'فضية يسيرة غير متعثرة');
            }
        ];
    }
    public function drawings()
    {
        $my_drawings = [];
        $count = 2;

        foreach ($this->query()->get() as $row) {
            if ($row->money_claimed > 50000) {
                $drawing = new Drawing();
                $drawing->setPath(public_path('src/assets/img/close.png'));
                $drawing->setHeight(25);
                $drawing->setCoordinates('B' . $count);
                $drawing->setOffsetX(220);
                $drawing->setOffsetY(5);
                $my_drawings[] = $drawing;
            } else {
                if ($row->age > 90) {
                    $drawing = new Drawing();
                    $drawing->setPath(public_path('src/assets/img/warning.png'));
                    $drawing->setHeight(25);
                    $drawing->setCoordinates('B' . $count);
                    $drawing->setOffsetX(220);
                    $drawing->setOffsetY(5);
                    $my_drawings[] = $drawing;
                } else {
                    $drawing = new Drawing();
                    $drawing->setPath(public_path('src/assets/img/yes.png'));
                    $drawing->setHeight(25);
                    $drawing->setCoordinates('B' . $count);
                    $drawing->setOffsetX(220);
                    $drawing->setOffsetY(5);
                    $my_drawings[] = $drawing;
                }
            }
            $count++;
        }


        $drawing_close = new Drawing();
        $drawing_close->setPath(public_path('src/assets/img/close.png'));
        $drawing_close->setHeight(25);
        $drawing_close->setCoordinates('A' . $count);
        $drawing_close->setOffsetX(180);
        $drawing_close->setOffsetY(5);
        $my_drawings[] = $drawing_close;
        $count++;

        $drawing_warning = new Drawing();
        $drawing_warning->setPath(public_path('src/assets/img/warning.png'));
        $drawing_warning->setHeight(25);
        $drawing_warning->setCoordinates('A' . $count);
        $drawing_warning->setOffsetX(180);
        $drawing_warning->setOffsetY(5);
        $my_drawings[] = $drawing_warning;
        $count++;

        $drawing_yes = new Drawing();
        $drawing_yes->setPath(public_path('src/assets/img/yes.png'));
        $drawing_yes->setHeight(25);
        $drawing_yes->setCoordinates('A' . $count);
        $drawing_yes->setOffsetX(180);
        $drawing_yes->setOffsetY(5);
        $my_drawings[] = $drawing_yes;



        return $my_drawings;
    }

}
