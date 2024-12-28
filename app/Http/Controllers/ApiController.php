<?php

namespace App\Http\Controllers;

use App\Exports\IssueExport;
use App\Models\Issue;
use App\Models\IssueFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use PhpParser\Node\Stmt\Return_;
use Spatie\Browsershot\Browsershot;

class ApiController extends Controller
{
    public function generate_pdf()
    {
        $offices = DB::table('issues')->distinct('office')->pluck('office');
        //delete pdfs;
        $deleted_issues = IssueFile::all();
        foreach ($deleted_issues as $deleted_issue) {
            $deleted_issue->delete();
        }
        foreach ($offices as $office) {
            $easy_issues_count = 0;
            $no_next_appointment_count = 0;
            $five_sessions_count = 0;
            $old_issues_count = 0;
            $total_warning = 0;
            $easy_issues_late_count = 0;
            $easy_issues_not_late_count = 0;
            if ($office ==! null) {
                $current_office = $office;
                $offices = DB::table('issues')->distinct()->pluck('office');
                $issues = Issue::where('office', $office)->get();
                $easy_issues_count = $issues->where('money_claimed', '<', 50000)->count();
                $no_next_appointment_count = $issues->where('has_future_appointment', 'لا')->count();
                $five_sessions_count = $issues->where('sessions', '>', 5)->count();
                $old_issues_count = $issues->where('age', '>', 180)->count();
                $easy_issues_late_count = $issues->where('money_claimed', '<', 50000)->where('age', '>', 90)->count();
                $easy_issues_not_late_count = $issues->where('money_claimed', '<', 50000)->where('age', '<=', 90)->count();
                $total_warning = $easy_issues_count + $no_next_appointment_count + $five_sessions_count + $old_issues_count;

                $offices = DB::table('issues')->distinct()->pluck('office');
                $issues = Issue::where('office', $current_office)->get();
                $easy_issues_count = $issues->where('money_claimed', '<', 50000)->count();
                $no_next_appointment_count = $issues->where('has_future_appointment', 'لا')->count();
                $has_next_appointment_count = $issues->where('has_future_appointment', 'نعم')->count();
                $five_sessions_count = $issues->where('sessions', '>', 5)->count();
                $old_issues_count = $issues->where('age', '>', 180)->count();
                $age_more_than_150_days = $issues->where('age', '>', 150)->count();
                $age_less_than_150_days = $issues->where('age', '<=', 150)->count();
                $age_between_151_to_179_days = $issues->where('age', '>', 150)->where('age', '<', 180)->count();
                $not_easy_count = $issues->where('money_claimed', '>', 50000)->count() + $issues->where('money_claimed', '<', 1)->count();
                $easy_issues_late_count = $issues->where('money_claimed', '<=', 50000)->where('age', '>', 90)->where('money_claimed', '<>', 0)->count();
                $easy_issues_not_late_count = $issues->where('money_claimed', '<=', 50000)->where('age', '<=', 90)->where('money_claimed', '<>', 0)->count();
                $less_than_four_sessions_count = $issues->where('sessions', '<', 4)->count();
                $four_session_count = $issues->where('sessions',  4)->count();
                $five_sessions_and_more_count = $issues->where('sessions', '>=', 5)->count();
                $total_warning = $easy_issues_count + $no_next_appointment_count + $five_sessions_count + $old_issues_count;

            }

            $file_name = $current_office . '.pdf';
            $template = view('issues.report-pdf-template', compact('current_office', 'offices', 'issues', 'easy_issues_count', 'age_less_than_150_days', 'easy_issues_late_count', 'not_easy_count', 'age_between_151_to_179_days', 'four_session_count', 'five_sessions_and_more_count', 'age_more_than_150_days', 'less_than_four_sessions_count', 'five_sessions_count', 'easy_issues_not_late_count', 'has_next_appointment_count', 'no_next_appointment_count', 'five_sessions_count', 'old_issues_count', 'total_warning'))->render();
            Browsershot::html($template)->noSandbox()->showBackground()->margins(4, 4, 4, 4)->save(storage_path('app/public/' . $file_name));
            IssueFile::create([
                'office_name' => $file_name
            ]);
        }
        return response()->json([
            'message' => 'success'
        ]);
    }

    public function check_pdf(Request $request)
    {
        $current_office = Issue::first()->office;
        $offices = DB::table('issues')->distinct()->pluck('office');
        $issues = Issue::where('office', $current_office)->get();
        $easy_issues_count = $issues->where('money_claimed', '<', 50000)->count();
        $no_next_appointment_count = $issues->where('has_future_appointment', 'لا')->count();
        $has_next_appointment_count = $issues->where('has_future_appointment', 'نعم')->count();
        $five_sessions_count = $issues->where('sessions', '>', 5)->count();
        $old_issues_count = $issues->where('age', '>', 180)->count();
        $age_more_than_150_days = $issues->where('age', '>', 150)->count();
        $age_less_than_150_days = $issues->where('age', '<=', 150)->count();
        $age_between_151_to_179_days = $issues->where('age', '>', 150)->where('age', '<', 180)->count();
        $not_easy_count = $issues->where('money_claimed', '>', 50000)->count() + $issues->where('money_claimed', '<', 1)->count();
        $easy_issues_late_count = $issues->where('money_claimed', '<=', 50000)->where('age', '>', 90)->where('money_claimed', '<>', 0)->count();
        $easy_issues_not_late_count = $issues->where('money_claimed', '<=', 50000)->where('age', '<=', 90)->where('money_claimed', '>', 0)->count();
        $less_than_four_sessions_count = $issues->where('sessions', '<', 4)->count();
        $four_session_count = $issues->where('sessions',  4)->count();
        $five_sessions_and_more_count = $issues->where('sessions', '>=', 5)->count();
        $total_warning = $easy_issues_count + $no_next_appointment_count + $five_sessions_count + $old_issues_count;
        return view('issues.check_pdf', compact('current_office', 'offices', 'issues', 'easy_issues_count', 'age_less_than_150_days', 'easy_issues_late_count', 'not_easy_count', 'age_between_151_to_179_days', 'four_session_count', 'five_sessions_and_more_count', 'age_more_than_150_days', 'less_than_four_sessions_count', 'five_sessions_count', 'easy_issues_not_late_count', 'has_next_appointment_count', 'no_next_appointment_count', 'five_sessions_count', 'old_issues_count', 'total_warning'))->render();
    }
}
