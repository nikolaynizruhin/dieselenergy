<?php

namespace Tests\Feature\Admin\Post;

use App\Models\Customer;
use App\Models\Post;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

dataset('create_post', provider());
dataset('update_post', provider(2));

function provider(int $count = 1): array
{
    return [
        'Title is required' => [
            'title', fn () => validFields(['title' => null]),
        ],
        'Title cant be an integer' => [
            'title', fn () => validFields(['title' => 1]),
        ],
        'Title cant be more than 255 chars' => [
            'title', fn () => validFields(['title' => Str::random(256)]),
        ],
        'Title must be unique' => [
            'title', fn () => validFields(['title' => Post::factory()->create()->title]), $count,
        ],
        'Excerpt is required' => [
            'excerpt', fn () => validFields(['excerpt' => null]),
        ],
        'Excerpt cant be an integer' => [
            'excerpt', fn () => validFields(['excerpt' => 1]),
        ],
        'Slug must be unique' => [
            'slug', fn () => validFields(['slug' => Post::factory()->create()->slug]), $count,
        ],
        'Slug is required' => [
            'slug', fn () => validFields(['slug' => null]),
        ],
        'Slug cant be an integer' => [
            'slug', fn () => validFields(['slug' => 1]),
        ],
        'Slug cant be more than 255 chars' => [
            'slug', fn () => validFields(['slug' => Str::random(256)]),
        ],
        'Body is required' => [
            'body', fn () => validFields(['body' => null]),
        ],
        'Body cant be an integer' => [
            'body', fn () => validFields(['body' => 1]),
        ],
        'Image is required' => [
            'image', fn () => validFields(['image' => null]),
        ],
        'Image cant be an integer' => [
            'image', fn () => validFields(['image' => 1]),
        ],
        'Image cant be a string' => [
            'image', fn () => validFields(['image' => 'string']),
        ],
        'Image cant be a pdf file' => [
            'image', fn () => validFields(['image' => UploadedFile::fake()->create('document.pdf', 1, 'application/pdf')]),
        ],
    ];
}

function validFields(array $overrides = []): array
{
    return Post::factory()->raw($overrides);
}
