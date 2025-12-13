<?php

namespace App\Livewire\Job;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Job;
use App\Models\JobApplication;

class ApplyList extends Component
{
    use WithPagination;

    public $search = '';
    public $col = 3;

    public $job;


    protected $queryString = ['search'];
    protected $paginationTheme = 'bootstrap';
    public $currentPage;

    public function mount($job)
    {
        $this->currentPage = $this->getPage();

        $this->job = $job;
        // dd($this->applicants);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updateStatus($jobId, $userId, $status)
    {
        JobApplication::where('job_id', $jobId)
            ->where('user_id', $userId)
            ->update([
                'status' => $status,
            ]);
        // $this->job = Job::find($jobId);
    }


    public function render()
    {
        return view('livewire.job.apply-list', [
            'applicants' => $this->job
                ->applicants()
                ->paginate(1),
        ]);
    }
}
