<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\JobPosition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class JobPositionControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $karyawan;
    protected $job;

    protected function setUp(): void
    {
        parent::setUp();

        // Buat role
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'karyawan', 'guard_name' => 'web']);

        // Buat admin
        $this->admin = User::create([
            'nip' => '123456',
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
        ]);
        $this->admin->assignRole('admin');

        // Buat karyawan
        $this->karyawan = User::create([
            'nip' => '654321',
            'name' => 'Karyawan Test',
            'email' => 'karyawan@test.com',
            'password' => Hash::make('password'),
        ]);
        $this->karyawan->assignRole('karyawan');

        // Buat satu data job position
        $this->job = JobPosition::create([
            'name' => 'Manager'
        ]);
    }

    /** @test */
    public function admin_dapat_melihat_index_job_position()
    {
        $this->actingAs($this->admin) // <- login sebagai admin
            ->get(route('jobpositions.index'))
            ->assertStatus(200)
            ->assertSee('Manager');
    }

    /** @test */
    public function admin_dapat_menambahkan_job_position()
    {
        $this->actingAs($this->admin);
        $response = $this->post(route('jobpositions.store'), [
            'name' => 'Supervisor'
        ]);

        $response->assertRedirect(route('jobpositions.index'));
        $this->assertDatabaseHas('job_positions', [
            'name' => 'Supervisor'
        ]);
    }

    /** @test */
    public function admin_dapat_mengedit_job_position()
    {
        $this->actingAs($this->admin);
        $response = $this->put(route('jobpositions.update', $this->job->id), [
            'name' => 'Manager Senior'
        ]);

        $response->assertRedirect(route('jobpositions.index'));
        $this->assertDatabaseHas('job_positions', [
            'id' => $this->job->id,
            'name' => 'Manager Senior'
        ]);
    }

    /** @test */
    public function admin_dapat_menghapus_job_position()
    {
        $this->actingAs($this->admin);
        $response = $this->delete(route('jobpositions.destroy', $this->job->id));

        $response->assertRedirect(route('jobpositions.index'));
        $this->assertDatabaseMissing('job_positions', [
            'id' => $this->job->id
        ]);
    }

    /** @test */
    public function selain_admin_tidak_bisa_menambahkan_job_position()
    {
        $this->actingAs($this->karyawan);
        $response = $this->post(route('jobpositions.store'), [
            'name' => 'Staff'
        ]);

        $response->assertStatus(403); // akses ditolak
        $this->assertDatabaseMissing('job_positions', [
            'name' => 'Staff'
        ]);
    }
}
