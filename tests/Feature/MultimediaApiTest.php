<?php

namespace Tests\Feature;

use App\Models\Multimedia;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MultimediaApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_upload_multimedia()
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $file = UploadedFile::fake()->image('test.jpg');

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/multimedia', [
            'file' => $file,
        ]);

        $response->assertStatus(201);

        $storedFileName = time() . '_' . $file->getClientOriginalName();
        $this->assertDatabaseHas('multimedia', ['user_id' => $user->id, 'name' => $storedFileName]);
        Storage::disk('public')->assertExists('multimedia/' . $storedFileName);
    }
    public function test_user_can_view_own_multimedia()
    {
        $user = User::factory()->create();
        Multimedia::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/user/multimedia');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
    }

    public function test_user_can_delete_own_multimedia()
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $multimedia = Multimedia::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'sanctum')->deleteJson("/api/multimedia/{$multimedia->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('multimedia', ['id' => $multimedia->id]);
        Storage::disk('public')->assertMissing('multimedia/' . $multimedia->name);
    }
}