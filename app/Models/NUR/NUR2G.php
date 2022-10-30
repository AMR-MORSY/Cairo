<?php

namespace App\Models\NUR;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NUR2G extends Model
{
    use HasFactory;
    protected $table="2G-nurs";
    protected $guarded=[];

    protected function subSystem(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => strtoupper($value),
        );
    }
    protected function oz(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => strtoupper($value),
        );
    }
}
