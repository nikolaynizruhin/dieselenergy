<?php

namespace Tests\Feature\Admin\Post;

use App\Models\Post;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

trait HasValidation
{
    public static function provider(int $count = 1): array
    {
        return [
            'Title is required' => [
                'title', fn () => self::validFields(['title' => null]),
            ],
            'Title cant be an integer' => [
                'title', fn () => self::validFields(['title' => 1]),
            ],
            'Title cant be more than 255 chars' => [
                'title', fn () => self::validFields(['title' => Str::random(256)]),
            ],
            'Title must be unique' => [
                'title', fn () => self::validFields(['title' => Post::factory()->create()->title]), $count,
            ],
            'Excerpt is required' => [
                'excerpt', fn () => self::validFields(['excerpt' => null]),
            ],
            'Excerpt cant be an integer' => [
                'excerpt', fn () => self::validFields(['excerpt' => 1]),
            ],
            'Slug must be unique' => [
                'slug', fn () => self::validFields(['slug' => Post::factory()->create()->slug]), $count,
            ],
            'Slug is required' => [
                'slug', fn () => self::validFields(['slug' => null]),
            ],
            'Slug cant be an integer' => [
                'slug', fn () => self::validFields(['slug' => 1]),
            ],
            'Slug cant be more than 255 chars' => [
                'slug', fn () => self::validFields(['slug' => Str::random(256)]),
            ],
            'Body is required' => [
                'body', fn () => self::validFields(['body' => null]),
            ],
            'Body cant be an integer' => [
                'body', fn () => self::validFields(['body' => 1]),
            ],
            'Image is required' => [
                'image', fn () => self::validFields(['image' => null]),
            ],
            'Image cant be an integer' => [
                'image', fn () => self::validFields(['image' => 1]),
            ],
            'Image cant be a string' => [
                'image', fn () => self::validFields(['image' => 'string']),
            ],
            'Image cant be a pdf file' => [
                'image', fn () => self::validFields(['image' => UploadedFile::fake()->create('document.pdf', 1, 'application/pdf')]),
            ],
        ];
    }

    /**
     * Get valid post fields.
     */
    private static function validFields(array $overrides = []): array
    {
        return Post::factory()->raw($overrides);
    }
}
