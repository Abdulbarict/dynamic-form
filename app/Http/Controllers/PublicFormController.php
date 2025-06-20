<?php

namespace App\Http\Controllers;

use App\Models\Form;

class PublicFormController extends Controller
{
    public function show($slug)
    {
        $form = Form::where('slug', $slug)->with('fields')->firstOrFail();

        return view('public.form', compact('form'));
    }
}
