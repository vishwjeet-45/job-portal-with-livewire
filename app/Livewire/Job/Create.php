<?php

namespace App\Livewire\Job;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Traits\HasDynamicForm;
use Illuminate\Validation\Rule;
use App\Models\
{
    Industry,
    FuncationalArea,
    Country,
    State,
    City,
    User,
    Job,
    Employer
};

class Create extends Component
{

    use WithFileUploads,HasDynamicForm;

    public $ceo_name, $company_name,$logo;
    public $industry_id, $functional_area_id, $ownership_type;
    public $company_size, $established_year, $location, $second_office_location;
    public $description, $website, $facebook_url, $linkedin_url;

    public $industries = [];
    public $states = [];
    public $cities = [];
    public function mount($usertype =null)
    {
        $this->usertype = $usertype;
        $this->buildForm();
    }

    private function buildForm()
    {

        $this->initializeFormFields(
            tableName: 'jobs',
            selectOptions: [
                'country_id' => Country::pluck('name', 'id')->toArray(),
                'state_id'   => $this->states ?? [],
                'city_id'    => $this->cities ?? [],
                'work_mode' => Job::WORK_MODE,
                'gender' => User::GENDER,
                'employment_type' => Job::EMPLOYEMENT_TYPE,
                'employer_id' => Employer::pluck('company_name', 'id')->toArray()
            ]
        );
    }

     public function updatedFormDataCountryId($value)
    {
        $this->states = State::where('country_id', $value)->pluck('name', 'id')->toArray();
        $this->state_id = null;
        $this->cities = [];
        $this->city_id = null;
        $this->buildForm();
        $this->dispatch('refresh-select2', id: 'createModal');
    }
    public function updatedFormDataStateId($value)
    {
        $this->cities = City::where('state_id', $value)->pluck('name', 'id')->toArray();
        $this->city_id = null;
        $this->buildForm();
        $this->dispatch('refresh-select2', id: 'createModal');
    }

    public function rules()
    {
        $rules = [];
        if ($this->usertype == 'Candidates') {
            $rules = [
            'formData.country_id' => 'required|exists:countries,id',
            'formData.state_id' => 'required|exists:states,id',
            'formData.city_id' => 'required|exists:cities,id',
            'formData.mobile_number' =>'required',
            'formData.gender' => ['required', Rule::in(User::GENDER)],
            'formData.industry_type' => ['required', Rule::in(User::INDUSTRY_TYPES)],
            'formData.experience_type' => ['required', Rule::in(User::EXPERIENCE_TYPES)],
            ];
        }
        return array_merge($rules,
        $this->getValidationRules(),
        [
            'formData.first_name' => 'required|string|max:255',
            'formData.last_name' => 'required|string|max:255',
            'formData.email' => 'required|string|email|max:255|unique:users,email',
            'formData.password' => 'required|string|min:6',
        ]);
    }

    public function updatedFormDataProfileImg()
    {
        $this->dispatch('refresh-select2', id: 'createModal');
    }

    public function submit()
    {
        $this->validate();
        $employerData = $this->except('user','industries','states','cities','functionalAreas');
        // dd($this->all());

        $imagePath = $this->logo->store('employers/logo', 'public');
        $employerData['logo'] = $imagePath;

        $user = User::create($this->user);
        $user->employer()->create($employerData);

        $this->reset();

        $this->dispatch('reset-js-fields');

        $this->mount();

        $this->dispatch('success', message: 'Employer created successfully!');
    }
    public function render()
    {
        return view('livewire.job.create');
    }
}
