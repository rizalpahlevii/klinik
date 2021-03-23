<?php

namespace App\Repositories;

use App\Models\Sale;
use App\Models\SaleItem;
use Request;

class SaleRepository
{
    protected $sale;
    protected $saleItem;
    public function __construct(Sale $sale, SaleItem $saleItem)
    {
        $this->sale = $sale;
        $this->saleItem = $saleItem;
    }
    public function create($input)
    {
        $sale = new Sale();
        $sale->receipt_date = $input['date'];
        $sale->buyer_type = $input['buyer_type'];
        $sale->buyer_name = $input['buyer_type'] == "general" ? $input['buyer_name'] : $input['member_buyer_name'];
        $sale->discount = $input['discount'];
        $sale->tax = $input['tax'];
        $sale->sub_total = 0;
        $sale->grand_total = 0;
        $sale->doctor_id = $input['medic_id'] != "" ? $input['medic_id'] : NULL;
        $sale->payment_method = $input['payment_method'];
        $sale->save();

        $saleItem = $this->createSaleItems($sale);
        $sale->sub_total = $saleItem;
        $sale->grand_total = $saleItem - $sale->tax - $sale->discount;
        $sale->save();
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
        }
        return $total;
    }
}
