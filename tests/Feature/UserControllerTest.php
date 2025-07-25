<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\JobPosition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // ✅ Pastikan semua role tersedia
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'karyawan']);
        Role::firstOrCreate(['name' => 'direksi']); // <--- Tambahkan ini

        $this->withoutMiddleware(); // ✅ bypass semua auth/policy

        // Buat user dan login
        $admin = User::create([
            'nip'        => '99999',
            'name'       => 'Admin',
            'email'      => 'admin@example.com',
            'password'   => Hash::make('password'),
            'role'       => 'admin',
            'join_date'  => now()->format('Y-m-d'),
        ]);

        $this->actingAs($admin);
    }

    /** @test */
    public function bisa_melihat_halaman_index_user()
    {
        $response = $this->get(route('user.index'));
        $response->assertStatus(200);
        $response->assertViewIs('pages.user.index');
        $response->assertViewHas('users');
    }

    /** @test */
    public function bisa_melihat_form_tambah_user()
    {
        JobPosition::create(['name' => 'Staff IT']);

        $response = $this->get(route('user.create'));
        $response->assertStatus(200);
        $response->assertViewIs('pages.user.create');
        $response->assertViewHasAll(['jobPositions', 'user']);
    }

    /** @test */
    public function bisa_menyimpan_banyak_user()
    {
        $job = JobPosition::create(['name' => 'Staff IT']);

        $response = $this->post(route('user.storeMultiple'), [
            'users' => [
                [
                    'nip' => '11111',
                    'name' => 'User One',
                    'email' => 'user1@example.com',
                    'password' => 'password123',
                    'job_position_id' => $job->id, // ✅ pastikan valid
                    'role' => 'karyawan',
                    'join_date' => now()->format('Y-m-d'),
                ],
                [
                    'nip' => '22222',
                    'name' => 'User Two',
                    'email' => 'user2@example.com',
                    'password' => 'password123',
                    'job_position_id' => $job->id,
                    'role' => 'direksi',
                    'join_date' => now()->format('Y-m-d'),
                ],
            ]
        ]);

        $response->assertRedirect(route('user.index'));
        $this->assertDatabaseHas('users', ['email' => 'user1@example.com']);
    }


    public function bisa_melihat_form_edit_user(): void
    {
        $this->withoutMiddleware(\Illuminate\View\Middleware\ShareErrorsFromSession::class);

        $user = User::factory()->create();

        $response = $this->get(route('user.edit', $user->id));

        $response->assertStatus(200);
        $response->assertViewIs('pages.user.edit');
        $response->assertViewHas('user');
    }


    /** @test */
    public function bisa_update_user()
    {
        $job = JobPosition::create(['name' => 'Staff IT']);
        $user = User::create([
            'nip' => '12345',
            'name' => 'Old User',
            'email' => 'old@example.com',
            'password' => Hash::make('password'),
            'job_position_id' => $job->id,
            'role' => 'karyawan',
            'join_date' => now()->format('Y-m-d'),
        ]);

        $response = $this->put(route('user.update', $user->id), [
            'nip' => '12345',
            'name' => 'Updated User',
            'email' => 'updated@example.com',
            'job_position_id' => $job->id,
            'role' => 'direksi',
            'join_date' => now()->format('Y-m-d'),
        ]);

        $response->assertRedirect(route('user.index'));
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated User',
            'role' => 'direksi'
        ]);
    }


    /** @test */
    public function bisa_melihat_detail_user()
    {
        $job = JobPosition::create(['name' => 'Staff IT']);
        $user = User::create([
            'nip' => '12345',
            'name' => 'Detail User',
            'email' => 'detail@example.com',
            'password' => Hash::make('password'),
            'job_position_id' => $job->id,
            'role' => 'karyawan',
            'join_date' => now()->format('Y-m-d'),
        ]);

        $response = $this->get(route('user.show', $user->id));
        $response->assertStatus(200);
        $response->assertViewIs('pages.user.show');
        $response->assertViewHas('user');
    }

    /** @test */
    public function bisa_hapus_user()
    {
        $job = JobPosition::create(['name' => 'Staff IT']);
        $user = User::create([
            'nip' => '12345',
            'name' => 'Delete User',
            'email' => 'delete@example.com',
            'password' => Hash::make('password'),
            'job_position_id' => $job->id,
            'role' => 'karyawan',
            'join_date' => now()->format('Y-m-d'),
        ]);

        $response = $this->delete(route('user.destroy', $user->id));
        $response->assertRedirect(route('user.index'));
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
