<?php

namespace App\Components;

use App\Models\Menu;

class MenuRecusive{
    private $html;
    public function __construct()
    {
        $this->html = '' ;      
    }
    public function menuRecusiveAdd($p_id,$parent_id = 0, $text=''){
        $data = Menu::where('parent_id', $parent_id)->get();
        foreach ($data as $dataItem){
            if(!empty($p_id) && $p_id == $dataItem->id){
                $this->html.='<option selected value="'.$dataItem->id.'">'.$text.$dataItem->name;
            }else{
                $this->html.='<option value="'.$dataItem->id.'">'.$text.$dataItem->name;
            }
            $this->menuRecusiveAdd($p_id,$dataItem->id, $text.'--');
        }
        return $this->html;
    }
}
