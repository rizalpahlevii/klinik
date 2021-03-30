<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Request;

class SaleRepository
{
    protected $sale;
    protected $saleItem;
    protected $product;
    public function __construct(Sale $sale, SaleItem $saleItem, Product $product)
    {
        $this->product = $product;
        $this->sale = $sale;
        $this->saleItem = $saleItem;
    }
    public function create($input)
    {
        $sale = new Sale();
        $sale->receipt_date = $input['date'];
        $sale->buyer_type = $input['buyer_type'];
        $sale->buyer_name = $input['buyer_type'] == "general" ? $input['buyer_name'] : $input['member_buyer_name'];
        $sale->discount = $input['discount_hidden'];
        $sale->tax = $input['tax_hidden'];
        $sale->sub_total = 0;
        $sale->grand_total = 0;
        $sale->doctor_id = $input['medic_id'] != "" ? $input['medic_id'] : NULL;
        $sale->payment_method = $input['payment_method'];
        $sale->save();

        $saleItem = $this->createSaleItems($sale);
        $sale->sub_total = $saleItem;
        $sale->grand_total = $saleItem - $sale->tax - $sale->discount;
        $sale->save();
        return $sale;
    }

    public function update($input, $id)
    {
        $sale = $this->sale->find($id);
        $sale->receipt_date = $input['date'];
        $sale->buyer_type = $input['buyer_type'];
        $sale->buyer_name = $input['buyer_type'] == "general" ? $input['buyer_name'] : $input['member_buyer_name'];
        $sale->discount = convertCurrency($input['discount']);
        $sale->tax = convertCurrency($input['tax']);
        $sale->sub_total = 0;
        $sale->grand_total = 0;
        $sale->doctor_id = $input['medic_id'] != "" ? $input['medic_id'] : NULL;
        $sale->payment_method = $input['payment_method'];
        $sale->save();

        $saleItem = $this->updateSaleItems($input, $sale->id);
        $sale->sub_total = $saleItem;
        $sale->grand_total = $saleItem - $sale->tax - $sale->discount;
        $sale->save();
        return $sale;
    }

    public function updateSaleItems($input, $sale_id)
    {
        SaleItem::where('sale_id', $sale_id)->delete();
        $total = 0;
        for ($i = 0; $i < count($input['product_id']); $i++) {
            $item = new SaleItem();
            $item->sale_id = $sale_id;
            $item->product_id = $input['product_id'][$i];
            $item->current_price = convertCurrency($input['price'][$i]);
            $item->quantity = $input['quantity'][$i];
            $item->total = $item->quantity * $item->current_price;
            $item->save();
            $total += $item->total;
        }
        return $total;
    }

    public function createSaleItems($sale)
    {
        $carts = json_decode(request()->cookie('klinik-sales-carts'), true);
        $total = 0;
        foreach ($carts as $cart) {
            $item = new SaleItem();
            $item->sale_id = $sale->id;
            $item->product_id = $cart['product_id'];
            $item->current_price = $cart['price'];
            $item->quantity = $cart['quantity'];
            $item->total = $item->current_price * $item->quantity;
            $item->save();
            $total += $item->total;
            $this->reduceStock($item->product_id, $item->quantity);
        }
        return $total;
    }

    public function reduceStock($productId, $qty)
    {
        return $this->product->find($productId)->decrement('current_stock', $qty);
    }

    public function findById($id)
    {
        return $this->sale->with('saleItems.product', 'medic')->find($id);
    }
}
