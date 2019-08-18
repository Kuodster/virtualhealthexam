<?php
declare(strict_types=1);

namespace App\Http\Controllers;


use App\Services\BaseCollectionService;
use App\Services\OrmCollectionService;
use App\Services\OrmCollectionWithCacheService;
use App\Services\QueryCollectionService;
use App\Services\QueryCollectionWithCacheService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CollectionController
{
    /**
     * @param OrmCollectionService $service
     * @param Request $request
     *
     * @return View
     */
    public function ormSolution(OrmCollectionService $service, Request $request): View
    {
        /* ORM uses lazy loading of "rel" table to get the "ndc" fields
        and collects "ndc" values in to a single-level array from relations
        when preparing the data */
        return $this->renderSolutionPage($service, $request);
    }

    /**
     * @param QueryCollectionService $service
     * @param Request $request
     *
     * @return View
     */
    public function querySolution(QueryCollectionService $service, Request $request): View
    {
        // Query is using a sub-query with GROUP_CONCAT(ndc) and explodes "ndc" field by a "," character to create an array
        return $this->renderSolutionPage($service, $request);
    }

    /**
     * @param OrmCollectionWithCacheService $service
     * @param Request $request
     *
     * @return View
     */
    public function ormCached(OrmCollectionWithCacheService $service, Request $request): View
    {
        return $this->renderSolutionPage($service, $request);
    }

    /**
     * @param QueryCollectionWithCacheService $service
     * @param Request $request
     *
     * @return View
     */
    public function queryCached(QueryCollectionWithCacheService $service, Request $request): View
    {
        return $this->renderSolutionPage($service, $request);
    }


    /**
     * @param BaseCollectionService $service
     * @param Request $request
     *
     * @return View
     */
    protected function renderSolutionPage(BaseCollectionService $service, Request $request): View
    {
        $service->setSort($request->query('sort'), $request->query('order'));

        $data = $service->getData();
        $paginator = $service->getPaginator();
        $sort = $service->getSort();

        return view('collection.index', compact('data', 'paginator', 'sort'));
    }
}