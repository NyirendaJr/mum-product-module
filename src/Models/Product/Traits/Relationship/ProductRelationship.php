<?php
/**
 * Created by PhpStorm.
 * User: nyirendajr
 * Date: 4/13/20
 * Time: 1:39 AM
 */

namespace Thelabdevtz\MumProductModule\Models\Product\Traits\Relationship;
use Thelabdevtz\MumProductModule\Models\Stock\Stock;
use Thelabdevtz\MumProductModule\Models\Category\ProductCategory;

trait ProductRelationship
{
    /**
     * get category of the product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category () {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }


    /**
     * get Stock of the product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stock(){
        return $this->belongsTo(Stock::class, 'stocks_id');
    }
}