<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\KpiMetrics;
use App\Models\KpiRecord;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class HitungkpiControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $karyawan;
    protected $kpi;

    protected function setUp(): void
    {
        parent::setUp();

        // Buat role jika belum ada
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

        // Buat data KPI Metrics (langsung tanpa factory)
        $this->kpi = KpiMetrics::create([
            'nama_kpi' => 'KPI Test',
            'penjelasan_sederhana' => 'Deskripsi KPI Test',
            'kategori' => 'up', // atau 'down' / 'zero'
            'target' => 80,
            'bobot' => 70,
            'weightages' => 10,
        ]);
    }

    /** @test */
    public function karyawan_dapat_melihat_halaman_hitung_kpi()
    {
        $this->actingAs($this->karyawan)
            ->get(route('hitungkpi.index'))
            ->assertStatus(200)
            ->assertSee('Hitung KPI');
    }

    /** @test */
    public function karyawan_dapat_menyimpan_data_kpi()
    {
        $response = $this->actingAs($this->karyawan)
            ->post(route('hitungkpi.store'), [
                'kpi' => [
                    [
                        'metric_id' => $this->kpi->id,
                        'simulasi_penambahan' => 5,
                    ],
                ],
            ]);

        $response->assertRedirect(); // harus redirect ke halaman setelah simpan

        $this->assertDatabaseHas('kpi_records', [
            'user_id' => $this->karyawan->id,
            'kpimetrics_id' => $this->kpi->id,
        ]);
    }

    /** @test */
    public function karyawan_dapat_melihat_laporan_sendiri()
    {
        // buat record dummy untuk karyawan
        KpiRecord::create([
            'user_id' => $this->karyawan->id,
            'kpimetrics_id' => $this->kpi->id,
            'achievement' => 90,
            'score' => 9,
        ]);

        $this->actingAs($this->karyawan)
            ->get(route('laporan.index'))
            ->assertStatus(200)
            ->assertSee('Laporan');
    }

    /** @test */
    public function karyawan_dapat_mengunduh_laporan()
    {
        $this->actingAs($this->karyawan)
            ->get(route('laporan.download'))
            ->assertStatus(200);
    }

    /** @test */
    public function admin_dapat_melihat_laporan_semua_karyawan()
    {
        $this->actingAs($this->admin)
            ->get(route('laporan.admin'))
            ->assertStatus(200)
            ->assertSee('Laporan');
    }

    /** @test */
    public function admin_dapat_mengunduh_laporan_admin()
    {
        $this->actingAs($this->admin)
            ->get(route('laporan.admin.download'))
            ->assertStatus(200);
    }

    /** @test */
    public function admin_dapat_melihat_detail_laporan_per_karyawan()
    {
        // buat record dummy
        $record = KpiRecord::create([
            'user_id' => $this->karyawan->id,
            'kpimetrics_id' => $this->kpi->id,
            'achievement' => 90,
            'score' => 9,
        ]);

        $this->actingAs($this->admin)
            ->get(route('laporan.admin.show', $this->karyawan->id))
            ->assertStatus(200)
            ->assertSee($this->karyawan->name);
    }
}
