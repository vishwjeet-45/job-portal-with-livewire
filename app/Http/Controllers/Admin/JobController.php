<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Services\QueryFilterService;
use Yajra\DataTables\Facades\DataTables;

class JobController extends Controller
{
    protected $filterService;

    public function __construct(QueryFilterService $filterService)
    {
        $this->filterService = $filterService;
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Job::query();
            return DataTables::of($query)
                ->filter(function ($q) use ($request) {
                    $this->filterService->handle($request, $q);
                })
                ->addColumn('cities.name',function ($row){
                     return $row->cities->pluck('name')->implode(', ') ?: '-';
                })
                ->addColumn('action', function ($row) {

                    return '<button class="btn btn-outline-warning btn-sm mr-2" onclick="openEditModal(' . $row->id . ')">
                                <i class="ri-edit-box-line"></i>
                            </button>' .
                        '
                            <button type="button"
                                    class="btn btn-outline-primary btn-sm delete-button"
                                    data-url="' . route('admin.jobs.show', $row->id) . '"
                                    data-table="dataTable">
                                <i class="ri-eye-line"></i>
                            </button>
                        ';
                })

                ->addIndexColumn()
                ->make(true);
        }

         return view('admin.jobs.index');
    }


    public function create()
    {
        return view('admin.jobs.create');
    }

    public function destroy($id)
    {
        $Job = Job::find($id);
        if (!$Job) {
            return response()->json(['message' => 'Job not found.'], 404);
        }
        $Job->delete();
        return response()->json(['message' => 'Job deleted successfully.']);
    }
}
