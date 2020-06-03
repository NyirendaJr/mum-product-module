<?php


namespace Thelabdevtz\MumProductModule\Repositories\Brand;


use Illuminate\Support\Arr;
use Thelabdevtz\LaraBase\Core\BaseRepository;
use Thelabdevtz\MumProductModule\Models\Brand\ProductBrand;

class BrandRepository extends BaseRepository
{
    public function __construct(ProductBrand $model)
    {
        parent::__construct($model);
    }

    public function listBrands($params){
        return $this->get($params, [], function ($q) use ($params){
            $name = Arr::get($params, 'name', '');
            $q->where('name', 'like', "%{$name}");
            return $q;
        });
    }
}
