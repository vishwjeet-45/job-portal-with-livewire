<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    const STATUSES = ['draft' => 'Draft', 'published' => 'Published','expired' => 'Expired'];

    const EMPLOYEMENT_TYPE = ['contract' => 'Contract', 'permanent' => 'Permanent','hourly' => 'Hourly'];

    const WORK_MODE = ['onsite' => 'Onsite', 'hybrid' => 'Hybrid','remote' => 'Remote'];

    protected $fillable =
    [
        'employer_id',
        'title',
        'employment_type',
        'work_mode',
        'gender',
        'industry_type_id',
        'industry_id',
        'funcational_area_id',
        'country_id',
        'state_id',
        'city_id',
        'min_salary',
        'max_salary',
        'currency',
        'shift',
        'description',
        'experience_level',
        'qualification',
        'number_of_vacancy',
        'deadline',
        'status'
    ];

    public function languages()
    {
        return $this->morphToMany(Language::class, 'languageable');
    }

    public function cities()
    {
        return $this->morphToMany(City::class, 'cityable');
    }

}
