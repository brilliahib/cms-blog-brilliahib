<?php

namespace App\Filament\Resources\BlogResource\Pages;

use App\Filament\Resources\BlogResource;
use App\Models\Tag;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBlog extends CreateRecord
{
    protected static string $resource = BlogResource::class;

    protected array $tagsArray = [];

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->tagsArray = $data['tags'] ?? [];

        unset($data['tags']);

        return $data;
    }

    protected function afterCreate(): void
    {
        if (! $this->record) {
            return;
        }

        $tagIds = collect($this->tagsArray)
            ->filter()
            ->map(function (string $tagName) {
                return Tag::firstOrCreate(['name' => trim($tagName)])->id;
            })
            ->toArray();

        $this->record->tags()->sync($tagIds);
    }
}
