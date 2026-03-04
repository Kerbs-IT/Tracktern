<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeRecord extends Model
{
    protected $fillable = [
        'user_id',
        'date',
        'time_in',
        'time_out',
        'total_hours',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'total_hours' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($record) {
            $record->calculateTotalHours();
        });
    }

    public function calculateTotalHours()
    {
        $timeIn = \Carbon\Carbon::parse($this->time_in);
        $timeOut = \Carbon\Carbon::parse($this->time_out);
        $this->total_hours = $timeOut->diffInHours($timeIn, true);
    }
}
