<?php

namespace App\Observers;

use App\Mail\SendSaleNotification;
use App\Models\SaleItem;
use App\Models\User;
use Mail;

class SaleItemObserver
{
    /**
     * Handle the sale item "created" event.
     *
     * @param  \App\SaleItem  $saleItem
     * @return void
     */
    public function created(SaleItem $saleItem)
    {
        $sale = $saleItem->sale;

        $sale->increaseTotal($saleItem->total);
        $sale->save();


        $product = $saleItem->product;
        $product->current_stock -= $saleItem->quantity;
        $product->save();

        $ownersEmail = User::role('owner')->get()->pluck('email')->toArray();
        foreach ($ownersEmail as $email) {
            if ($email != null) Mail::to($email)->send(new SendSaleNotification($sale, $email));
        }
    }

    /**
     * Handle the sale item "updated" event.
     *
     * @param  \App\SaleItem  $saleItem
     * @return void
     */
    public function updated(SaleItem $saleItem)
    {
        if ($saleItem->isDirty('quantity')) {
            // Change Sale Total
            $previousItemTotal = $saleItem->getOriginal('total');
            $currentItemTotal = $saleItem->total;

            $sale = $saleItem->sale;
            $sale->decreaseTotal($previousItemTotal);
            $sale->increaseTotal($currentItemTotal);
            $sale->save();

            // Change product quantity stock
            $previousQuantity = $saleItem->getOriginal('quantity');
            $currentQuantity = $saleItem->quantity;

            $product = $saleItem->product;
            $product->current_stock += $previousQuantity;
            $product->current_stock -= $currentQuantity;
            $product->save();
        }
    }

    /**
     * Handle the sale item "deleted" event.
     *
     * @param  \App\SaleItem  $saleItem
     * @return void
     */
    public function deleted(SaleItem $saleItem)
    {
        $sale = $saleItem->sale;
        $sale->decreaseTotal($saleItem->total);
        $sale->save();

        $product = $saleItem->product;
        $product->current_stock += $saleItem->quantity;
        $product->save();
    }

    /**
     * Handle the sale item "restored" event.
     *
     * @param  \App\SaleItem  $saleItem
     * @return void
     */
    public function restored(SaleItem $saleItem)
    {
        $sale = $saleItem->sale;
        $sale->increaseTotal($saleItem->total);
        $sale->save();

        $product = $saleItem->product;
        $product->current_stock -= $saleItem->quantity;
        $product->save();
    }

    /**
     * Handle the sale item "force deleted" event.
     *
     * @param  \App\SaleItem  $saleItem
     * @return void
     */
    public function forceDeleted(SaleItem $saleItem)
    {
        $sale = $saleItem->sale;
        $sale->decreaseTotal($saleItem->total);
        $sale->save();

        $product = $saleItem->product;
        $product->current_stock += $saleItem->quantity;
        $product->save();
    }
}
