<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Form extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'slug',
    ];

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        if (! isset($this->attributes['slug']) || empty($this->attributes['slug'])) {
            $slug = Str::slug($value);
            $count = static::where('slug', 'LIKE', "$slug%")->count();
            $this->attributes['slug'] = $count ? "$slug-$count" : $slug;
        }
    }

    public function fields()
    {
        return $this->hasMany(FormField::class, 'form_id', 'id');
    }
}
