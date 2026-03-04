<?php

namespace App\Http\Requests;

use App\Models\TimeRecord;
use Illuminate\Foundation\Http\FormRequest;

class StoreTimeRecordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'date' => 'required|date|before_or_equal:today',
            'time_in' => 'required|date_format:H:i',
            'time_out' => 'required|date_format:H:i|after:time_in',
            'notes' => 'nullable|string|max:500',
        ];
    }
    public function messages()
    {
        return [
            'time_out.after' => 'Time out must be after time in.',
            'date.before_or_equal' => 'Cannot log future dates.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Check for duplicate entry
            $exists = TimeRecord::where('user_id', auth()->id())
                ->where('date', $this->date)
                ->where('id', '!=', $this->route('tracking'))
                ->exists();

            if ($exists) {
                $validator->errors()->add('date', 'You already have a time entry for this date.');
            }

            // Check if total hours exceed 24
            $timeIn = \Carbon\Carbon::parse($this->time_in);
            $timeOut = \Carbon\Carbon::parse($this->time_out);
            $hours = $timeOut->diffInHours($timeIn, true);

            if ($hours > 24) {
                $validator->errors()->add('time_out', 'Total hours cannot exceed 24 hours.');
            }
        });
    }
}
