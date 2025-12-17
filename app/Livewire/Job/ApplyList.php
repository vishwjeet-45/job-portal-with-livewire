<?php

namespace App\Livewire\Job;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\{Job,User};
use App\Models\JobApplication;

class ApplyList extends Component
{
    use WithPagination;

    public $search = '';
    public $col = 3;

    public $job;
    public $openNotes = [];

    public $showNoteModal = false;
    public $noteText = '';
    public $selectedCandidateId = null;

    protected $queryString = ['search'];
    protected $paginationTheme = 'bootstrap';
    public $currentPage;

    public $scheduledModel =false;
    public $scheduleDate;

    public $jobId;

    public $userId;

    public function mount($job)
    {
        $this->currentPage = $this->getPage();

        $this->job = $job;
        // dd($this->applicants);
    }

    public function openNoteModal($candidateId)
    {
        $this->selectedCandidateId = $candidateId;
        $this->noteText = '';
        $this->showNoteModal = true;
    }


    public function saveNote()
    {
        $this->validate([
            'noteText' => 'required|string|min:3',
        ]);

        $candidate = JobApplication::findOrFail($this->selectedCandidateId);

        $candidate->notes()->create([
            'note' => $this->noteText,
            'created_by' => auth()->user()->id
        ]);

        $this->reset(['noteText', 'showNoteModal', 'selectedCandidateId']);

        session()->flash('success', 'Note added successfully');
    }


    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function toggleNotes($candidateId)
    {
        $this->openNotes[$candidateId] =
            !($this->openNotes[$candidateId] ?? false);
    }
    public function updateStatus($jobId, $userId, $status)
    {
        if($status == 'scheduled')
        {
            $this->jobId = $jobId;
            $this->userId = $userId;
            $this->scheduledModel = true;
        }
        JobApplication::where('job_id', $jobId)
            ->where('user_id', $userId)
            ->update([
                'status' => $status,
            ]);

        if($status !== 'scheduled')
        {
            session()->flash('success', 'Status Updated successfully');
        }

        // $this->job = Job::find($jobId);
    }

    public function saveScheduleDate()
    {

        JobApplication::where('job_id',  $this->jobId)
            ->where('user_id', $this->userId)
            ->update([
                'interview_date' => $this->scheduleDate,
            ]);

        session()->flash('success', 'Interview Date Scheduled successfully');
        $this->scheduledModel = false;
    }


   public function render()
    {
        $applicants = $this->job
            ->applicants()
            ->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);

        return view('livewire.job.apply-list', compact('applicants'));
    }

}
