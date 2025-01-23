<?php

use Illuminate\Support\Facades\Log;

function format_product($item)
{
    $data = explode(';', $item);
    return $data[1].'  -  Rp'.number_format(intval($data[0]));
}

function get_price($item)
{
    $data = explode(';', $item);
    return intval($data[0]);
}

function count_range($bahan, $laminating)
{
    $min_bahan=PHP_INT_MAX;
    $max_bahan=0;
    $max_laminating=0;
    $arr_bahan = explode(',',substr($bahan, 1));
    $arr_laminating = explode(',',substr($laminating, 1));
    
    if($arr_bahan){
        foreach($arr_bahan as $i){
            $nilai = intval(explode(';', $i)[0]);
            if($nilai > $max_bahan) $max_bahan = $nilai;
            if($nilai < $min_bahan) $min_bahan = $nilai;
        }
    }

    if($arr_laminating){
        foreach($arr_laminating as $i){
            $nilai = intval(explode(';', $i)[0]);
            if($nilai > $max_laminating) $max_laminating = $nilai;
        }
    }

    return 'Rp'.number_format($min_bahan).'-'.number_format($max_bahan+$max_laminating);
}
