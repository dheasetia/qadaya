<?php

namespace App\Http\Controllers;

use App\Imports\IssueImport;
use App\Models\Issue;
use App\Models\IssueFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class IssueController extends Controller
{
    public function index()
    {
        $issues = Issue::all();
        return view('issues.index', compact('issues'));
    }
    public function import()
    {
        return view('issues.import');
    }

    public function importStore(Request $request)
    {
        $issues = Issue::all();
        foreach ($issues as $issue) {
            $issue->delete();
        }
        $files = IssueFile::all();
        foreach ($files as $file) {
            $file->delete();
        }
        Excel::import(new IssueImport, $request->file('excel_file'));
        toastify()->success('تم استيراد البيانات');
        return redirect(url('/issues'));
    }

    public function easy()
    {
        $issues = Issue::where('money_claimed', '<', 50000)->get();
        return view('issues.easy', compact('issues'));
    }

    public function no_appointment()
    {
        $issues = Issue::where('has_future_appointment', 'لا')->get();
        return view('issues.no-appointment', compact('issues'));
    }
    public function more_than_five_sessions()
    {
        $issues = Issue::where('sessions', '>', 5)->get();
        return view('issues.more-than-five-sessions', compact('issues'));
    }
    public function over_age()
    {
        $issues = Issue::where('age', '>', 180)->get();
        return view('issues.over-age', compact('issues'));
    }
    public function drop_data()
    {
        return view('issues.drop_data');
    }

    public function post_drop_database()
    {
        $issues = Issue::all();
        foreach ($issues as $issue) {
            $issue->delete();
        }
        toastify()->success('تم حذف جميع البيانات');

        return redirect('/issues');
    }

    public function report()
    {
        $current_office = null;
        $offices = DB::table('issues')->distinct()->pluck('office');
        $issues = null;
        $easy_issues_count = 0;
        $no_next_appointment_count = 0;
        $five_sessions_count = 0;
        $old_issues_count = 0;
        $total_warning = 0;
        $easy_issues_late_count = 0;
        $easy_issues_not_late_count = 0;
        $issues_data = [
            'total' => 0,
            'considerable' => 0,
        ];
        return view('issues.report', compact('current_office', 'offices', 'issues', 'issues_data', 'easy_issues_count', 'easy_issues_late_count', 'easy_issues_not_late_count', 'no_next_appointment_count', 'five_sessions_count', 'old_issues_count', 'total_warning'));
    }

    public function post_report(Request $request)
    {
        $office = $request->office;
        $current_office = 'بدون';
        $offices = DB::table('issues')->distinct()->pluck('office');
        $issues = null;
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

        }
//        return $issues_data;

        return view('issues.report', compact('current_office', 'offices', 'issues', 'easy_issues_count', 'easy_issues_late_count', 'easy_issues_not_late_count', 'no_next_appointment_count', 'five_sessions_count', 'old_issues_count', 'total_warning'));
    }

    public function bulk_reports()
    {
        $offices = DB::table('issues')->distinct()->pluck('office');
        $files = IssueFile::all()->pluck('office_name');
        return view('issues.bulk-reports', compact('offices', 'files'));
    }



}
