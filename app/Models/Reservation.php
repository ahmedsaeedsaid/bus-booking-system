<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'trip_id',
        'seat_id',
        'user_id',
        'source_station_id',
        'destination_station_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'trip_id' => 'integer',
        'user_id' => 'integer',
        'seat_id' => 'integer',
        'source_station_id' => 'integer',
        'destination_station_id' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function seat(): BelongsTo
    {
        return $this->belongsTo(Seat::class);
    }

    public function sourceStation(): BelongsTo
    {
        return $this->belongsTo(Station::class);
    }

    public function destinationStation(): BelongsTo
    {
        return $this->belongsTo(Station::class);
    }
}
