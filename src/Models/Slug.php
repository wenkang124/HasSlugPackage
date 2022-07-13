<?php

namespace Wenkang124\HasSlug\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slug extends Model
{
    protected $fillable = [
        'value'
    ];

    const MORPHABLE = "targetable";
    use HasFactory;
}
