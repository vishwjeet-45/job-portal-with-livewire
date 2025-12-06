<?php

namespace App\Livewire\Job;

use Livewire\Component;
use App\Models\JobApplication;

class Apply extends Component
{

     public $jobId;
    public $alreadyApplied = false;

    public function mount($jobId)
    {
        $this->jobId = $jobId;

        // check already applied
        $this->alreadyApplied = JobApplication::where('job_id', $jobId)
            ->where('user_id', auth()->id())
            ->exists();
    }

    public function apply()
    {

        if ($this->alreadyApplied) return;

        if (!auth()->check()) {
            $this->dispatch('login-required');
            return;
        }
        JobApplication::create([
            'job_id' => $this->jobId,
            'user_id' => auth()->id(),
        ]);

        $this->alreadyApplied = true;

        session()->flash('success', 'You applied successfully!');
    }
    public function render()
    {
        return view('livewire.job.apply');
    }
}
