<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use App\Models\ArticleTag;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditArticle extends EditRecord
{
    protected static string $resource = ArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function beforeFill()
    {
        $this->record['tags'] = ArticleTag::get(articleId: $this->record['id']);
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        unset($data['tags']);
        return $data;
    }

    public function afterSave()
    {
        $data = $this->form->getState();

        // delete old record
        ArticleTag::where('article_id', $this->record->id)->delete();

        // add new record
        foreach ($data['tags'] as $tag) {
            $articleTag = new ArticleTag();
            $articleTag->article_id = $this->record->id;
            $articleTag->tag_id = $tag;
            $articleTag->save();
        }
    }
}
