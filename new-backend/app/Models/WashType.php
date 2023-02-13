<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class WashType extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected static $logAttributes = ['*'];

    protected $table = 'wash_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'wash_type',
        'item_name',
        'weight',
        'days',
        'price'
    ];

}
