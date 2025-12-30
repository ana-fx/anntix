<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $event = Event::updateOrCreate(
            ['slug' => 'gelombang-cinta-fest-pekalongan-4'],
            [
                'name' => 'GELOMBANG CINTA FEST PEKALONGAN #4',
                'category' => 'Music Festival',
                'status' => 'active',
                'start_date' => Carbon::parse('2026-03-27 16:00:00'),
                'end_date' => Carbon::parse('2026-03-27 23:59:00'),
                'description' => '<h3>Nikmati Malam Penuh Energi!</h3><p><b>GELOMBANG CINTA FEST PEKALONGAN #4</b> kembali hadir dengan kemeriahan yang lebih besar! Kali ini, panggung akan diguncang oleh penampilan spesial dari:</p><ul><li><b>DENNY CAKNAN</b></li><li>Dan bintang tamu kejutan lainnya!</li></ul><p>Jangan lewatkan kesempatan untuk bernyanyi bersama di malam penuh cinta dan musik Ambyar terbaik di Pekalongan.</p>',
                'terms' => '<h4>Syarat & Ketentuan:</h4><ol><li>Tiket yang sudah dibeli <u>tidak dapat ditukar atau dikembalikan</u> dengan alasan apapun.</li><li>Pengunjung wajib menunjukkan <b>KTP/Identitas resmi</b> saat penukaran tiket.</li><li>Dilarang membawa senjata tajam, narkoba, dan minuman keras ke area festival.</li><li>Penyelenggara berhak mengeluarkan pengunjung yang melanggar aturan tanpa kompensasi.</li></ol>',
                'location' => 'Pekalongan',
                'province' => 'Jawa Tengah',
                'city' => 'Pekalongan',
                'zip' => '51111',
                'google_map_embed' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.025400123456!2d109.67!3d-6.89!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwNTMnMjQuMCJTIDEwO0DCs0MCcxMi4wIkU!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
                'organizer_name' => 'AL Organizer',
                'banner_path' => 'event.jpeg',
                'thumbnail_path' => 'event.jpeg',
            ]
        );

        // Create ticket types
        Ticket::updateOrCreate(
            ['event_id' => $event->id, 'name' => 'FESTIVAL'],
            [
                'price' => 150000,
                'quota' => 1000,
                'start_date' => now(),
                'end_date' => Carbon::parse('2026-03-27 12:00:00'),
                'description' => 'Tiket Festival Stand Up',
                'max_purchase_per_user' => 5,
            ]
        );

        Ticket::updateOrCreate(
            ['event_id' => $event->id, 'name' => 'VIP'],
            [
                'price' => 350000,
                'quota' => 200,
                'start_date' => now(),
                'end_date' => Carbon::parse('2026-03-27 12:00:00'),
                'description' => 'Tiket VIP dengan akses eksklusif',
                'max_purchase_per_user' => 2,
            ]
        );
    }
}
