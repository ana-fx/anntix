<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class VoidTransactionTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $event;
    protected $ticket;
    protected $transaction;

    protected function setUp(): void
    {
        parent::setUp();

        // Setup Admin
        $this->admin = User::factory()->create(['role' => 'admin', 'is_active' => true]);

        // Setup Event & Ticket
        $this->event = Event::factory()->create();
        $this->ticket = Ticket::factory()->create(['event_id' => $this->event->id, 'price' => 100000]);

        // Setup a Paid Transaction
        $this->transaction = Transaction::create([
            'code' => 'TRX-TEST-' . rand(1000, 9999),
            'event_id' => $this->event->id,
            'ticket_id' => $this->ticket->id,
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '081234567890',
            'city' => 'Jakarta',
            'nik' => '1234567890123456',
            'gender' => 'male',
            'quantity' => 2,
            'total_price' => 200000,
            'status' => 'paid',
        ]);
    }

    /** @test */
    public function test_admin_can_void_transaction()
    {
        $this->actingAs($this->admin);

        $response = $this->delete(route('admin.reports.transactions.destroy', ['transaction' => $this->transaction->id]), [
            'notes' => 'Mistake entry',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertSoftDeleted('transactions', [
            'id' => $this->transaction->id,
        ]);

        $this->assertDatabaseHas('transaction_logs', [
            'transaction_id' => $this->transaction->id,
            'action' => 'void_transaction',
            'new_status' => 'deleted',
            'notes' => 'Mistake entry',
        ]);
    }

    public function test_scanner_rejects_void_transaction()
    {
        // Set scanner for the event
        $scanner = User::factory()->create(['role' => 'scanner', 'is_active' => true]);
        $this->event->scanners()->attach($scanner->id);

        // Void the transaction first (Soft Delete)
        $this->transaction->delete();

        $this->actingAs($scanner);

        // 1. Verify Endpoint
        $response = $this->postJson(route('scanner.verify'), [
            'code' => $this->transaction->code,
            'event_id' => $this->event->id
        ]);

        $response->assertStatus(400)
            ->assertJson([
                'status' => 'error',
                'message' => 'TICKET VOID / HANGUS.'
            ]);
    }

    public function test_scanner_cannot_redeem_void_transaction()
    {
        // Set scanner
        $scanner = User::factory()->create(['role' => 'scanner', 'is_active' => true]);
        $this->event->scanners()->attach($scanner->id);

        // Void transaction
        $this->transaction->delete();

        $this->actingAs($scanner);

        // 2. Redeem Endpoint
        $response = $this->postJson(route('scanner.redeem'), [
            'transaction_id' => $this->transaction->id,
            'event_id' => $this->event->id
        ]);

        $response->assertStatus(404);

        // Ensure not redeemed
        $this->assertNull($this->transaction->fresh()->redeemed_at);
    }

    public function test_payment_page_blocks_void_transaction()
    {
        $this->transaction->delete();

        $response = $this->get(route('payment.show', $this->transaction->code));

        $response->assertStatus(404);
    }

    public function test_report_excludes_void_transactions()
    {
        // 1. Create a normal paid transaction
        Transaction::create([
            'code' => 'TRX-VALID',
            'event_id' => $this->event->id,
            'ticket_id' => $this->ticket->id,
            'name' => 'Valid User',
            'email' => 'valid@example.com',
            'phone' => '081234567891',
            'city' => 'Surabaya',
            'nik' => '9876543210987654',
            'gender' => 'female',
            'quantity' => 1,
            'total_price' => 100000,
            'status' => 'paid',
        ]);

        // 2. Void our main transaction ($200,000)
        $this->transaction->delete();

        $this->actingAs($this->admin);

        // Access Report Page
        // We can't easily parse the HTML for exact numbers without a lot of parsing logic, 
        // but we can check the Event Model calculation logic which the report uses.

        $event = $this->event->fresh();

        // Total Saldo should only include the VALID transaction (100,000)
        // The VOID transaction (200,000) should be ignored.
        // Assume 0 fees for simplicity of this test or calc fees

        // Let's rely on the Event::calculateSaldo() method we verified earlier
        // We need to ensure fees are 0 for easier math or set them explicitly
        $this->event->update([
            'organizer_fee_online_type' => 'fixed',
            'organizer_fee_online' => 0,
            'organizer_fee_reseller_type' => 'fixed',
            'organizer_fee_reseller' => 0,
        ]);

        $saldo = $event->calculateSaldo();

        // Should be 100,000 (only the valid one)
        // If void was included, it would be 300,000
        $this->assertEquals(100000, $saldo);
    }
}
