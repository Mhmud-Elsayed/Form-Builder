<?php

// namespace App\Livewire;

// use App\Models\Form as FormModel;
// use Filament\Forms\Components\Checkbox;
// use Filament\Forms\Components\DatePicker;
// use Filament\Forms\Components\FileUpload;
// use Filament\Forms\Components\MarkdownEditor;
// use Filament\Forms\Components\Select;
// use Filament\Forms\Components\Textarea;
// use Filament\Forms\Components\TextInput;
// use Filament\Schemas\Concerns\InteractsWithSchemas;
// use Filament\Schemas\Contracts\HasSchemas;
// use Filament\Schemas\Schema;
// use Illuminate\Contracts\View\View;
// use Illuminate\Support\Str;
// use Livewire\Component;

// class FormRendering extends Component implements HasSchemas
// {
//     use InteractsWithSchemas;

//     public FormModel $formModel;

//     public ?array $data = [];

//     public bool $submitted = false;

//     public function mount(string $slug): void
//     {
//         $this->formModel = FormModel::query()
//             ->where('slug', $slug)
//             ->where('published', true)
//             ->firstOrFail();

//         $this->form->fill();
//     }

   
//  public function form(Schema $schema): Schema     
//    {
//         $schemaData = $this->formModel->schema ?? [];
//         $fields = [];

//         foreach ($schemaData as $item) {
//             $sectionData = $item['data'] ?? [];

//             if (! isset($sectionData['fields']) || ! is_array($sectionData['fields'])) {
//                 continue;
//             }

//             if (! empty($sectionData['title'])) {
//                 $fields[] = TextInput::make('section_'.Str::slug($sectionData['title']))
//                     ->label($sectionData['title'])
//                     ->disabled()
//                     ->dehydrated(false)
//                     ->extraAttributes(['class' => 'font-bold text-lg'])
//                     ->hiddenLabel(false)
//                     ->default('');
//             }

//             foreach ($sectionData['fields'] as $field) {
//                 $fieldName = ! empty($field['name'])
//                     ? $field['name']
//                     : Str::slug($field['label'] ?? 'field', '_');

//                 $component = $this->buildField($field, $fieldName);

//                 if ($component) {
//                     $fields[] = $component;
//                 }
//             }
//         }

//         return $schema
//             ->schema($fields)
//             ->statePath('data');
//     }


//     // {
//     //     $label = $field['label'] ?? ucfirst(str_replace('_', ' ', $fieldName));

//     //     $component = match ($field['type'] ?? 'text') {
//     //         'text' => TextInput::make($fieldName)
//     //             ->label($label)
//     //             ->maxLength($field['max_length'] ?? 255),

//     //         'email' => TextInput::make($fieldName)
//     //             ->label($label)
//     //             ->email()
//     //             ->maxLength(255),

//     //         'number' => TextInput::make($fieldName)
//     //             ->label($label)
//     //             ->numeric()
//     //             ->minValue($field['min'] ?? null)
//     //             ->maxValue($field['max'] ?? null),

//     //         'textarea' => Textarea::make($fieldName)
//     //             ->label($label)
//     //             ->rows($field['rows'] ?? 3)
//     //             ->maxLength($field['max_length'] ?? 5000)
//     //             ->columnSpanFull(),

//     //         'dropdown', 'select' => Select::make($fieldName)
//     //             ->label($label)
//     //             ->options(
//     //                 collect($field['options'] ?? [])
//     //                     ->mapWithKeys(function ($option) {
//     //                         $value = $option['value'] ?? $option;
//     //                         return [$value => $value];
//     //                     })
//     //                     ->toArray()
//     //             ),

//     //         'checkbox' => Checkbox::make($fieldName)
//     //             ->label($label),

//     //         'file' => FileUpload::make($fieldName)
//     //             ->label($label)
//     //             ->directory('form-uploads/'.$this->formModel->slug)
//     //             ->disk('public')
//     //             ->maxSize($field['max_size'] ?? 10240)
//     //             ->acceptedFileTypes($field['accepted_types'] ?? [
//     //                 'application/pdf',
//     //                 'application/msword',
//     //                 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
//     //                 'image/*',
//     //             ])
                
//     //             ->columnSpanFull(),

//     //         'date' => DatePicker::make($fieldName)
//     //             ->label($label)
//     //             ->native(false)
//     //             ->displayFormat($field['format'] ?? 'd/m/Y'),

//     //         default => null,
//     //     };

//     //     if (! $component) {
//     //         return null;
//     //     }

//     //     // Placeholder
//     //     if (! empty($field['placeholder']) && method_exists($component, 'placeholder')) {
//     //         $component = $component->placeholder($field['placeholder']);
//     //     }

//     //     // Help text
//     //     if (! empty($field['help']) && method_exists($component, 'helperText')) {
//     //         $component = $component->helperText($field['help']);
//     //     }

//     //     // Required
//     //     if (! empty($field['required'])) {
//     //         $component = $component->required();
//     //     }

//     //     return $component;
//     // }

//  protected function buildField(array $field, string $fieldName)
// {
//     $label = $field['label'] ?? ucfirst(str_replace('_', ' ', $fieldName));

//     $component = match ($field['type'] ?? 'text') {
//         'text' => TextInput::make($fieldName)
//             ->label($label)
//             ->maxLength($field['max_length'] ?? 255),

//         'email' => TextInput::make($fieldName)
//             ->label($label)
//             ->email()
//             ->maxLength(255),

//         'number' => TextInput::make($fieldName)
//             ->label($label)
//             ->numeric()
//             ->minValue($field['min'] ?? null)
//             ->maxValue($field['max'] ?? null),

//         'textarea' => Textarea::make($fieldName)
//             ->label($label)
//             ->rows($field['rows'] ?? 3)
//             ->maxLength($field['max_length'] ?? 5000)
//             ->columnSpanFull(),

//         'dropdown', 'select' => Select::make($fieldName)
//             ->label($label)
//             ->options(
//                 collect($field['options'] ?? [])
//                     ->mapWithKeys(function ($option) {
//                         $value = $option['value'] ?? $option;
//                         return [$value => $value];
//                     })
//                     ->toArray()
//             ),

//         'checkbox' => Checkbox::make($fieldName)
//             ->label($label),

//         'file' => FileUpload::make($fieldName)
//             ->label($label)
//             ->directory('form-uploads/'.$this->formModel->slug)
//             ->disk('public')
//             ->maxSize($field['max_size'] ?? 10240)
//             ->acceptedFileTypes($field['accepted_types'] ?? [
//                 'image/jpeg',
//                 'image/png',
//                 'image/gif',
//                 'application/pdf',
//             ])
//             ->columnSpanFull(),

//         'date' => DatePicker::make($fieldName)
//             ->label($label)
//             ->native(false)
//             ->displayFormat($field['format'] ?? 'd/m/Y'),

//         default => null,
//     };

//     if (! $component) {
//         return null;
//     }

//     // Placeholder
//     if (! empty($field['placeholder']) && method_exists($component, 'placeholder')) {
//         $component = $component->placeholder($field['placeholder']);
//     }

 

//     // Required
//     if (! empty($field['required'])) {
//         $component = $component->required();
//     }

//     return $component;
// }  
//     public function submit(): void
//     {
//         try {
//             $this->form->validate();

//             $this->formModel->results()->create([
//                 'data' => $this->form->getState(),
//                 'tenant_id' => $this->formModel->tenant_id,
//                 'submitted_at' => now(),
//             ]);

//             $this->submitted = true;
//             $this->data = [];
//             $this->form->fill();

//             session()->flash('success', 'Form submitted successfully!');

//         } catch (\Illuminate\Validation\ValidationException $e) {
//             // Re-throw validation exceptions to show field errors
//             throw $e;
//         } catch (\Exception $e) {
//             session()->flash('error', 'An error occurred while submitting the form. Please try again.');

//             logger()->error('Form submission error', [
//                 'form_id' => $this->formModel->id,
//                 'error' => $e->getMessage(),
//                 'trace' => $e->getTraceAsString(),
//             ]);
//         }
//     }

    // public function render(): View
    // {
    //     return view('livewire.form-rendering')
    //         ->layout('layouts.app')
    //         ->title($this->formModel->title);
    // }
// }
