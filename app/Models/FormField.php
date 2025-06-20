<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormField extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_id',
        'field_label',
        'field_name',
        'field_type',
        'placeholder',
        'field_options',
        'is_required',
        'field_order',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
