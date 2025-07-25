<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\KpiMetrics;
use App\Models\KpiRecord;
use App\Models\JobPosition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class KpiRecordControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $jobPosition;

    protected function setUp(): void
    {
        parent::setUp();

        // ✅ Abaikan semua middleware (role, policy, dsb)
        $this->withoutMiddleware();

        // ✅ Buat job position untuk relasi user & KPI
        $this->jobPosition = JobPosition::create([
            'name' => 'Staff IT'
        ]);

        // ✅ Auto-login dummy user agar auth()->user() di view tidak null
        $this->actingAs(User::create([
            'nip'              => '77777',
            'name'             => 'Dummy User',
            'email'            => 'dummy@example.com',
            'password'         => Hash::make('password'),
            'role'             => 'admin', // tidak berpengaruh karena middleware dilewati
            'join_date'        => now()->format('Y-m-d'),
            'job_position_id'  => $this->jobPosition->id
        ]));
    }

    /** @test */
    public function admin_dapat_melihat_riwayat_kpi()
    {
        $user = User::create([
            'nip'        => '88888',
            'name'       => 'Karyawan',
            'email'      => 'karyawan@example.com',
            'password'   => Hash::make('password'),
            'role'       => 'karyawan',
            'join_date'  => now()->format('Y-m-d'),
            'job_position_id' => $this->jobPosition->id
        ]);

        $kpi = KpiMetrics::create([
            'nama_kpi' => 'Disiplin Waktu',
            'penjelasan_sederhana' => 'Disiplin masuk kantor',
            'cara_ukur' => 'Cek log absensi',
            'target' => 85,
            'bobot' => 10,
            'weightages' => 4,
            'kategori' => 'up',
            'job_position_id' => $this->jobPosition->id
        ]);

        KpiRecord::create([
            'user_id'             => $user->id,
            'kpimetrics_id'       => $kpi->id,
            'simulasi_penambahan' => 0,
            'achievement'         => 90,
            'weightages'          => 4,
            'score'               => 90
        ]);

        $response = $this->get(route('kpirecords.index'));
        $response->assertStatus(200);
        $response->assertSee('Disiplin Waktu');
        $response->assertSee('90');
    }

    /** @test */
    public function admin_dapat_menghapus_riwayat_kpi()
    {
        $user = User::create([
            'nip'        => '88888',
            'name'       => 'Karyawan',
            'email'      => 'karyawan2@example.com',
            'password'   => Hash::make('password'),
            'role'       => 'karyawan',
            'join_date'  => now()->format('Y-m-d'),
            'job_position_id' => $this->jobPosition->id
        ]);

        $kpi = KpiMetrics::create([
            'nama_kpi' => 'Produktivitas',
            'penjelasan_sederhana' => 'Target kerja tercapai',
            'cara_ukur' => 'Cek laporan bulanan',
            'target' => 95,
            'bobot' => 15,
            'weightages' => 5,
            'kategori' => 'up',
            'job_position_id' => $this->jobPosition->id
        ]);

        $record = KpiRecord::create([
            'user_id'             => $user->id,
            'kpimetrics_id'       => $kpi->id,
            'simulasi_penambahan' => 2,
            'achievement'         => 92,
            'weightages'          => 5,
            'score'               => 90
        ]);

        $response = $this->delete(route('kpirecords.destroy', $record->id));
        $response->assertRedirect(route('kpirecords.index'));
        $this->assertDatabaseMissing('kpi_records', ['id' => $record->id]);
    }

    
}
