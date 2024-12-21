<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use App\Models\ArticleTag;
use Filament\Resources\Pages\CreateRecord;

class CreateArticle extends CreateRecord
{
    protected static string $resource = ArticleResource::class;

    protected function getRedirectUrl(): string
    {
        $resource = static::getResource();
        return $resource::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        unset($data['tags']);
        return $data;
    }

    protected function afterCreate()
    {
        $data = $this->form->getState();
        foreach($data['tags'] as $tag) {
            $articleTag = new ArticleTag();
            $articleTag->article_id = $this->record->id;
            $articleTag->tag_id = $tag;
            $articleTag->save();
        }
    }
}
