<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Source;

class OrmCollectionService extends BaseCollectionService
{

    protected function setQuery(): void
    {
        $this->query = Source::with(['rel'])
                             ->where(Source::getTableName() . '.title', 'LIKE', 'title 1%');
    }

    protected function getAllowedSortFields(): array
    {
        return ['id', 'cx'];
    }

    protected function normalizeData(array $items): array
    {
        $data = [];

        foreach ($items as $source) {
            $data[] = array_merge($source->getAttributes(), [
                'ndc' => $source->rel->count() ? array_map(function ($rel) {
                    return $rel['ndc'];
                }, $source->rel->toArray()) : null
            ]);
        }

        return $data;
    }
}