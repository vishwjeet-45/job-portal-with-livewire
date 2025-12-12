<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ProfileSummary extends Component
{
    public $summary;
    public $showModal = false;

    public function mount()
    {
        $user = Auth::user();
        $this->summary = $user->candidate?->summary;
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function editModal()
    {
        $user = Auth::user();
        $this->summary = $user->candidate?->summary;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate([
            'summary' => 'required|min:5'
        ]);

        $user = Auth::user();
        $candidate = $user->candidate()->firstOrCreate([
            'user_id' => $user->id
        ]);

        $candidate->summary = $this->summary;
        $candidate->save();

        session()->flash('success', 'Profile summary updated successfully.');

        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.user.profile-summary');
    }
}
