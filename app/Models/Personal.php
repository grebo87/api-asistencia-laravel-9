<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'date_of_birth' => 'date',
    ];

    public function assistance()
    {
        return $this->hasMany(Assistance::class);
    }

    public function dayAssistance()
    {
        return $this->hasOne(Assistance::class)->where('date', now()->toDateString())->first();
    }

    public function dayAbsence()
    {
        return $this->hasOne(Absence::class)->where('date', now()->toDateString())->first();
    }

    public function absence()
    {
        return $this->hasOne(Absence::class);
    }

}
