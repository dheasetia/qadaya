<?php

namespace App\Http\Controllers;

use App\Exports\IssueExport;
use App\Models\Issue;
use Illuminate\Http\Request;
use App\Enums\Category;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $offices = DB::table('issues')->distinct('office')->pluck('office');
        $categories = [
            Category::ALL_CASES->value,
            Category::EASY_CASES->value,
            Category::BIG_CASES->value,
            Category::ABANDONED_CASES->value,
            Category::SHORT_CASES->value,
            Category::OVERLONG_CASES->value,
            Category::MORE_THAN_FIVE_SESSIONS_CASES->value,
            Category::LESS_THAN_FIVE_SESSIONS_CASES->value,
            Category::NO_FUTURE_APPOINTMENT_CASES->value,
            Category::HAS_FUTURE_APPOINTMENT_CASES->value,
            Category::UNDER_CONSIDERATION->value,
        ];
       return view('reports.index', compact('offices', 'categories'));
    }

    public function generate_excel(Request $request)
    {
        return Excel::download(new IssueExport($request->office, $request->category), $request->category . ' - ' . $request->office . '.xlsx');

    }
}
