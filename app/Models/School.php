<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'domain',
        'tagline',
        'logo',
        'favicon',
        'phone',
        'email',
        'address',
        'principal_name',
        'status',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function academicYears()
    {
        return $this->hasMany(AcademicYear::class);
    }

    public function currentAcademicYear()
    {
        return $this->hasOne(AcademicYear::class)->where('is_current', true);
    }

    public function classes()
    {
        return $this->hasMany(SchoolClass::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function settings()
    {
        return $this->hasMany(SchoolSetting::class);
    }

    public function getSetting($key, $default = null)
    {
        $setting = $this->settings()->where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }
}
