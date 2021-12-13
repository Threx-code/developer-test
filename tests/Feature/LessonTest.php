<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Lesson;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LessonTest extends TestCase
{
    use DatabaseTransactions;

    private function create_lesson()
    {
        $user = User::factory()->create();
        $lesson = Lesson::factory()->create();

        return [
            'user_id' => $user->id,
            'lesson_id' => $lesson->id,
            'title' => $lesson->title,
        ];
    }

    //this should fail when there is no title provided when creating lesson
    public function test_should_fail_when_no_title_is_provided()
    {
        $response = $this->postJson(route('create.lesson'), []);
        $response->assertStatus(422)
            ->assertJson([
                'title' => true
            ]);
        $response->dump();
    }


    //this should fail when there is no title provided when creating lesson
    public function test_should_fail_when_lesson_title_already_exist()
    {
        $data = $this->create_lesson();
        $response = $this->postJson(route('create.lesson'), [
            'title' => $data['title']
        ]);
        $response->assertJsonMissingValidationErrors([
            'title'
        ]);
        $response->dump();
    }


    //this should fail when there is no title provided when creating lesson
    public function test_should_pass_when_lesson_title_is_passed_and_does_not_exist()
    {
        $data = $this->create_lesson();
        $response = $this->postJson(route('create.lesson'), [
            'title' => $data['title'] . Str::random(10),
        ]);
        $response->assertJsonMissingValidationErrors([
            'title'
        ]);
        $response->assertOK();
        $response->dump();
    }


    /*  ============================================
                testing for lesson watch
        =============================================
    */

    //this should fail when no parameter is set
    public function test_should_fail_when_no_user_id_and_lesson_id_are_provided()
    {
        $response = $this->postJson(route('watch.lesson'), []);
        $response->assertStatus(422)
            ->assertJson([
                'user_id' => true,
                'lesson_id' => true
            ]);
        $response->dump();
    }

    // test should fail when only the user id is providied
    public function test_should_fail_when_only_user_id_is_provided()
    {
        $data = $this->create_lesson();
        $response = $this->postJson(route('watch.lesson'), [
            'user_id' => $data['user_id'],
        ]);

        $response->assertJsonMissingValidationErrors([
            'lesson_id'
        ]);
        $response->dump();
    }

    // test should fail when only the user id is providied
    public function test_should_fail_when_wrong_user_id_is_provided()
    {
        $data = $this->create_lesson();
        $response = $this->postJson(route('watch.lesson'), [
            'user_id' => 100000,
            'lesson_id' => $data['lesson_id'],
        ]);

        $response->assertJsonMissingValidationErrors([
            'user_id'
        ]);
        $response->dump();
    }


    // test should fail when only the lesson id is provided
    public function test_should_fail_when_only_lesson_id_is_provided()
    {
        $data = $this->create_lesson();
        $response = $this->postJson(route('watch.lesson'), [
            'lesson_id' => $data['lesson_id'],
        ]);

        $response->assertJsonMissingValidationErrors([
            'user_id'
        ]);
        $response->dump();
    }

    // test should fail when only the lesson id is provided
    public function test_should_fail_when_wrong_lesson_id_is_provided()
    {
        $data = $this->create_lesson();
        $response = $this->postJson(route('watch.lesson'), [
            'lesson_id' => 100000,
            'user_id' => $data['user_id'],
        ]);

        $response->assertJsonMissingValidationErrors([
            'lesson_id'
        ]);
        $response->dump();
    }


    // test should fail when only the lesson id is provided
    public function test_should_pass_when_user_id_and_lesson_id_provided_exist()
    {
        $data = $this->create_lesson();
        $response = $this->postJson(route('watch.lesson'), [
            'lesson_id' => $data['lesson_id'],
            'user_id' => $data['user_id'],
        ]);

        $response->assertJsonMissingValidationErrors([
            'lesson_id',
            'user_id'
        ]);
        $response->assertOK();
        $response->dump();
    }
}
