<?php
/**
 * Created by PhpStorm.
 * User: nyirendajr
 * Date: 4/13/20
 * Time: 1:41 AM.
 */

namespace Thelabdevtz\MumProductModule\Models\Stock;

use Illuminate\Database\Eloquent\Model;
use Thelabdevtz\MumProductModule\Models\Stock\Traits\Relationship\StockRelationship;

class Stock extends Model
{
    use StockRelationship;
}
