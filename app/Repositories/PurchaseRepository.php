<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;

class PurchaseRepository
{
    protected $product;
    protected $purchaseItem;
    protected $purchase;
    public function __construct(Purchase $purchase, PurchaseItem $purchaseItem, Product $product)
    {
        $this->purchase = $purchase;
        $this->purchaseItem = $purchaseItem;
        $this->product = $product;
    }

    public function create($input)
    {
        $purchase = new Purchase();
        $purchase->receipt_code = $input['receipt_code'];
        if (isset($input['photo'])) {
            $purchase->receipt_photo_directory = $input['photo'];
        }
        $purchase->receipt_date = $input['date'];
        $purchase->discount = $input['discount'];
        $purchase->tax = $input['tax'];
        $purchase->sub_total = 0;
        $purchase->grand_total = 0;
        $purchase->supplier_id = $input['supplier_id'];
        $purchase->salesman_id = $input['salesman_id'];
        $purchase->save();

        $purchaseItem = $this->createPurchaseItems($purchase);
        $purchase->sub_total = $purchaseItem;
        $purchase->grand_total = $purchaseItem - $purchase->tax - $purchase->discount;
        $purchase->save();
        return $purchase;
    }

    public function createPurchaseItems($purchase)
    {
        $carts = json_decode(request()->cookie('klinik-purchases-carts'), true);
        $total = 0;
        foreach ($carts as $cart) {
            $item = new PurchaseItem();
            $item->purchase_id = $purchase->id;
            $item->product_id = $cart['product_id'];
            $item->current_price = $cart['price'];
            $item->quantity = $cart['quantity'];
            $item->total = $item->current_price * $item->quantity;
            $item->save();
            $total += $item->total;
            $this->addStock($item->product_id, $item->quantity);
        }
        return $total;
    }

    public function addStock($productId, $qty)
    {
        return $this->product->find($productId)->increment('current_stock', $qty);
    }


    public function findById($id)
    {
        return $this->purchase->with('purchaseItems.product')->find($id);
    }

    public function update($input, $id)
    {
        $purchase = $this->purchase->find($id);
        $purchase->receipt_code = $input['receipt_code'];
        $purchase->receipt_date = $input['date'];
        $purchase->discount = $input['discount'];
        $purchase->tax = $input['tax'];
        $purchase->sub_total = 0;
        $purchase->grand_total = 0;
        if (array_key_exists('photo', $input)) {
            $purchase->receipt_photo_directory = $input['photo'];
        }
        $purchase->supplier_id = $input['supplier_id'];
        $purchase->salesman_id = $input['salesman_id'];
        $purchase->save();

        $purchaseItem = $this->updateItem($input, $id);
        $purchase->sub_total = $purchaseItem;
        $purchase->grand_total = $purchaseItem - $purchase->tax - $purchase->discount;
        $purchase->save();
        return $purchase;
    }

    public function updateItem($input, $purchase_id)
    {
        PurchaseItem::where('purchase_id', $purchase_id)->delete();
        $total = 0;
        for ($i = 0; $i < count($input['product_id']); $i++) {
            $item = new PurchaseItem();
            $item->purchase_id = $purchase_id;
            $item->product_id = $input['product_id'][$i];
            $item->current_price = $input['price'][$i];
            $item->quantity = $input['quantity'][$i];
            $item->total = $item->quantity * $item->current_price;
            $item->save();
            $total += $item->total;
        }
        return $total;
    }

    public function delete($id)
    {
        return $this->purchase->find($id)->delete();
    }
}
