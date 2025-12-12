<?php
namespace App\Livewire\User;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class ResumeUpload extends Component
{
    use WithFileUploads;

    public $resume;
    public $uploadedResume;

    public function mount()
    {
        $this->uploadedResume = auth()->user()->profile_img;
    }

    public function uploadResume()
    {
        $this->validate([
            'resume' => 'required|mimes:pdf,doc,docx,rtf|max:2048',
        ]);

        $filePath = $this->resume->store('resumes', 'public');

        $user = Auth::user();
        $user->profile_img = $filePath;
        $user->save();

        $this->reset('resume');

        $this->dispatch('resumeUploaded');

        session()->flash('success', 'Resume uploaded successfully!');
    }

    public function render()
    {
        return view('livewire.user.resume-upload');
    }
}
