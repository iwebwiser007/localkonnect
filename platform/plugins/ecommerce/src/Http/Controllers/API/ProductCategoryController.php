<?php

namespace Botble\Ecommerce\Http\Controllers\API;

use Botble\Base\Http\Controllers\BaseController;
use Botble\Blog\Http\Resources\CategoryResource;
use Botble\Ecommerce\Facades\EcommerceHelper;
use Botble\Ecommerce\Http\Requests\API\CategoryRequest;
use Botble\Ecommerce\Http\Resources\API\AvailableProductResource;
use Botble\Ecommerce\Http\Resources\API\ProductCategoryResource;
use Botble\Ecommerce\Models\ProductCategory;
use Botble\Ecommerce\Services\Products\GetProductService;
use Botble\Slug\Facades\SlugHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductCategoryController extends BaseController
{
    /**
     * Get list of product categories
     *
     * @group Product Categories
     * @param CategoryRequest $request
     * @queryParam categories nullable array List of category IDs if you need filter by categories, (e.g. [1,2,3]). No-example
     * @queryParam page int Page number. Default: 1. No-example
     * @queryParam per_page int Number of items per page. Default: 16. No-example
     *
     * @return JsonResponse
     */
    public function index(CategoryRequest $request)
    {
        $categories = ProductCategory::query()
            ->wherePublished()
            ->orderBy('order')
            ->orderBy('created_at', 'DESC')
            ->when($request->input('categories'), function ($query, $categoryIds) {
                return $query->whereIn('id', $categoryIds);
            })
            ->when($request->has('is_featured'), function ($query) use ($request) {
                return $query->where('is_featured', $request->boolean('is_featured'));
            })
            ->paginate(config('ecommerce.pagination.per_page', 16));

        return $this
            ->httpResponse()
            ->setData(ProductCategoryResource::collection($categories))
            ->toApiResponse();
    }

    /**
     * Get product category details by slug
     *
     * @group Product Categories
     * @param string $slug Category slug
     * @return JsonResponse
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    public function show(string $slug)
    {
        $slug = SlugHelper::getSlug($slug, SlugHelper::getPrefix(ProductCategory::class));

        if (! $slug) {
            abort(404);
        }

        $category = ProductCategory::query()
            ->where('id', $slug->reference_id)
            ->firstOrFail();

        return $this
            ->httpResponse()
            ->setData(new CategoryResource($category))
            ->toApiResponse();
    }

    /**
     * Get products by category
     *
     * @group Product Categories
     *
     * @param ProductCategory $category
     * @param Request $request
     * @return JsonResponse
     */
    public function products(ProductCategory $category, Request $request)
    {
        if (! EcommerceHelper::productFilterParamsValidated($request)) {
            $request = request();
        }

        $with = EcommerceHelper::withProductEagerLoadingRelations();

        $categoryIds = ProductCategory::getChildrenIds($category->activeChildren, [$category->getKey()]);

        $requestCategories = (array) $request->input('categories', []) ?: [];

        $request->merge(['categories' => [...$categoryIds, ...$requestCategories]]);

        $products = app(GetProductService::class)->getProduct($request, null, null, $with);

        return $this
            ->httpResponse()
            ->setData(AvailableProductResource::collection($products))
            ->toApiResponse();
    }
}
