<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HolidayPlan extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'holiday_plan';

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'title',
        'description',
        'date',
        'location',
        'created_at',
        'updated_at'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'description' => 'string',
        'date' => 'datetime',
        'location' => 'string',
        'updated_at' => 'datetime',
        'created_at' => 'datetime'
    ];

    /**
     * @var array
     */
    public static $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'date' => 'required|date_format:Y-m-d',
        'location' => 'required|string|max:255',
    ];
}
