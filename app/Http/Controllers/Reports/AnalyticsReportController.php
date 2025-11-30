<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reports\GenerateReportRequest;
use App\Services\Reporting\ReportService;

class AnalyticsReportController extends Controller
{
    /**
     * Display the report generation form.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('reports.index');
    }

    /**
     * Generate a new analytics report.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function generate(GenerateReportRequest $request, ReportService $reportService): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validated();

        // Save Template if requested
        if ($request->boolean('save_template')) {
            $reportService->saveTemplate($validated);
        }

        $report = $reportService->generate(
            $validated['report_type'],
            \Illuminate\Support\Arr::except($validated, ['report_type', 'format', 'save_template']),
            $validated['format'],
            null // templateId (future use)
        );

        return redirect()->route('reports.index')
            ->with('success', 'Report generation started. You will be notified when it is ready.')
            ->with('report_id', $report->id);
    }

    /**
     * Get saved report templates.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function templates(\Illuminate\Http\Request $request)
    {
        $templates = \App\Models\ReportTemplate::latest()
            ->paginate(5);

        return response()->json($templates);
    }
    /**
     * Get recent generated reports.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function recent()
    {
        $reports = \App\Models\GeneratedReport::latest()
            ->take(5)
            ->get();

        return response()->json($reports);
    }

    /**
     * Download a generated report.
     *
     * @param string $id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download(string $id)
    {
        $report = \App\Models\GeneratedReport::findOrFail($id);

        if (!file_exists($report->path)) {
            abort(404, 'Report file not found.');
        }

        return response()->download($report->path);
    }


}
