<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use App\Services\QueryFilterService;
use Yajra\DataTables\Facades\DataTables;
use App\Models\User;

class CandidateController extends Controller
{
     protected $filterService;

    public function __construct(QueryFilterService $filterService)
    {
        $this->filterService = $filterService;
    }

    public function index(Request $request)
    {

        $roleName = 'Candidates';
        if ($request->ajax()) {
            $roleName = 'Candidates';
            $role = Role::where('name', $roleName)->first();
            $query = $role->users()->getQuery();
            return DataTables::of($query)
                ->filter(function ($q) use ($request) {
                    $this->filterService->handle($request, $q);
                })
                ->addColumn('name', function ($row) {
                    return "<span class='nameTexts'>{$row->name}</span><br>{$row->email}";
                })
                ->addColumn('status', function ($row) {
                        $checked = $row->status == 'active' ? 'checked' : '';
                        return '
                            <div class="form-check form-switch">
                                <input class="form-check-input toggle-status" type="checkbox"
                                    data-id="' . $row->id . '"
                                    ' . $checked . '>
                            </div>
                        ';
                    })

                ->addColumn('action', function ($row) {
                    return '
                        <button class="btn btn-outline-warning btn-sm mx-2" onclick="openEditModal(' . e((string) $row->id) . ')">
                            <i class="ri-edit-box-line"></i>
                        </button>
                        <button type="button"
                                class="btn btn-outline-danger btn-sm delete-button"
                                data-url="' . route('admin.candidates.destroy', $row->id) . '"
                                data-table="dataTable">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    ';
                })

                ->addIndexColumn()
                 ->rawColumns(['name', 'action','status'])
                ->make(true);
        }

        return view('admin.candidates.index', compact('roleName'));
    }
}
