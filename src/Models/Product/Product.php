<?php
/**
 * Created by PhpStorm.
 * User: nyirendajr
 * Date: 4/13/20
 * Time: 1:37 AM.
 */

namespace Thelabdevtz\MumProductModule\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Thelabdevtz\MumProductModule\Models\Product\Traits\Relationship\ProductRelationship;

class Product extends Model
{
    use ProductRelationship;

    protected $guarded = [];
}
