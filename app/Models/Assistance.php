<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assistance extends Model
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
        'date' => 'date:Y-m-d',
        'start_time' => 'datetime:Y-m-d H:i:s',
        'time_of' => 'datetime:Y-m-d H:i:s',
        'personal_id' => 'integer',
    ];

    public function personal()
    {
        return $this->belongsTo(Personal::class);
    }
}
