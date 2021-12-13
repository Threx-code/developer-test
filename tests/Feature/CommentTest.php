<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Comment;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CommentTest extends TestCase
{

    use DatabaseTransactions;

    private function create_comment()
    {
        return Comment::factory()->create();
    }

    // this should fail when no body and user id parameter is set
    public function test_request_should_fail_when_no_parameter_is_provided()
    {
        $response = $this->postJson(route('comment'), []);
        $response->assertStatus(422)
            ->assertJson([
                'body' => true,
                'user_id' => true,
            ]);
        $response->dump();
    }

    // this should fail when only the body parameter is set
    public function test_should_fail_when_only_body_parameter_is_provided()
    {
        $comment = $this->create_comment();
        $response = $this->postJson(route('comment'), [
            'body' => $comment->body,
        ]);
        $response->assertJsonMissingValidationErrors([
            'user_id'
        ]);
        $response->dump();
    }

    // this should fail when only the user ID parameter is set
    public function test_should_fail_when_only_user_id_parameter_is_provided()
    {
        $comment = $this->create_comment();
        $response = $this->postJson(route('comment'), [
            'user_id' => $comment->user_id
        ]);
        $response->assertJsonMissingValidationErrors([
            'body'
        ]);
        $response->dump();
    }

    // this should fail when invalid user ID is set
    public function test_should_fail_user_id_parameter_is_not_valid()
    {
        $comment = $this->create_comment();
        $response = $this->postJson(route('comment'), [
            'user_id' => 100000,
            'body' => $comment->body
        ]);
        $response->assertJsonMissingValidationErrors([
            'user_id'
        ]);
        $response->dump();
    }


    // this should pass when valid user ID is set and the body is provided
    public function test_should_pass_when_all_parameters_are_provided()
    {
        $comment = $this->create_comment();
        $response = $this->postJson(route('comment'), [
            'user_id' => $comment->user_id,
            'body' => $comment->body
        ]);
        $response->assertJsonMissingValidationErrors([
            'body',
            'user_id',
        ]);
        $response->assertOK();
        $response->dump();
    }
}
