<?php


namespace Thelabdevtz\MumProductModule\Http\Controllers;


use Illuminate\Routing\Controller;
use Thelabdevtz\MumProductModule\Repositories\Brand\BrandRepository;

class ProductBrandController extends Controller
{

    /** @var BrandRepository */
    private $brandRepository;

    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }


}
