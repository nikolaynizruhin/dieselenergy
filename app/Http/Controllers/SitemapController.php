<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Response;

class SitemapController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): HttpResponse
    {
        return Response::view('sitemap', [
            'products' => Product::active()->get(),
            'posts' => Post::all(),
            'categories' => Category::withProductCount()->get(),
        ])->header('Content-Type', 'application/xml');
    }
}
