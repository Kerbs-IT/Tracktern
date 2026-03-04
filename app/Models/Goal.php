<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    protected $fillable = [
        'user_id',
        'required_hours',
        'start_date',
        'target_end_date',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'target_end_date' => 'date',
        'required_hours' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function progressPercentage()
    {
        $totalLogged = $this->user->totalHoursLogged();
        return ($totalLogged / $this->required_hours) * 100;
    }

    public function hoursRemaining()
    {
        $totalLogged = $this->user->totalHoursLogged();
        return max(0, $this->required_hours - $totalLogged);
    }
}
