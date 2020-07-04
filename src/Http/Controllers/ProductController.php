<?php

namespace Thelabdevtz\MumProductModule\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Thelabdevtz\LaraBase\Core\ResponseHelpers;
use Thelabdevtz\MumProductModule\Repositories\Brand\BrandRepository;
use Thelabdevtz\MumProductModule\Repositories\Product\ProductRepository;
use Thelabdevtz\MumProductModule\Repositories\Stock\StockRepository;

class ProductController extends Controller
{
    use ResponseHelpers;

    /** @var ProductRepository */
    private $productRepository;

    /** @var StockRepository */
    private $stockRepository;

    /** @var BrandRepository */
    private $brandRepository;

    /**
     * ProductController constructor.
     * @param ProductRepository $productRepository
     * @param StockRepository $stockRepository
     * @param BrandRepository $brandRepository
     */
    public function __construct(ProductRepository $productRepository, StockRepository $stockRepository, BrandRepository $brandRepository)
    {
        $this->productRepository = $productRepository;
        $this->stockRepository = $stockRepository;
        $this->brandRepository = $brandRepository;
    }

    //Display a listing of the resource.
    public function index()
    {
        $products = $this->productRepository->listProducts(request()->all());

        return $this->sendResponseOk($products, 'Product list ok.');
    }

    //Show the form for creating a new resource.
    public function create()
    {
        //
    }

    //Store a newly created resource in storage.
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'name' => 'required|string|unique:products',
            'product_category_id' => 'required',
            'manufacturing_date' => 'required',
            'expire_date' => 'required',
            'buying_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return $this->sendResponseBadRequest($validator->errors()->first());
        }

        $stock_id = $this->createStock()->id;
        $productBrandId = $this->createOrFindBrand(request()->product_brand_id)->id;
        $new_product_payload = array_merge(
      ['stock_id' => $stock_id],
      $request->all(),
      ['product_brand_id' => $productBrandId]
    );
        $product = $this->productRepository->create($new_product_payload);

        if (! $product) {
            return $this->sendResponseBadRequest('Failed to create product');
        }

        return $this->sendResponseCreated($product, 'Product created successfully');
    }

    // Display the specified resource.
    public function show($id)
    {
        $product = $this->productRepository->find($id, ['category']);

        if (! $product) {
            return $this->sendResponseNotFound();
        }

        return $this->sendResponseOk($product);
    }

    // Show the form for editing the specified resource.
    public function edit($id)
    {
        //
    }

    //Update the specified resource in storage.
    public function update(Request $request, $id)
    {
        $validator = validator($request->all(), [
            'name' => 'required|string',
            'product_category_id' => 'required',
            'manufacturing_date' => 'required',
            'expire_date' => 'required',
            'buying_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return $this->sendResponseBadRequest($validator->errors()->first());
        }

        $payload = $request->all();
        $updated = $this->productRepository->update($id, $payload);
        if (! $updated) {
            return $this->sendResponseBadRequest('Failed to update');
        }

        return $this->sendResponseUpdated();
    }

    // Remove the specified resource from storage.
    public function destroy($id)
    {
        try {
            $this->productRepository->delete($id);
        } catch (\Exception $e) {
            $this->sendResponseBadRequest('Failed to delete');
        }

        $this->sendResponseDeleted();
    }

    //create stock
    private function createStock()
    {
        return $this->stockRepository->create([
            'stock_number' => 'STOCK/'.Carbon::now()->format('Y/m/d'),
        ]);
    }

    // Create or find brand
    private function createOrFindBrand($brand)
    {
        return $this->brandRepository->findOrCreateBrand($brand);
    }
}
