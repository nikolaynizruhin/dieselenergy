<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class SitemapController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return Response::view('sitemap', [
            'products' => Product::active()->get(),
            'posts' => Post::all(),
            'categories' => Category::withProductCount()->get(),
        ])->header('Content-Type', 'application/xml');
    }
}
