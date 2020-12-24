<?php

namespace App\Http\Controllers;

use App\Product;
use App\Store;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = $this->product->limit(6)->orderBy('id', 'DESC')->get();
        $stores = Store::limit(3)->get();

        return view('home', compact(['products', 'stores']));
    }

    public function single($slug)
    {
        $product = $this->product->whereSlug($slug)->first();
        return view('single', compact('product'));
    }
}
