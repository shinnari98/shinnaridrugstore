<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;

class ApiController extends Controller
{
    public function ajaxSearch()
    {
        // $keyword = $request->input('key');
        $data = Products::search()->get();
        $result  = [
            'status' => true,
            'message' => 'found '.$data->count().' result',
            'data' => $data
        ];
        return $data;
    }
}
