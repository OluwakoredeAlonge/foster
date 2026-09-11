<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_superadmin_setup_screen_can_be_rendered_when_no_admin_exists(): void
    {
        $response = $this->get('/superadmin/register');

        $response->assertStatus(200);
    }

    public function test_superadmin_can_be_created(): void
    {
        $response = $this->post('/superadmin/register', [
            'name' => 'Dr. Soje',
            'email' => 'admin@fosterheirs.test',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('admin.courses.index'));

        $this->assertDatabaseHas('users', [
            'email' => 'admin@fosterheirs.test',
            'role' => 'admin',
        ]);
    }

    public function test_setup_screen_redirects_to_login_once_an_admin_already_exists(): void
    {
        User::factory()->create(['role' => 'admin']);

        $response = $this->get('/superadmin/register');

        $response->assertRedirect(route('login'));
    }

    public function test_setup_cannot_create_a_second_admin_once_one_exists(): void
    {
        User::factory()->create(['role' => 'admin']);

        $response = $this->post('/superadmin/register', [
            'name' => 'Someone Else',
            'email' => 'someone-else@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertGuest();
        $this->assertDatabaseMissing('users', ['email' => 'someone-else@example.com']);
    }
}
