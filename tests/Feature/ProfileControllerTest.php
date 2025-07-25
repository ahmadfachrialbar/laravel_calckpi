<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\JobPosition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $karyawan;
    protected $job;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(); // ✅ Nonaktifkan semua middleware

        // Buat role
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'karyawan', 'guard_name' => 'web']);

        // Buat job position
        $this->job = JobPosition::create(['name' => 'Manager']);

        // Buat admin
        $this->admin = User::create([
            'nip' => '123456',
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
            'job_position_id' => $this->job->id,
            'join_date' => now(),
        ]);
        $this->admin->assignRole('admin');

        // Buat karyawan
        $this->karyawan = User::create([
            'nip' => '654321',
            'name' => 'Karyawan Test',
            'email' => 'karyawan@test.com',
            'password' => Hash::make('password'),
            'job_position_id' => $this->job->id,
            'join_date' => now(),
        ]);
        $this->karyawan->assignRole('karyawan');
    }

    /** @test */
    public function admin_dapat_melihat_halaman_profile()
    {
        $this->actingAs($this->admin)
            ->get(route('profile.index'))
            ->assertStatus(200)
            ->assertSee('Admin Test')
            ->assertSee($this->admin->email);
    }

    /** @test */
    public function karyawan_dapat_melihat_halaman_profile()
    {
        $this->actingAs($this->karyawan)
            ->get(route('profile.index'))
            ->assertStatus(200)
            ->assertSee('Karyawan Test')
            ->assertSee($this->karyawan->email);
    }

    /** @test */
    public function admin_dapat_update_profile_tanpa_ganti_password_dan_foto()
    {
        $response = $this->actingAs($this->admin)
            ->put(route('profile.update'), [
                'nip' => '999999',
                'name' => 'Admin Update',
                'email' => 'adminupdate@test.com',
                'job_position_id' => $this->job->id,
                'join_date' => now()->format('Y-m-d'),
            ]);

        $response->assertRedirect(route('profile.index'));
        $this->assertDatabaseHas('users', [
            'id' => $this->admin->id,
            'name' => 'Admin Update',
            'email' => 'adminupdate@test.com',
        ]);
    }

    /** @test */
    public function karyawan_dapat_update_profile_dengan_ganti_password()
    {
        $response = $this->actingAs($this->karyawan)
            ->put(route('profile.update'), [
                'nip' => '777777',
                'name' => 'Karyawan Update',
                'email' => 'karyawanupdate@test.com',
                'job_position_id' => $this->job->id,
                'join_date' => now()->format('Y-m-d'),
                'password' => 'newpassword123'
            ]);

        $response->assertRedirect(route('profile.index'));
        $this->assertDatabaseHas('users', [
            'id' => $this->karyawan->id,
            'name' => 'Karyawan Update',
            'email' => 'karyawanupdate@test.com',
        ]);
        $this->assertTrue(Hash::check('newpassword123', $this->karyawan->fresh()->password));
    }

    /** @test */
    public function karyawan_dapat_menghapus_foto_profile()
    {
        // Update dengan hapus foto
        $response = $this->actingAs($this->karyawan)
            ->put(route('profile.update'), [
                'nip' => '654321',
                'name' => 'Karyawan Test',
                'email' => 'karyawan@test.com',
                'job_position_id' => $this->job->id,
                'join_date' => now()->format('Y-m-d'),
                'delete_photo' => 1
            ]);

        $response->assertRedirect(route('profile.index'));
        $this->assertDatabaseHas('users', [
            'id' => $this->karyawan->id,
            'photo' => null
        ]);
    }
}
