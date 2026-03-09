<?php

namespace Database\Factories;

use DateInterval;
use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\File>
 */
class FileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = $this->faker->randomElement(['pdf', 'docx']);

        $uploadedFile = UploadedFile::fake()->create(
            sprintf('%s.%s', $this->faker->word(), $type),
            $this->faker->numberBetween(0, 10240),
            sprintf('application/%s', $type)
        );

        $interval = new DateInterval(sprintf(
            'PT%dH',
            $this->faker->numberBetween(0, 48)
        ));

        return [
            'name' => $uploadedFile->getClientOriginalName(),
            'path' => $uploadedFile->store('uploads'),
            'created_at' => (new DateTime())->sub($interval),
        ];
    }
}
