<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
use App\Models\Visitor;

class VisitorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Visitor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $bool = $this->faker->boolean;
        return [
            'os' => $this->faker->randomElement(['Windows', 'Mac', 'Linux']),
            'ip' => $this->faker->ipv4,
            'browser' => $this->faker->randomElement(['Chrome', 'Firefox', 'Safari']),
            'payment' => $bool ? $this->faker->randomFloat(4, 0, 0.008) : 0.000,
            'is_unique' => $bool,
            'earning_disable' => false,
        ];
    }


    public function user($userId)
    {
        return $this->state(function (array $attributes) use ($userId) {
            return [
                'user_id' => $userId,
            ];
        });
    }

    public function shortenUrl($shortenUrlId)
    {
        return $this->state(function (array $attributes) use ($shortenUrlId) {
            return [
                'shorten_url_id' => $shortenUrlId,
            ];
        });
    }
}
