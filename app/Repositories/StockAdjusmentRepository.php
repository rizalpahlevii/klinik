<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\StockAdjusment;

class StockAdjusmentRepository
{
    protected $stockAdjusment;
    protected $product;
    public function __construct(StockAdjusment $stockAdjusment, Product $product)
    {
        $this->product = $product;
        $this->stockAdjusment = $stockAdjusment;
    }
    public function create($input)
    {
        $stockAdjusment = $this->stockAdjusment->create(
            [
                'user_id' => auth()->id(),
                'quantity' => $input['quantity'],
                'note' => $input['note'],
                'product_id' => $input['product_id'],
                'type' => $input['type'],
            ]
        );
        if ($input['type'] == "addition") {
            $this->product->find($input['product_id'])->increment('current_stock', $input['quantity']);
        } else {
            $this->product->find($input['product_id'])->decrement('current_stock', $input['quantity']);
        }
        return $stockAdjusment;
    }

    public function update($input, $id)
    {
        $oldStock = $this->stockAdjusment->find($id);
        $product = $this->product->find($input['product_id_edit']);
        if ($input['type_edit'] == "addition") {
            $product->decrement('current_stock', $oldStock->quantity);
            $product->increment('current_stock', $input['quantity_edit']);
        } else {
            $product->increment('current_stock', $oldStock->quantity);
            $product->decrement('current_stock', $input['quantity_edit']);
        }
        $stockAdjusment = $this->stockAdjusment->find($id)->update(
            [
                'updated_by' => auth()->id(),
                'quantity' => $input['quantity_edit'],
            ]
        );
        return $stockAdjusment;
    }

    public function destroy($id)
    {
        $stockAdjusment = $this->stockAdjusment->find($id);
        if($stockAdjusment->type == "addition"){
            $this->product->find($stockAdjusment->product_id)->decrement('current_stock',$stockAdjusment->quantity); 
        }else{

        
        $this->product->find($stockAdjusment->product_id)->increment('current_stock', $stockAdjusment->quantity);
        }
        $stockAdjusment->delete();
        return $stockAdjusment;
    }
}
