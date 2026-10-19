<?php

namespace Tests\Feature;

use App\Models\Academic\Course;
use App\Models\People\Teacher;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_training_center_relationship_uses_the_correct_foreign_key(): void
    {
        $courseRelation = (new Course())->training_center();
        $teacherRelation = (new Teacher())->trainingCenter();

        $this->assertSame('training_centers_id', $courseRelation->getForeignKeyName());
        $this->assertSame('training_centers_id', $teacherRelation->getForeignKeyName());
    }
}
