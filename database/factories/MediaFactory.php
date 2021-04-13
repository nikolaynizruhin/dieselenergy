<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\Media;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class MediaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Media::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'image_id' => Image::factory(),
            'product_id' => Product::factory(),
            'is_default' => $this->faker->boolean(),
        ];
    }

    /**
     * Indicate that the media is default.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function default()
    {
        return $this->state(['is_default' => 1]);
    }
}
