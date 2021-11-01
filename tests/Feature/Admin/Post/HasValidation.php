<?php

namespace Tests\Feature\Admin\Post;

use App\Models\Post;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

trait HasValidation
{
    public function provider($count = 1): array
    {
        return [
            'Title is required' => [
                'title', fn () => $this->validFields(['title' => null]),
            ],
            'Title cant be an integer' => [
                'title', fn () => $this->validFields(['title' => 1]),
            ],
            'Title cant be more than 255 chars' => [
                'title', fn () => $this->validFields(['title' => Str::random(256)]),
            ],
            'Title must be unique' => [
                'title', fn () => $this->validFields(['title' => Post::factory()->create()->title]), $count,
            ],
            'Excerpt is required' => [
                'excerpt', fn () => $this->validFields(['excerpt' => null]),
            ],
            'Excerpt cant be an integer' => [
                'excerpt', fn () => $this->validFields(['excerpt' => 1]),
            ],
            'Slug must be unique' => [
                'slug', fn () => $this->validFields(['slug' => Post::factory()->create()->slug]), $count,
            ],
            'Slug is required' => [
                'slug', fn () => $this->validFields(['slug' => null]),
            ],
            'Slug cant be an integer' => [
                'slug', fn () => $this->validFields(['slug' => 1]),
            ],
            'Slug cant be more than 255 chars' => [
                'slug', fn () => $this->validFields(['slug' => Str::random(256)]),
            ],
            'Body is required' => [
                'body', fn () => $this->validFields(['body' => null]),
            ],
            'Body cant be an integer' => [
                'body', fn () => $this->validFields(['body' => 1]),
            ],
            'Image is required' => [
                'image', fn () => $this->validFields(['image' => null]),
            ],
            'Image cant be an integer' => [
                'image', fn () => $this->validFields(['image' => 1]),
            ],
            'Image cant be a string' => [
                'image', fn () => $this->validFields(['image' => 'string']),
            ],
            'Image cant be a pdf file' => [
                'image', fn () => $this->validFields(['image' => UploadedFile::fake()->create('document.pdf', 1, 'application/pdf')]),
            ],
        ];
    }

    /**
     * Get valid post fields.
     *
     * @param  array  $overrides
     * @return array
     */
    private function validFields(array $overrides = []): array
    {
        return Post::factory()->raw($overrides);
    }
}
