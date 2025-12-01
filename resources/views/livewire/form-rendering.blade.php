<div>
    @if (session()->has('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-error mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if (!$submitted)
        <form wire:submit="submit">
            {{ $this->form }}
            
            <button type="submit" class="btn btn-primary">
                Submit Form
            </button>
        </form>
    @else
        <div class="alert alert-success">
            Thank you! Your form has been submitted successfully.
        </div>
    @endif
    
    <x-filament-actions::modals />
</div>