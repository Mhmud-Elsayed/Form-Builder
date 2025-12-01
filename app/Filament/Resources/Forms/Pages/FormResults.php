<?php

namespace App\Filament\Resources\Forms\Pages;

use App\Filament\Resources\Forms\FormResource;
use App\Models\Form;
use Filament\Resources\Pages\Page;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\Action;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FormResults extends Page implements HasTable
{
    use InteractsWithTable;

    protected string $view = 'filament.resources.forms.pages.results';
    protected static string $resource = FormResource::class;

    public Form $record;

    public function mount(Form $record): void
    {
        $this->record = $record;
    }

    protected function getActions(): array
    {
        return [
            Action::make('exportCsv')
                ->label('Export CSV')
                ->icon('heroicon-o-arrow-down-tray')
                ->action('exportCsv'),
        ];
    }

  public function exportCsv(): StreamedResponse
{
    $filename = 'form-results-' . $this->record->id . '.csv';

    return new StreamedResponse(function () {
        $handle = fopen('php://output', 'w');

        $results = $this->record->results()->get();

        if ($results->isEmpty()) {
            fputcsv($handle, ['No data']);
            fclose($handle);
            return;
        }

        $first = $results->first()->data;
        $columns = array_keys($first);

        // Write header
        fputcsv($handle, $columns);

        // Write rows
        foreach ($results as $result) {
            $row = [];

            foreach ($columns as $col) {
                $value = $result->data[$col] ?? null;

                // Fix: convert arrays to JSON strings
                if (is_array($value)) {
                    $value = json_encode($value, JSON_UNESCAPED_UNICODE);
                }

                $row[] = $value;
            }

            fputcsv($handle, $row);
        }

        fclose($handle);
    }, 200, [
        "Content-Type" => "text/csv",
        "Content-Disposition" => "attachment; filename={$filename}",
    ]);
}

          

    public function getTitle(): string
    {
        return 'Form Results';
    }

    public function getTableQuery()
    {
        return $this->record->results()->getQuery();
    }

    public function getTableColumns(): array
    {
        $first = $this->record->results()->first();

        if (! $first) {
            return [
                TextColumn::make('no_data')
                    ->label('No submissions yet')
                    ->formatStateUsing(fn () => '—'),
            ];
        }

        return collect(array_keys($first->data))
            ->map(fn ($key) =>
                TextColumn::make("data.$key")
                    ->label($key)
                    ->searchable()
                    ->sortable()
                    ->wrap()
            )
            ->toArray();
    }
}
