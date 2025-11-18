@extends('layouts.admin')

@section('page_heading', 'Job List')
@can('jobs.create')
@section('top_buttion')
    <button type="button" class="btn addButton" data-bs-toggle="modal" data-bs-target="#createModal">
        Add Job
    </button>
@endsection
@endcan
@section('content')
<div class="card borderRadius">
    <div class="card-body table-responsive p-0 px-3">
        <table class="table tableStyle mb-0 dataTable align-middle" id="dataTable" width="100%">
            <thead>
                <tr>
                    <th scope="col" style="width: 50px;">S.N</th>
                    <th scope="col">Name</th>
                    <th scope="col" style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<x-livewire-modal id="createModal" title="Create Job" modal_size="xxl">
    <livewire:job.create />
</x-livewire-modal>
<x-livewire-modal id="editModal" title="Edit Job" modal_size="xxl">
    <livewire:job.edit />
</x-livewire-modal>
@endsection

@push('js')
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        let url = "/admin/jobs";
        initializeDataTable('#dataTable', url, ['id','title','action'], [[1, 'desc']], true);
    });
</script>
@endpush
