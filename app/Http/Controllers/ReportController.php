<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use Illuminate\Http\Request;
use App\Enums\Category;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
//        $offices = Issue::all()->pluck('office');
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

    public function reports_query(Request $request)
    {
        $offices = DB::table('issues')->pluck('office');
        $office = $request->office;
        $category = $request->category;
        $query = Issue::where('office', $office);
        $issues = $query->get();

        switch ($category) {
            case Category::ABANDONED_CASES->value:
                $issues = $query->where('money_claimed', '<=', 50000)->where('age', '>', 180)->get();
                break;
            case Category::BIG_CASES->value:
                $issues = $query->where('money_claimed', '>', 50000)->get();
                break;
            case Category::EASY_CASES->value:
                $issues = $query->where('money_claimed', '<=', 50000)->get();
                break;
            case Category::OVERLONG_CASES->value:
                $issues = $query->where('age', '>', 180)->get();
                break;
            case Category::SHORT_CASES->value:
                $issues = $query->where('age', '<=', 180)->get();
                break;
            case Category::LESS_THAN_FIVE_SESSIONS_CASES->value:
                $issues = $query->where('sessions', '<=', 5)->get();
                break;
            case Category::MORE_THAN_FIVE_SESSIONS_CASES->value:
                $issues = $query->where('sessions', '>', 5)->get();
                break;
            case Category::NO_FUTURE_APPOINTMENT_CASES->value:
                $issues = $query->where('has_future_appointment', 'لا')->get();
                break;
            case Category::HAS_FUTURE_APPOINTMENT_CASES->value:
                $issues = $query->where('has_future_appointment', 'نعم')->get();
                break;
            default:
                $issues = $query->get();
        }
        return $issues;
    }
}
