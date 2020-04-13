<?php
/**
 * Created by PhpStorm.
 * User: nyirendajr
 * Date: 4/13/20
 * Time: 1:35 AM
 */

namespace Thelabdevtz\MumProductModule\Repositories\Product;
use Thelabdevtz\MumProductModule\Models\Product\Product;
use Illuminate\Support\Arr;
use Thelabdevtz\LaraBase\Core\BaseRepository;

class ProductRepository extends BaseRepository
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    public function listProducts($params) {

        return $this->get($params, ['category'], function ($q) use ($params){

            $name = Arr::get($params,'name','');
            //$stock_id = Arr::get($params, 'stock_id', '');

            $q->where('name','like',"%{$name}%");

            return $q;
        });
    }
}