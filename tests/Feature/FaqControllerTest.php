<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Faq;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class FaqControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $karyawan;
    protected $faq;

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

        // Buat 1 data faq
        $this->faq = Faq::create([
            'judul' => 'Panduan Sistem',
            'isi' => 'Berikut adalah panduan lengkap penggunaan sistem.'
        ]);
    }

    /** @test */
    public function admin_karyawan_direksi_dapat_melihat_index_faq()
    {
        $this->actingAs($this->admin)
            ->get(route('faq.index'))
            ->assertStatus(200)
            ->assertSee('Panduan Sistem')
            ->assertSee('Berikut adalah panduan lengkap penggunaan sistem.');
    }

    /** @test */
    public function admin_dapat_menambahkan_faq()
    {
        $response = $this->actingAs($this->admin)
            ->post(route('faq.store'), [
                'judul' => 'Panduan Baru',
                'isi' => 'Ini adalah panduan baru untuk sistem.'
            ]);

        $response->assertRedirect(route('faq.index'));
        $this->assertDatabaseHas('faqs', [
            'judul' => 'Panduan Baru',
            'isi' => 'Ini adalah panduan baru untuk sistem.'
        ]);
    }

    /** @test */
    public function admin_dapat_mengedit_faq()
    {
        $response = $this->actingAs($this->admin)
            ->put(route('faq.update', $this->faq->id), [
                'judul' => 'Panduan Sistem Update',
                'isi' => 'Panduan ini telah diperbarui.'
            ]);

        $response->assertRedirect(route('faq.index'));
        $this->assertDatabaseHas('faqs', [
            'id' => $this->faq->id,
            'judul' => 'Panduan Sistem Update',
            'isi' => 'Panduan ini telah diperbarui.'
        ]);
    }

    /** @test */
    public function admin_dapat_menghapus_faq()
    {
        $response = $this->actingAs($this->admin)
            ->delete(route('faq.destroy', $this->faq->id));

        $response->assertRedirect(route('faq.index'));
        $this->assertDatabaseMissing('faqs', [
            'id' => $this->faq->id
        ]);
    }
}
