<?php
/**
 * Created by PhpStorm.
 * User: nyirendajr
 * Date: 4/13/20
 * Time: 1:42 AM.
 */

namespace Thelabdevtz\MumProductModule\Models\Stock\Traits\Relationship;

use Thelabdevtz\MumProductModule\Models\Product\Product;

trait StockRelationship
{
    /**
     * get products of the stock.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
