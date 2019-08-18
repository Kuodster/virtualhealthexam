<?php
declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\DB;

class QueryCollectionService extends BaseCollectionService
{
    protected function setQuery(): void
    {
        $this->query = DB::table('source')
                         ->select([
                             'source.id',
                             'source.cx',
                             'source.rx',
                             'source.title',
                         ])
                         ->where('source.title', 'LIKE', 'title 1%');

        $subQuery = DB::table('rel')->selectRaw('GROUP_CONCAT(ndc)')->where('rel.cx', '=', DB::raw('source.cx'));
        $this->query->selectSub($subQuery, 'ndc');
    }

    protected function normalizeData(array $items): array
    {
        $data = [];

        foreach ($items as $source) {
            $source = (array)$source;
            $data[] = array_merge($source, [
                'ndc' => $source['ndc'] ? explode(',', $source['ndc']) : null
            ]);
        }

        return $data;
    }

    protected function getAllowedSortFields(): array
    {
        return ['id', 'rx'];
    }
}