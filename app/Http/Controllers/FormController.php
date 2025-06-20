<?php

namespace App\Http\Controllers;

use App\Jobs\FormCreatedJob;
use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $forms = Form::with('fields')->latest();

            return DataTables::of($forms)
                ->addIndexColumn()
                ->addColumn('action', function ($forms) {
                    return view('forms.partials.actions', compact('forms'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('forms.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('forms.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->ajax()) {
            try {
                $request->validate([
                    'form_name' => 'required|string|max:255',
                    'description' => 'nullable|string',
                    'input_fields' => 'required|json',
                ]);
                DB::transaction(function () use ($request) {

                    $form_name = $request->input('form_name');
                    $form_description = $request->input('description');
                    $InputFields = $request->input('input_fields');

                    $fields = json_decode($InputFields, true);

                    $form = Form::create([
                        'title' => $form_name,
                        'description' => $form_description,
                    ]);

                    if (! is_array($fields)) {
                        return response()->json(['success' => false, 'message' => 'Invalid fields data']);
                    }
                    foreach ($fields as $field) {
                        if (isset($field['name']) && isset($field['type'])) {
                            $form->fields()->create([
                                'field_label' => $field['label'],
                                'field_name' => $field['name'],
                                'field_type' => $field['type'],
                                'placeholder' => $field['placeholder'] ?? null,
                                'field_options' => isset($field['options']) ? json_encode($field['options']) : null,
                                'is_required' => ! empty($field['required']) ? 1 : 0,
                                'field_order' => $field['order'] ?? 0,
                            ]);
                        }
                    }
                    FormCreatedJob::dispatch($form);
                });

                return response()->json(['success' => true, 'route' => route('forms.index')]);
            } catch (\Illuminate\Validation\ValidationException $e) {
                return response()->json(['success' => false, 'errors' => $e->errors()]);

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Form creation failed', ['error' => $e->getMessage()]);

                return response()->json(['success' => false, 'message' => 'Something went wrong. Please try again later.']);

            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $form = Form::with('fields')->findOrFail($id);

        return view('forms.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->ajax()) {
            try {
                $request->validate([
                    'form_name' => 'required|string|max:255',
                    'description' => 'nullable|string',
                    'input_fields' => 'required|json',
                ]);
                DB::transaction(function () use ($request, $id) {

                    $form_name = $request->input('form_name');
                    $form_description = $request->input('description');
                    $InputFields = $request->input('input_fields');
                    $fields = json_decode($InputFields, true);

                    if (! is_array($fields)) {
                        return response()->json(['success' => false, 'message' => 'Invalid fields data']);
                    }

                    $form = Form::findOrFail($id);

                    $form->update([
                        'title' => $form_name,
                        'description' => $form_description,
                    ]);

                    $form->fields()->delete();

                    foreach ($fields as $field) {
                        if (isset($field['name']) && isset($field['type'])) {
                            $form->fields()->create([
                                'field_label' => $field['label'],
                                'field_name' => $field['name'],
                                'field_type' => $field['type'],
                                'placeholder' => $field['placeholder'] ?? null,
                                'field_options' => isset($field['options']) ? json_encode($field['options']) : null,
                                'is_required' => ! empty($field['required']) ? 1 : 0,
                                'field_order' => $field['order'] ?? 0,
                            ]);
                        }
                    }
                });

                return response()->json(['success' => true, 'route' => route('forms.index')]);

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Form update failed', ['error' => $e->getMessage()]);

                return response()->json(['success' => false, 'message' => 'Something went wrong. Please try again later.']);
            }
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (request()->ajax()) {
            $form = Form::findOrFail($id);
            $form->fields()->delete();
            $form->delete();

            return response()->json(['success' => true, 'message' => 'Form and related fields deleted successfully.']);
        }

    }
}
