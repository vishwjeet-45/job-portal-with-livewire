<div class="card p-3">

    <!-- GLOBAL SEARCH -->
    <div class="mb-1 row justify-content-end">
        <div class="col-md-3">
            <input
                type="text"
                wire:model.live.debounce.400ms="search"
                class="form-control border rounded px-3 py-2"
                placeholder="Search job titles, categories, cities..."
            >
        </div>
    </div>

    <!-- JOB LIST -->
    <div class="space-y-4">

        @forelse ($jobs as $job)
            <div class="border rounded p-4 shadow-sm bg-white my-2">
                <h4 class="font-bold text-lg">{{ $job->title }}</h4>
                <p class="text-sm text-gray-600">{{ $job->company_name }}</p>

                <div class="flex gap-4 text-sm text-gray-700 mt-2">
                    <span>🧰 {{ $job->experience ?? 'Not Disclosed' }}</span>
                    <span>💰 ₹{{ $job->salary_min }} - {{ $job->salary_max }}</span>
                    <span>📍
                        {{ $job->cities->pluck('name')->join(', ') ?: 'Not specified' }}
                    </span>
                </div>

                <p class="mt-3 text-gray-700">
                    {{ Str::limit($job->short_description, 120) }}
                </p>

                <small class="text-gray-500">
                    {{ $job->created_at->diffForHumans() }}
                </small>

            </div>
        @empty

            <div class="text-center py-10 text-gray-500">
                No jobs found.
            </div>

        @endforelse

    </div>
    <div class="mt-4">

        {{ $jobs->links('pagination::bootstrap-5') }}
    </div>
</div>
