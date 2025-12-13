<div class="card p-3">

    <!-- GLOBAL SEARCH -->
    <div class="mb-1 row justify-content-end">
        <div class="col-md-{{ $col ?? 3 }}">
            <input type="text" wire:model.live.debounce.400ms="search" class="form-control border rounded px-3"
                placeholder="Search job titles, categories, cities..." style="background:#f4f7fa;">
        </div>
    </div>

    <!-- JOB LIST -->
    <div class="space-y-4">

        <div class="card-body p-0 table-responsive">

            <table class="table tableStyle mb-0 dataTable" id="zero_config_condidates">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col" class="text-center">Last Education</th>
                        <th scope="col" class="text-center">Current Company</th>
                        <th scope="col" class="text-center">Resume</th>
                        <th scope="col" class="text-center">Applied On</th>
                        <th scope="col" class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($applicants as $index => $candidate)
                        <tr>
                            <td>{{ $candidate->name ?? 'N/A' }}</td>
                            <td>
                                {{ $candidate->educations()->first()?->course ?? 'N/A' }}-
                                {{ $candidate->educations()->first()?->university ?? 'N/A' }}
                            </td>
                            <td>
                                 {{ $candidate->currentEmployment->first()->company_name ?? 'N/A' }}
                            </td>
                            <td>
                                @if (!empty($candidate->candidate?->resume))

                                    <a href="{{ asset('storage/'.$candidate->candidate->resume) }}" target="_blank">
                                                        View Resume
                                                    </a>
                                @endif
                            </td>
                            <td>{{ $candidate->pivot->created_at->format('d M, Y') }}</td>
                            <td>
                                <div class="button--group d-flex justify-content-center">
                                   @if ($candidate->pivot->status === 'pending')
                                        <button
                                        type="button"
                                            wire:click="updateStatus({{ $candidate->pivot->job_id }}, {{ $candidate->id }}, 'approved')"
                                            class="btn btn-sm btn-success me-2">
                                            Shortlist
                                        </button>

                                        <button
                                        type="button"
                                            wire:click="updateStatus({{ $candidate->pivot->job_id }}, {{ $candidate->id }}, 'rejected')"
                                            class="btn btn-sm btn-outline-danger border-danger">
                                            Reject
                                        </button>

                                    @else
                                        <span class="badge
                                            @if($candidate->pivot->status === 'approved') bg-success
                                            @elseif($candidate->pivot->status === 'rejected') bg-danger
                                            @else bg-warning
                                            @endif
                                        ">
                                            {{ ucfirst($candidate->pivot->status) }}
                                        </span>

                                    @endif

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-3">No applicants found</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

    </div>
    <div class="mt-4">

         {{ $applicants->links() }}

    </div>
</div>
