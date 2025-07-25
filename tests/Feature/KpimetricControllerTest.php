<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\JobPosition;
use App\Models\Kpimetrics;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class KpimetricControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $karyawan;
    protected $jobPosition;

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
            'role' => 'admin'
        ]);
        $this->admin->assignRole('admin');

        // Buat karyawan
        $this->karyawan = User::create([
            'nip' => '654321',
            'name' => 'Karyawan Test',
            'email' => 'karyawan@test.com',
            'password' => Hash::make('password'),
            'role' => 'karyawan'
        ]);
        $this->karyawan->assignRole('karyawan');

        // Buat job position
        $this->jobPosition = JobPosition::create(['name' => 'Staff IT']);
    }

    /** @test */
    public function admin_bisa_melihat_halaman_index_kpi()
    {
        $this->actingAs($this->admin);
        $response = $this->get('/kpimetrics');
        $response->assertStatus(200);
        $response->assertViewIs('pages.kpimetrics.index');
    }

    /** @test */
    public function admin_bisa_melihat_form_tambah_kpi()
    {
        $this->actingAs($this->admin);
        $response = $this->get('/kpimetrics/create');
        $response->assertStatus(200);
        $response->assertViewIs('pages.kpimetrics.create');
    }

    /** @test */
    public function admin_bisa_menambahkan_kpi_baru()
    {
        $this->actingAs($this->admin);

        $response = $this->post('/kpimetrics/store', [
            'nama_kpi' => 'Kehadiran Tepat Waktu',
            'penjelasan_sederhana' => 'Hadir tepat waktu setiap hari',
            'cara_ukur' => 'Menghitung absensi',
            'target' => 90,
            'bobot' => 10,
            'weightages' => 5,
            'kategori' => 'up',
            'job_position_id' => $this->jobPosition->id
        ]);

        $response->assertRedirect(route('kpimetrics.index'));
        $this->assertDatabaseHas('kpimetrics', [
            'nama_kpi' => 'Kehadiran Tepat Waktu'
        ]);
    }

    /** @test */
    public function admin_bisa_melihat_form_edit_kpi()
    {
        $this->actingAs($this->admin);

        $kpi = Kpimetrics::create([
            'nama_kpi' => 'Disiplin Waktu',
            'penjelasan_sederhana' => 'Disiplin masuk kantor',
            'cara_ukur' => 'Cek log absensi',
            'target' => 85,
            'bobot' => 10,
            'weightages' => 4,
            'kategori' => 'up',
            'job_position_id' => $this->jobPosition->id
        ]);

        $response = $this->get("/kpimetrics/edit/{$kpi->id}");
        $response->assertStatus(200);
        $response->assertViewIs('pages.kpimetrics.edit');
    }

    /** @test */
    public function admin_bisa_update_data_kpi()
    {
        $this->actingAs($this->admin);

        $kpi = Kpimetrics::create([
            'nama_kpi' => 'Disiplin Waktu',
            'penjelasan_sederhana' => 'Disiplin masuk kantor',
            'cara_ukur' => 'Cek log absensi',
            'target' => 85,
            'bobot' => 10,
            'weightages' => 4,
            'kategori' => 'up',
            'job_position_id' => $this->jobPosition->id
        ]);

        $response = $this->put("/kpimetrics/update/{$kpi->id}", [
            'nama_kpi' => 'Produktivitas Kerja',
            'penjelasan_sederhana' => 'Update target kerja',
            'cara_ukur' => 'Hitung output kerja',
            'target' => 95,
            'bobot' => 15,
            'weightages' => 6,
            'kategori' => 'up'
        ]);

        $response->assertRedirect(route('kpimetrics.index'));
        $this->assertDatabaseHas('kpimetrics', [
            'nama_kpi' => 'Produktivitas Kerja'
        ]);
    }

    /** @test */
    public function admin_bisa_menghapus_data_kpi()
    {
        $this->actingAs($this->admin);

        $kpi = Kpimetrics::create([
            'nama_kpi' => 'Kebersihan Meja',
            'penjelasan_sederhana' => 'Meja kerja bersih setiap hari',
            'cara_ukur' => 'Cek visual harian',
            'target' => 100,
            'bobot' => 5,
            'weightages' => 2,
            'kategori' => 'up',
            'job_position_id' => $this->jobPosition->id
        ]);

        $response = $this->delete("/kpimetrics/delete/{$kpi->id}");
        $response->assertRedirect(route('kpimetrics.index'));
        $this->assertDatabaseMissing('kpimetrics', ['id' => $kpi->id]);
    }
    /** @test */
    public function karyawan_bisa_melihat_halaman_index_kpi_saja()
    {
        // Pastikan karyawan sudah punya job position
        $this->karyawan->job_position_id = $this->jobPosition->id;
        $this->karyawan->save();

        // Buat KPI untuk jabatan yang sama
        Kpimetrics::create([
            'nama_kpi' => 'Kualitas Laporan',
            'penjelasan_sederhana' => 'Laporan harus rapi dan lengkap',
            'cara_ukur' => 'Cek laporan bulanan',
            'target' => 90,
            'bobot' => 8,
            'weightages' => 4,
            'kategori' => 'up',
            'job_position_id' => $this->jobPosition->id
        ]);

        $this->actingAs($this->karyawan);
        $response = $this->get('/kpimetrics');
        $response->assertStatus(200);
        $response->assertViewIs('pages.kpimetrics.index');
        $response->assertSee('Kualitas Laporan');
    }
}
