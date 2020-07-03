<?php
/**
 * Created by PhpStorm.
 * User: nyirendajr
 * Date: 4/1/20
 * Time: 8:12 PM.
 */

namespace Thelabdevtz\MumProductModule\Repositories\Stock;

use Thelabdevtz\LaraBase\Core\BaseRepository;
use Thelabdevtz\MumProductModule\Models\Stock\Stock;

class StockRepository extends BaseRepository
{
    public function __construct(Stock $model)
    {
        parent::__construct($model);
    }

    public function listStock()
    {
        return $this->get([], ['products'], function ($q) {
            return $q->orderBy('created_at', 'desc');
        });
    }
}
