<?php

namespace App\Filters;
use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;

class MenuFilter implements FilterInterface
{
    public function transform($item) {
        // dd($item);
        if (isset($item['permission'])) {
            if(!auth()->user()->isAbleTo($item['permission'])){
                return false;
            } 
        }
        
        return $item;
    }
}