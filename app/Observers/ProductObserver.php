<?php

namespace App\Observers;

use App\Models\Product;
use App\Services\Conformity;
use App\Services\Transliterator;

class ProductObserver
{


    /**
     * Handle the Product "saving" event.
     *
     * @param Product $product
     * @param Transliterator $transliterator
     * @param Conformity $conformity
     * @return void
     */
    public function saving(Product $product, Transliterator $transliterator, Conformity $conformity)
    {
        $primaryCategories = $conformity->getPrimaryCategoriesForProducts();

        if (!$product->transliterated_name) {
             $product->transliterated_name = $transliterator->transliterate($product->name);
        }
    }
}
