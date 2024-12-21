<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use App\Models\Article;
use Filament\Actions;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;

class ViewArticle extends ViewRecord
{
    protected static string $resource = ArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function getTitle(): string|Htmlable
    {
        return $this->record->title;
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\RichEditor::make('content')->columnSpan(3)->hiddenLabel(),
            Forms\Components\Section::make()->schema([
                Forms\Components\Placeholder::make('created_at')
                    ->label('Terakhir diubah')
                    ->content(fn(Article $record): ?string => $record->updated_at?->diffForHumans()),
            ])->columnSpan(1),
        ])->columns(4);
    }
}
