<?php
/**
 * Created by PhpStorm.
 * User: nyirendajr
 * Date: 4/13/20
 * Time: 1:43 AM.
 */

namespace Thelabdevtz\MumProductModule\Models\Category;

use Illuminate\Database\Eloquent\Model;
use Thelabdevtz\MumProductModule\Models\Product\Traits\Relationship\ProductRelationship;

class ProductCategory extends Model
{
    use ProductRelationship;

    protected $fillable = [
        'name',
        'product_category_id',
        'manufacturing_date',
        'expire_date',
        'buying_price',
        'selling_price',
        'description',
        'is_active',
        'stocks_id',
    ];
}
