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
use Maatwebsite\Excel\Concerns\WithColumnWidths;
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

class IssueExport implements FromQuery, WithMapping, WithHeadings, WithTitle, WithEvents, WithColumnFormatting, WithColumnWidths, WithDrawings
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
        switch ($this->category) {
            case Category::ALL_CASES->value:
                $issues = $query;
                break;
            case Category::ABANDONED_CASES->value:
                $issues = $query->whereBetween('money_claimed', [1, 50000])->where('age', '>', 180);
                break;
            case Category::BIG_CASES->value:
                $issues = $query->where('money_claimed', '>', 50000);
                break;
            case Category::EASY_CASES->value:
                $issues = $query->whereBetween('money_claimed', [1, 50000]);
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
            '',
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
            '#',
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
            'C' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1
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
                $cellRange = 'A1:F1';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(20);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFill()->setFillType(Fill::FILL_SOLID);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFill()->getStartColor()->setARGB('dddddd');
                $event->sheet->getDelegate()->getStyle($cellRange)->getalignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $row_count = $this->query()->count();
                $all_cell_range = 'A1:F' . $row_count + 1;
                $data_cell_range = 'A2:F' . $row_count + 4;
                $event->sheet->getDelegate()->getStyle($all_cell_range)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                $event->sheet->getDelegate()->getStyle($data_cell_range)->getFont()->setSize(18);


                for ($i = 2; $i < $row_count + 2; $i++) {
                    //easy issues
                    $event->sheet->getDelegate()->getCell('A' . $i)->setValue($i-1);
                    $value = $event->sheet->getDelegate()->getCell('C' . $i)->getValue();
                    if ($value > 50000 || $value == 0) {
                        $event->sheet->getDelegate()->getStyle('C' . $i)->getFill()->setFillType(Fill::FILL_SOLID);
                        $event->sheet->getDelegate()->getStyle('C' . $i)->getFill()->getStartColor()->setARGB('bebfbf');
                        $event->sheet->getDelegate()->getStyle('C' . $i)->getFont()->getColor()->setARGB('454646');
                    } else {
                        $age = $event->sheet->getDelegate()->getCell('F' . $i)->getValue();
                        if ($age > 90) {
                            $event->sheet->getDelegate()->getStyle('C' . $i)->getFill()->setFillType(Fill::FILL_SOLID);
                            $event->sheet->getDelegate()->getStyle('C' . $i)->getFill()->getStartColor()->setARGB('fa6e7e');
                            $event->sheet->getDelegate()->getStyle('C' . $i)->getFont()->getColor()->setARGB('d11b2d');
                        } else {
                            $event->sheet->getDelegate()->getStyle('C' . $i)->getFill()->setFillType(Fill::FILL_SOLID);
                            $event->sheet->getDelegate()->getStyle('C' . $i)->getFill()->getStartColor()->setARGB('b0ffe2');
                            $event->sheet->getDelegate()->getStyle('C' . $i)->getFont()->getColor()->setARGB('0d9e53');
                        }

                    }

                    //future appointment
                    $appointment_value = $event->sheet->getDelegate()->getCell('D' . $i)->getValue();
                    if ($appointment_value === 'لا') {
                        $event->sheet->getDelegate()->getStyle('D' . $i)->getFill()->setFillType(Fill::FILL_SOLID);
                        $event->sheet->getDelegate()->getStyle('D' . $i)->getFill()->getStartColor()->setARGB('fa6e7e');
                        $event->sheet->getDelegate()->getStyle('D' . $i)->getFont()->getColor()->setARGB('d11b2d');
                    } else {
                        $event->sheet->getDelegate()->getStyle('D' . $i)->getFill()->setFillType(Fill::FILL_SOLID);
                        $event->sheet->getDelegate()->getStyle('D' . $i)->getFill()->getStartColor()->setARGB('b0ffe2');
                        $event->sheet->getDelegate()->getStyle('D' . $i)->getFont()->getColor()->setARGB('0d9e53');

                    }

                    // five sessions
                    $session_value = $event->sheet->getDelegate()->getCell('E' . $i)->getValue();
                    if ($session_value <= 3) {
                        $event->sheet->getDelegate()->getStyle('E' . $i)->getFill()->setFillType(Fill::FILL_SOLID);
                        $event->sheet->getDelegate()->getStyle('E' . $i)->getFill()->getStartColor()->setARGB('b0ffe2');
                        $event->sheet->getDelegate()->getStyle('E' . $i)->getFont()->getColor()->setARGB('0d9e53');
                    } elseif ($session_value == 4) {
                        $event->sheet->getDelegate()->getStyle('E' . $i)->getFill()->setFillType(Fill::FILL_SOLID);
                        $event->sheet->getDelegate()->getStyle('E' . $i)->getFill()->getStartColor()->setARGB('FFA500');
                        $event->sheet->getDelegate()->getStyle('E' . $i)->getFont()->getColor()->setARGB('AE6D06');
                    } else {
                        $event->sheet->getDelegate()->getStyle('E' . $i)->getFill()->setFillType(Fill::FILL_SOLID);
                        $event->sheet->getDelegate()->getStyle('E' . $i)->getFill()->getStartColor()->setARGB('fa6e7e');
                        $event->sheet->getDelegate()->getStyle('E' . $i)->getFont()->getColor()->setARGB('d11b2d');

                    }

                    // age
                    $age_value = $event->sheet->getDelegate()->getCell('F' . $i)->getValue();
                    if ($age_value <= 150) {
                        $event->sheet->getDelegate()->getStyle('F' . $i)->getFill()->setFillType(Fill::FILL_SOLID);
                        $event->sheet->getDelegate()->getStyle('F' . $i)->getFill()->getStartColor()->setARGB('b0ffe2');
                        $event->sheet->getDelegate()->getStyle('F' . $i)->getFont()->getColor()->setARGB('0d9e53');
                    } elseif ($age_value <= 179) {
                        $event->sheet->getDelegate()->getStyle('F' . $i)->getFill()->setFillType(Fill::FILL_SOLID);
                        $event->sheet->getDelegate()->getStyle('F' . $i)->getFill()->getStartColor()->setARGB('FFA500');
                        $event->sheet->getDelegate()->getStyle('F' . $i)->getFont()->getColor()->setARGB('AE6D06');
                    } else {
                        $event->sheet->getDelegate()->getStyle('F' . $i)->getFill()->setFillType(Fill::FILL_SOLID);
                        $event->sheet->getDelegate()->getStyle('F' . $i)->getFill()->getStartColor()->setARGB('fa6e7e');
                        $event->sheet->getDelegate()->getStyle('F' . $i)->getFont()->getColor()->setARGB('d11b2d');

                    }

                }
                /*
                 * todo: buat kolom:
                 * إجمالي القضايا اليسيرة
                 * إجمالي القضايا غير المتعثرة
                 * إجمالي القضايا المتعثرة
                 * إجمالي القضايا غير اليسيرة
                 * إجمالي القضايا بالجلسات أقل من ٤ جلسات
                 * إجمالي القضايا بأربع جلسات
                 * إجمالي القضايا بأكثر من ٥ جلسات
                 * إجمالي القضايا بعمرها ١٨٠ يوما فأقل
                 * إجمالي القضايا بعمرها دأكثر من ١٨٠ يوما
                 */



                $row_count+=3;
                $summary_cell_range = 'A' . $row_count . ':F' . $row_count + 2;
                $event->sheet->getDelegate()->getStyle($summary_cell_range)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                $event->sheet->getDelegate()->getStyle($summary_cell_range)->getFont()->setSize(18);

                $event->sheet->getDelegate()->mergeCells('A' . $row_count . ':B' . $row_count+2);
                $event->sheet->getDelegate()->setCellValue('A' . $row_count, 'إجمالي ' . PHP_EOL . ' عدد القضايا: ' . Issue::where('office', $this->office)->count());
                $event->sheet->getDelegate()->getStyle('A' . $row_count)->getalignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('A' . $row_count)->getalignment()->setVertical(Alignment::VERTICAL_CENTER);

                $event->sheet->getDelegate()->setCellValue('C' . $row_count, ' اليسيرة غير المتعثرة: ' . Issue::where('office', $this->office)->where('money_claimed' , '<=', 50000)->where('age', '<=', 90)->count());
                $event->sheet->getDelegate()->getStyle('C' . $row_count)->getFill()->setFillType(Fill::FILL_SOLID);
                $event->sheet->getDelegate()->getStyle('C' . $row_count)->getFill()->getStartColor()->setARGB('b0ffe2');
                $event->sheet->getDelegate()->getStyle('C' . $row_count)->getFont()->getColor()->setARGB('0d9e53');

                $row_count++;
                $event->sheet->getDelegate()->setCellValue('C' . $row_count, ' اليسيرة المتعثرة: ' . Issue::where('office', $this->office)->where('money_claimed' , '<=', 50000)->where('age', '>', 90)->count() );
                $event->sheet->getDelegate()->getStyle('C' . $row_count)->getFill()->setFillType(Fill::FILL_SOLID);
                $event->sheet->getDelegate()->getStyle('C' . $row_count)->getFill()->getStartColor()->setARGB('fa6e7e');
                $event->sheet->getDelegate()->getStyle('C' . $row_count)->getFont()->getColor()->setARGB('d11b2d');

                $row_count++;
                $event->sheet->getDelegate()->setCellValue('C' . $row_count, ' غير اليسيرة: ' . Issue::where('office', $this->office)->where('money_claimed' , '>', 50000)->count() );
                $event->sheet->getDelegate()->getStyle('C'. $row_count)->getFill()->setFillType(Fill::FILL_SOLID);
                $event->sheet->getDelegate()->getStyle('C'. $row_count)->getFill()->getStartColor()->setARGB('bebfbf');
                $event->sheet->getDelegate()->getStyle('C'. $row_count)->getFont()->getColor()->setARGB('454646');

                $row_count-=2;
                $event->sheet->getDelegate()->setCellValue('D' . $row_count, ' لها موعد قادم: ' . Issue::where('office', $this->office)->where('has_future_appointment' , '=', 'نعم')->count());
                $event->sheet->getDelegate()->getStyle('D' . $row_count)->getFill()->setFillType(Fill::FILL_SOLID);
                $event->sheet->getDelegate()->getStyle('D' . $row_count)->getFill()->getStartColor()->setARGB('b0ffe2');
                $event->sheet->getDelegate()->getStyle('D' . $row_count)->getFont()->getColor()->setARGB('0d9e53');

                $row_count++;
                $event->sheet->getDelegate()->setCellValue('D' . $row_count, ' ليس لها موعد قادم: ' . Issue::where('office', $this->office)->where('has_future_appointment' , '=', 'لا')->count());
                $event->sheet->getDelegate()->getStyle('D' . $row_count)->getFill()->setFillType(Fill::FILL_SOLID);
                $event->sheet->getDelegate()->getStyle('D' . $row_count)->getFill()->getStartColor()->setARGB('fa6e7e');
                $event->sheet->getDelegate()->getStyle('D' . $row_count)->getFont()->getColor()->setARGB('d11b2d');



                $row_count-=1;
                $event->sheet->getDelegate()->setCellValue('E' . $row_count, ' أقل من أربع جلسات: ' . Issue::where('office', $this->office)->where('sessions' , '<', 4)->count());
                $event->sheet->getDelegate()->getStyle('E' . $row_count)->getFill()->setFillType(Fill::FILL_SOLID);
                $event->sheet->getDelegate()->getStyle('E' . $row_count)->getFill()->getStartColor()->setARGB('b0ffe2');
                $event->sheet->getDelegate()->getStyle('E' . $row_count)->getFont()->getColor()->setARGB('0d9e53');

                $row_count++;
                $event->sheet->getDelegate()->setCellValue('E' . $row_count, '  أربع جلسات: '. Issue::where('office', $this->office)->where('sessions' , '=', 4)->count());
                $event->sheet->getDelegate()->getStyle('E' . $row_count)->getFill()->setFillType(Fill::FILL_SOLID);
                $event->sheet->getDelegate()->getStyle('E' . $row_count)->getFill()->getStartColor()->setARGB('FFA500');
                $event->sheet->getDelegate()->getStyle('E' . $row_count)->getFont()->getColor()->setARGB('AE6D06');


                $row_count++;
                $event->sheet->getDelegate()->setCellValue('E' . $row_count, '  خمس جلسات فأكثر: ' . Issue::where('office', $this->office)->where('sessions' , '>', 4)->count());
                $event->sheet->getDelegate()->getStyle('E' . $row_count)->getFill()->setFillType(Fill::FILL_SOLID);
                $event->sheet->getDelegate()->getStyle('E' . $row_count)->getFill()->getStartColor()->setARGB('b0ffe2');
                $event->sheet->getDelegate()->getStyle('E' . $row_count)->getFont()->getColor()->setARGB('0d9e53');

                $row_count-=2;
                $event->sheet->getDelegate()->setCellValue('F' . $row_count, ' عمرها ١٥٠ يوما فأقل: ' . Issue::where('office', $this->office)->where('age' , '<=', 150)->count());
                $event->sheet->getDelegate()->getStyle('F'. $row_count)->getFill()->setFillType(Fill::FILL_SOLID);
                $event->sheet->getDelegate()->getStyle('F'. $row_count)->getFill()->getStartColor()->setARGB('b0ffe2');
                $event->sheet->getDelegate()->getStyle('F'. $row_count)->getFont()->getColor()->setARGB('0d9e53');

                $row_count++;
                $event->sheet->getDelegate()->setCellValue('F' . $row_count, ' عمرها بين ١٥١ إلى ١٧٩ يوما: ' . Issue::where('office', $this->office)->whereBetween('age' , [151, 179] )->count());
                $event->sheet->getDelegate()->getStyle('F' . $row_count)->getFill()->setFillType(Fill::FILL_SOLID);
                $event->sheet->getDelegate()->getStyle('F' . $row_count)->getFill()->getStartColor()->setARGB('FFA500');
                $event->sheet->getDelegate()->getStyle('F' . $row_count)->getFont()->getColor()->setARGB('AE6D06');

                $row_count++;
                $event->sheet->getDelegate()->setCellValue('F' . $row_count, ' عمرها ١٨٠ يوما فأكثر: ' . Issue::where('office', $this->office)->where('age' , '>=', 180)->count());
                $event->sheet->getDelegate()->getStyle('F' . $row_count)->getFill()->setFillType(Fill::FILL_SOLID);
                $event->sheet->getDelegate()->getStyle('F' . $row_count)->getFill()->getStartColor()->setARGB('fa6e7e');
                $event->sheet->getDelegate()->getStyle('F' . $row_count)->getFont()->getColor()->setARGB('d11b2d');


        }
        ];
    }
    public function drawings()
    {
        $my_drawings = [];
        $count = 2;

        foreach ($this->query()->get() as $row) {
            if ($row->age <= 150) {
                $drawing = new Drawing();
                $drawing->setPath(public_path('src/assets/img/yes.png'));
                $drawing->setHeight(25);
                $drawing->setCoordinates('F' . $count);
                $drawing->setOffsetX(270);
                $drawing->setOffsetY(5);
                $my_drawings[] = $drawing;
            } else {
                if ($row->age <= 179) {
                    $drawing = new Drawing();
                    $drawing->setPath(public_path('src/assets/img/warning.png'));
                    $drawing->setHeight(25);
                    $drawing->setCoordinates('F' . $count);
                    $drawing->setOffsetX(270);
                    $drawing->setOffsetY(5);
                    $my_drawings[] = $drawing;
                } else {
                    $drawing = new Drawing();
                    $drawing->setPath(public_path('src/assets/img/close.png'));
                    $drawing->setHeight(25);
                    $drawing->setCoordinates('F' . $count);
                    $drawing->setOffsetX(270);
                    $drawing->setOffsetY(5);
                    $my_drawings[] = $drawing;
                }
            }
            $count++;
        }


        $count++;
        $drawing_close = new Drawing();
        $drawing_close->setPath(public_path('src/assets/img/yes.png'));
        $drawing_close->setHeight(25);
        $drawing_close->setCoordinates('F' . $count);
        $drawing_close->setOffsetX(270);
        $drawing_close->setOffsetY(5);
        $my_drawings[] = $drawing_close;
        $count++;

        $drawing_warning = new Drawing();
        $drawing_warning->setPath(public_path('src/assets/img/warning.png'));
        $drawing_warning->setHeight(25);
        $drawing_warning->setCoordinates('F' . $count);
        $drawing_warning->setOffsetX(270);
        $drawing_warning->setOffsetY(5);
        $my_drawings[] = $drawing_warning;
        $count++;

        $drawing_yes = new Drawing();
        $drawing_yes->setPath(public_path('src/assets/img/close.png'));
        $drawing_yes->setHeight(25);
        $drawing_yes->setCoordinates('F' . $count);
        $drawing_yes->setOffsetX(270);
        $drawing_yes->setOffsetY(5);
        $my_drawings[] = $drawing_yes;

        return $my_drawings;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 6,
            'B' => 22,
            'C' => 28,
            'D' => 25,
            'E' => 28,
            'F' => 39,
        ];
    }

}
