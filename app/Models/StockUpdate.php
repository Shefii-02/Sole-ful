<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockUpdate extends Model
{
    protected $fillable = ['product_id', 'variation_id', 'last_stock', 'updated_stock'];

    public static function createStockUpdate($productId, $variationId, $lastStock, $updatedStock)
    {
        return self::create([
            'product_id' => $productId,
            'variation_id' => $variationId,
            'last_stock' => $lastStock,
            'updated_stock' => $updatedStock
        ]);
    }
}
