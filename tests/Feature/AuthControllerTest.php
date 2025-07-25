<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\JobPosition;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Buat role default untuk testing
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'karyawan', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'direksi', 'guard_name' => 'web']);
    }

    /** @test */
    public function bisa_melihat_form_login()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertViewIs('pages.auth.login');
    }

    /** @test */
    public function bisa_login_dengan_data_yang_benar()
    {
        $user = User::create([
            'nip' => '123456',
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'role' => 'karyawan',
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123'
        ]);

        $response->assertRedirect('dashboard');
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function gagal_login_dengan_data_yang_salah()
    {
        User::create([
            'nip' => '123456',
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'role' => 'karyawan',
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword'
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /** @test */
    public function bisa_melihat_form_registrasi()
    {
        JobPosition::create(['name' => 'Staff HRD']);
        JobPosition::create(['name' => 'Admin']);

        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertViewIs('pages.auth.register');
        $response->assertViewHas('jobPositions');
    }

    /** @test */
    public function bisa_mendaftarkan_user_baru()
    {
        $job = JobPosition::create(['name' => 'Staff Marketing']);

        $response = $this->post('/register', [
            'nip' => '78910',
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'password' => 'password123',
            'job_position_id' => $job->id,
            'join_date' => '2025-07-22'
        ]);

        $response->assertRedirect('/');
        $this->assertDatabaseHas('users', [
            'email' => 'newuser@example.com',
            'role' => 'karyawan'
        ]);
    }

    /** @test */
    public function bisa_logout_dengan_benar()
    {
        $user = User::create([
            'nip' => '55555',
            'name' => 'Logout User',
            'email' => 'logout@example.com',
            'password' => Hash::make('password123'),
            'role' => 'karyawan',
        ]);

        $this->actingAs($user);

        $response = $this->get('/logout');
        $response->assertRedirect('/');
        $this->assertGuest();
    }
}
