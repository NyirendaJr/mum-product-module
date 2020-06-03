<?php
/**
 * Created by PhpStorm.
 * User: nyirendajr
 * Date: 4/13/20
 * Time: 1:35 AM.
 */

namespace Thelabdevtz\MumProductModule\Repositories\Product;

use Illuminate\Support\Arr;
use Thelabdevtz\LaraBase\Core\BaseRepository;
use Thelabdevtz\MumProductModule\Models\Product\Product;

class ProductRepository extends BaseRepository
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    public function listProducts($params)
    {
        return $this->get($params, ['category', 'stock'], function ($q) use ($params) {
            $name = Arr::get($params, 'name', '');
            $q->where('name', 'like', "%{$name}%");

            return $q;
        });
    }
}
