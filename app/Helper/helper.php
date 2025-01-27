<?php

use Illuminate\Support\Facades\Log;

function format_product($item)
{
    $data = explode(';', $item);
    // Log::debug($data);
    // Log::debug('hai');
    // return $data[0];
    // dd($data);
    if (count($data) > 1) {
        return $data[1] . '  -  Rp' . number_format(intval($data[0]));
    }
    return "";
}

function format_products($item)
{
    $item = explode(',', substr($item, 1));
    $data = '';
    return $data;
    // $data = explode(';', $item);
    // return $data[1].'  -  Rp'.number_format(intval($data[0]));
}

function get_item_transaksi($item)
{
    $datas = explode(',', substr($item, 1));
    $data = '';

    foreach ($datas as $i) {
        $i = explode(';', $i);
        $name = $i[0];
        $bahan = $i[1];
        $laminating = $i[2] == '' ? '' : '<br>laminating: ' . $i[2];
        $quantity = $i[3];
        $total_price = $i[4];
        $data = $data.$name .
            '<br>bahan: ' . $bahan .
            $laminating .
            '<br>jml: ' . $quantity
            . '<br/>';
        // $data = $data.implode(' - ', $i).'<br>';
    }

    return $data;
}

function short_text($item)
{
    return substr($item, 0, 20);
}

function get_price($item)
{
    $data = explode(';', $item);
    return intval($data[0]);
}

function count_range($bahan, $laminating)
{
    $min_bahan = PHP_INT_MAX;
    $max_bahan = 0;
    $max_laminating = 0;
    $arr_bahan = explode(',', substr($bahan, 1));
    $arr_laminating = explode(',', substr($laminating, 1));

    if ($arr_bahan) {
        foreach ($arr_bahan as $i) {
            $nilai = intval(explode(';', $i)[0]);
            if ($nilai > $max_bahan) $max_bahan = $nilai;
            if ($nilai < $min_bahan) $min_bahan = $nilai;
        }
    }

    if ($arr_laminating) {
        foreach ($arr_laminating as $i) {
            $nilai = intval(explode(';', $i)[0]);
            if ($nilai > $max_laminating) $max_laminating = $nilai;
        }
    }

    return 'Rp' . number_format($min_bahan) . '-' . number_format($max_bahan + $max_laminating);
}
