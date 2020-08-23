<?php

namespace App\Presenters;

class OrderMailPresenter extends Presenter
{
    public function makeData()
    {
        $currencies = \App\Services\ShopService::CURRENCIES;
        $items = collect($this->model->items)->map(function($item){
            return $item->load('product');
        });

        return [
            'id' => $this->model->id,
            'name' => $this->model->name,
            'email' => $this->model->email,
            'phone' => $this->model->phone,
            'address' => $this->model->address,
            'total' => $this->model->total,
            'items' => $items,
            'currency' => $currencies[$this->model->currency]['sign'],
            'td_style' => 'border:1px solid #ccc;padding:3px 6px;',
        ];
    }
}