<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TripBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'source_id' => 'required|exists:stations,id',
            'destination_id' => 'required|exists:stations,id',
            'seat_id' => 'required|exists:trip_seats,seat_id,trip_id,'.$this->trip_id,
        ];
    }
}
