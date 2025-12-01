@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10">

    {{-- Form Title --}}
    <h1 class="text-3xl font-bold text-gray-900 mb-8">{{ $form->title }}</h1>

    {{-- Success Message --}}
    @if (session('success'))
        <div class="mb-6 p-4 rounded-lg bg-green-100 text-green-800 border border-green-300">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('form.submit', $form->slug) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf

        @foreach ($sections as $section)
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">

                {{-- Section Title --}}
                <h2 class="text-xl font-semibold text-gray-800 mb-4">
                    {{ $section['title'] }}
                </h2>

                <div class="space-y-5">
                    @foreach ($section['fields'] as $field)
                        @php
                            $name = $field['name'] 
                                ?: \Illuminate\Support\Str::slug($field['label'], '_');
                            $required = $field['required'] ?? false;
                        @endphp

                        <div class="flex flex-col">
                            {{-- Label --}}
                            <label class="font-medium text-gray-700 mb-1">
                                {{ $field['label'] }}
                                @if($required)
                                    <span class="text-red-500">*</span>
                                @endif
                            </label>

                            {{-- Field Types --}}
                            @switch($field['type'])

                                {{-- Text Input --}}
                                @case('text')
                                @case('number')
                                    <input
                                        type="{{ $field['type'] }}"
                                        name="{{ $name }}"
                                        placeholder="{{ $field['placeholder'] }}"
                                        class="border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                        @if($required) required @endif
                                    >
                                @break

                                {{-- Textarea --}}
                                @case('textarea')
                                    <textarea
                                        name="{{ $name }}"
                                        placeholder="{{ $field['placeholder'] }}"
                                        rows="4"
                                        class="border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                        @if($required) required @endif
                                    ></textarea>
                                @break

                                {{-- File Upload --}}
                                @case('file')
                                    <input 
                                        type="file" 
                                        name="{{ $name }}" 
                                        class="block text-gray-700"
                                        @if($required) required @endif
                                    >
                                @break

                                {{-- Date Picker --}}
                                @case('date')
                                    <input
                                        type="date"
                                        name="{{ $name }}"
                                        class="border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                        @if($required) required @endif
                                    >
                                @break

                                {{-- Checkbox --}}
                                @case('checkbox')
                                    <label class="inline-flex items-center gap-2 cursor-pointer">
                                        <input 
                                            type="checkbox" 
                                            name="{{ $name }}"
                                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                        >
                                        <span class="text-gray-700">{{ $field['placeholder'] }}</span>
                                    </label>
                                @break

                                {{-- Dropdown --}}
                                @case('dropdown')
                                    <select
                                        name="{{ $name }}"
                                        class="border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                        @if($required) required @endif
                                    >
                                        <option value="">Select...</option>

                                        @foreach ($field['options'] ?? [] as $opt)
                                            <option value="{{ $opt['value'] }}">
                                                {{ $opt['value'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                @break

                            @endswitch

                            {{-- Validation Error --}}
                            @error($name)
                                <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    @endforeach
                </div>

            </div>
        @endforeach

        {{-- Submit Button --}}
        <button
            type="submit"
            class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-md transition"
        >
            Submit Form
        </button>

    </form>
</div>
@endsection
