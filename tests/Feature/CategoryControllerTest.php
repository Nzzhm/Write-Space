<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_create_category()
    {
        // Sesuaikan dengan cara cek role admin di aplikasi kamu
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post(route('categories.store'), [
            'name' => 'Teknologi',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('categories', [
            'name' => 'Teknologi',
            'slug' => 'teknologi',
        ]);
    }

    /** @test */
    public function category_name_is_required()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post(route('categories.store'), [
            'name' => '',
        ]);

        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function category_show_displays_articles()
    {
        $category = Category::factory()->create();

        $response = $this->get(route('categories.show', $category));

        $response->assertStatus(200);
    }
}