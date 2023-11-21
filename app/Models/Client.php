<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'fullName',
        'email',
        'phone',
        'package',
        'payMethode',
        'reservation',
        'totalAmount',
        'Note',
        'videoLink',
        'is_payed'
    ];
}
