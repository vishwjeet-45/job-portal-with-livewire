<?php

namespace App\Livewire\Job;

use App\Models\IndustryType;
use App\Models\Language;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Traits\HasDynamicForm;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
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
    public $industry_types = [];
    public $functional_areas = [];

    public $states = [];
    public $cities = [];
    public function mount($usertype =null)
    {
        $this->usertype = $usertype;
        $this->industry_types = IndustryType::pluck('name','id')->toArray();
        $this->buildForm();
    }

    private function buildForm()
    {
        // dd('dsf',$this->states);

        $this->initializeFormFields(
            tableName: 'jobs',
            selectOptions: [
                'country_id' => Country::pluck('name', 'id')->toArray(),
                'industry_type_id' => $this->industry_types,
                'languages' => Language::pluck('name','id')->toArray(),
                'industry_id' => $this->industries,
                'funcational_area_id' => $this->functional_areas,
                'state_id'   => $this->states ?? [],
                'city_id'    => $this->cities ?? [],
                'work_mode' => Job::WORK_MODE,
                'gender' => User::GENDER,
                'employment_type' => Job::EMPLOYEMENT_TYPE,
                'employer_id' => Employer::pluck('company_name', 'id')->toArray(),
                'status' => Job::STATUSES,
                'shift' => Job::SHIFT_TYPES
            ],
            excludeColumns: ['slug']
        );

        $this->dispatch('refresh-select3');
    }

    public function updatedFormDataIndustryTypeId($value)
    {
        $this->industries = Industry::where('industry_types_id',$value)->pluck('name','id')->toArray();

        $firstIndustryId = array_key_first($this->industries);

        $this->functional_areas = FuncationalArea::where('industry_id', $firstIndustryId)
            ->pluck('name', 'id')
            ->toArray();
        $this->buildForm();

        // $this->dispatch('refresh-select3');

    }

    public function updatedFormDataIndustryId($value)
    {

        $this->functional_areas = FuncationalArea::where('industry_id', $value)
            ->pluck('name', 'id')
            ->toArray();
        $this->buildForm();
        // $this->dispatch('refresh-select3');
    }

     public function updatedFormDataCountryId($value)
    {
        // dd('dsf');
        $this->states = State::where('country_id', $value)->pluck('name', 'id')->toArray();
        $this->state_id = null;
        $this->cities = [];
        $this->city_id = null;
        $this->buildForm();
        // $this->dispatch('refresh-select3');

    }
    public function updatedFormDataStateId($value)
    {
        $this->cities = City::where('state_id', $value)->pluck('name', 'id')->toArray();
        $this->city_id = null;
        $this->buildForm();
        // $this->dispatch('refresh-select3');
    }

    public function rules()
    {
        $rules = [];
        $rules = [
        'formData.country_id' => 'required|exists:countries,id',
        'formData.state_id' => 'required|exists:states,id',
        'formData.city_id' => 'required|exists:cities,id',
        'formData.gender' => ['required', Rule::in(User::GENDER)],
        'formData.industry_type_id' => 'required|exists:industry_types,id',
        ];
        return array_merge($rules,
        $this->getValidationRules());
    }

    public function save()
    {
        $this->dispatch('refresh-select3');
        $this->validate();
        $data = $this->formData;
        $data['city_id'] = array_first($this->formData['city_id']);
        $data['languages'] = array_first($this->formData['languages']);
        $data['slug'] = Str::slug($data['title']);
        $job = Job::create($data);


        $cityIds = (array) $this->formData['city_id'];
        $languages = (array) $this->formData['languages'];
        $job->cities()->sync($cityIds);
        $job->getLanguages()->sync($languages);

        $job->created_by = auth()->user()->id;
        $job->save();


        $this->reset();

        $this->dispatch('reset-js-fields');

        $this->mount();
        $this->dispatch('success', message: 'Job created successfully!');
    }
    public function render()
    {
        return view('livewire.job.create');
    }
}
