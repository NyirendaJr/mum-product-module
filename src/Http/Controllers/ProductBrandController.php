<?php

namespace Thelabdevtz\MumProductModule\Http\Controllers;

use Illuminate\Routing\Controller;
use Thelabdevtz\LaraBase\Core\ResponseHelpers;
use Thelabdevtz\MumProductModule\Repositories\Brand\BrandRepository;

class ProductBrandController extends Controller
{
    use ResponseHelpers;

    /** @var BrandRepository */
    private $brandRepository;

    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function index(){
        $productBrands = $this->brandRepository->listBrands(request()->all());
        return $this->sendResponseOk($productBrands, 'Brand List Ok');
    }
}
