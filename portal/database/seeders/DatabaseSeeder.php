<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            ['title' => 'Full Stack Development', 'description' => 'Build responsive interfaces, Laravel applications and REST APIs with practical projects.', 'duration' => '12 weeks', 'fee' => 45000],
            ['title' => 'Front-end Foundations', 'description' => 'Learn semantic HTML, CSS, Bootstrap and JavaScript through hands-on exercises.', 'duration' => '6 weeks', 'fee' => 18000],
            ['title' => 'PHP & MySQL Essentials', 'description' => 'Design relational databases and create secure server-side applications with PHP.', 'duration' => '8 weeks', 'fee' => 28000],
        ] as $course) {
            Course::firstOrCreate(['title' => $course['title']], [...$course, 'start_date' => now()->addMonth()->format('Y-m-d')]);
        }
    }
}
