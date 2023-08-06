<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Visit;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'price',
        'image',
        'contact',
        'description',
    ];

    public function visits()
    {
        return $this->hasMany(ServiceVisit::class);
    }

    public function getVisitsCountAttribute()
    {
        return $this->visits()->count();
    }
}
