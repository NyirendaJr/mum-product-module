<?php

namespace Thelabdevtz\MumProductModule\Http\Controllers;

use Illuminate\Routing\Controller;
use Thelabdevtz\LaraBase\Core\ResponseHelpers;
use Thelabdevtz\MumProductModule\Repositories\Product\ProductRepository;

class ProductController extends Controller
{
    use ResponseHelpers;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * ProductController constructor.
     * @param ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->productRepository->listProducts(request()->all());

        return $this->sendResponseOk($products, 'Product list ok.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

        $product = $this->productRepository->create($request->all());

        if (! $product) {
            return $this->sendResponseBadRequest('Failed to create product');
        }

        return $this->sendResponseCreated($product, 'Product created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = $this->productRepository->find($id, ['category']);

        if (! $product) {
            return $this->sendResponseNotFound();
        }

        return $this->sendResponseOk($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->productRepository->delete($id);
        } catch (\Exception $e) {
            $this->sendResponseBadRequest('Failed to delete');
        }

        $this->sendResponseDeleted();
    }
}
