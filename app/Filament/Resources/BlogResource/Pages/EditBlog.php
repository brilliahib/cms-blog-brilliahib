<?php

namespace App\Filament\Resources\BlogResource\Pages;

use App\Filament\Resources\BlogResource;
use App\Models\Tag;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBlog extends EditRecord
{
    protected static string $resource = BlogResource::class;

    protected array $tagsArray = [];

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->tagsArray = $data['tags'] ?? [];
        unset($data['tags']);

        return $data;
    }

    protected function afterSave(): void
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
