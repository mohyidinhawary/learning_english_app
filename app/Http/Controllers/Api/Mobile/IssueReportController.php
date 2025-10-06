<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\IssueReportRequest;
use App\Models\IssueReport;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder as RB;

class IssueReportController extends Controller
{
    public function store(IssueReportRequest $request)
    {
        $report = IssueReport::create([
            'user_id'     => auth()->id(),
            'type'        => $request->type,
            'description' => $request->description,
        ]);

        return RB::success([
            'message' => 'تم إرسال البلاغ بنجاح ✅',
            'report'  => $report,
        ]);
    }

    public function index()
    {
        $reports = IssueReport::with('user')->latest()->paginate(10);

        return RB::success($reports);
    }
}
