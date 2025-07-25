<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChatbotControllerTest extends TestCase
{
    use RefreshDatabase; // ✅ Supaya DB di-reset tiap test

    protected $admin, $karyawan, $direksi;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();

        // Buat Role
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'karyawan', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'direksi', 'guard_name' => 'web']);

        // Buat Admin
        $this->admin = User::create([
            'nip' => '111111',
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);
        $this->admin->assignRole('admin');

        // Buat Karyawan
        $this->karyawan = User::create([
            'nip' => '222222',
            'name' => 'Karyawan Test',
            'email' => 'karyawan@test.com',
            'password' => Hash::make('password'),
            'role' => 'karyawan'
        ]);
        $this->karyawan->assignRole('karyawan');

        // Buat Direksi
        $this->direksi = User::create([
            'nip' => '333333',
            'name' => 'Direksi Test',
            'email' => 'direksi@test.com',
            'password' => Hash::make('password'),
            'role' => 'direksi'
        ]);
        $this->direksi->assignRole('direksi');

        // Mock API Gemini agar tidak benar-benar memanggil API eksternal
        Http::fake([
            '*' => Http::response([
                'candidates' => [
                    [
                        'content' => [
                            'parts' => [
                                ['text' => 'Halo, saya adalah asisten panduan untuk website ini.']
                            ]
                        ]
                    ]
                ]
            ], 200)
        ]);
    }

    /** @test */
    public function admin_dapat_menggunakan_chatbot()
    {
        $response = $this->actingAs($this->admin)
            ->postJson(route('chatbot.send'), [
                'message' => 'Apa itu KPI?'
            ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'answer' => 'Halo, saya adalah asisten panduan untuk website ini.'
                 ]);
    }

    /** @test */
    public function karyawan_dapat_menggunakan_chatbot()
    {
        $response = $this->actingAs($this->karyawan)
            ->postJson(route('chatbot.send'), [
                'message' => 'Bagaimana cara menghitung KPI saya?'
            ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'answer' => 'Halo, saya adalah asisten panduan untuk website ini.'
                 ]);
    }

    /** @test */
    public function direksi_dapat_menggunakan_chatbot()
    {
        $response = $this->actingAs($this->direksi)
            ->postJson(route('chatbot.send'), [
                'message' => 'Apa saya bisa melihat laporan KPI karyawan?'
            ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'answer' => 'Halo, saya adalah asisten panduan untuk website ini.'
                 ]);
    }
}
