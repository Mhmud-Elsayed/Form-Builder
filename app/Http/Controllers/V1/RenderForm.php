<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RenderForm extends Controller
{
    /**
     * Render the public form.
     */
    public function show($slug)
    {
        $form = Form::where('slug', $slug)
            ->where('published', true)
            ->firstOrFail();

        $sections = [];

        foreach ($form->schema ?? [] as $block) {

            if (($block['type'] ?? null) === 'section') {
                $sections[] = [
                    'title' => $block['data']['title'] ?? 'Untitled Section',
                    'fields' => $block['data']['fields'] ?? [],
                ];
            }
        }

        return view('forms.show', compact('form', 'sections'));
    }

    public function submit(Request $request, $slug)
    {
        $form = Form::where('slug', $slug)
            ->where('published', true)
            ->firstOrFail();

        // Build sections like show()
        $sections = [];
        foreach ($form->schema ?? [] as $block) {
            if (($block['type'] ?? null) === 'section') {
                $sections[] = [
                    'title' => $block['data']['title'] ?? 'Section',
                    'fields' => $block['data']['fields'] ?? [],
                ];
            }
        }

        $rules = [];

        // Dynamic validation rules
        foreach ($sections as $section) {
            foreach ($section['fields'] ?? [] as $field) {

                $name = $field['name'] ?? Str::slug($field['label'], '_');
                $type = $field['type'] ?? 'text';
                $required = $field['required'] ?? false;

                $baseRule = $required ? 'required' : 'nullable';

                switch ($type) {

                    case 'email':
                        $rules[$name] = "$baseRule|email|max:255";
                        break;

                    case 'number':
                        $rules[$name] = "$baseRule|numeric";
                        break;

                    case 'date':
                        $rules[$name] = "$baseRule|date";
                        break;

                    case 'file':
                        $rules[$name] = [
                            $required ? 'required' : 'nullable',
                            'file',
                            'max:20480', // 20 MB
                            'mimetypes:'.
                                'image/jpeg,image/png,image/webp,'.
                                'application/pdf,'.
                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document,'.
                                'application/msword',
                        ];
                        break;

                    default:
                        $rules[$name] = "$baseRule|string|max:10000";
                }
            }
        }

        // Validate request
        $validated = $request->validate($rules);

        // Handle file uploads safely
        foreach ($sections as $section) {
            foreach ($section['fields'] ?? [] as $field) {

                $name = $field['name'] ?? Str::slug($field['label'], '_');

                if (($field['type'] ?? null) === 'file' && $request->hasFile($name)) {

                    $file = $request->file($name);

                    // Sanitize and make filename unique
                    $filename = uniqid().'_'.preg_replace('/[^A-Za-z0-9\-\_\.]/', '', $file->getClientOriginalName());

                    // Save to public/uploads/forms/{form_id}/
                    $directory = public_path("uploads/forms/{$form->id}");
                    if (! is_dir($directory)) {
                        mkdir($directory, 0755, true);
                    }

                    $file->move($directory, $filename);

                    // Save relative path in DB
                    $validated[$name] = "uploads/forms/{$form->id}/{$filename}";
                }
            }
        }

        // Save results
        $form->results()->create([
            'data' => $validated,
            'tenant_id' => $form->tenant_id,
        ]);

        return redirect()->back()->with('success', 'Form submitted successfully!');
    }
}
