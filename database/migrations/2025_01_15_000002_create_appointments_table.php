<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->string('appointment_number')->unique()->comment('Unique appointment reference number');
            $table->datetime('scheduled_datetime')->comment('Confirmed appointment date and time');
            $table->integer('duration_minutes')->comment('Duration of the appointment in minutes');
            $table->decimal('total_price', 10, 2)->comment('Total price for the appointment');
            $table->decimal('deposit_amount', 10, 2)->default(0)->comment('Deposit amount required');
            $table->decimal('deposit_paid', 10, 2)->default(0)->comment('Amount of deposit actually paid');
            $table->enum('payment_status', ['pending', 'partial', 'paid', 'refunded'])->default('pending');
            $table->enum('status', ['scheduled', 'in_progress', 'completed', 'cancelled', 'no_show'])->default('scheduled');
            $table->text('notes')->nullable()->comment('Additional notes from salon');
            $table->text('cancellation_reason')->nullable()->comment('Reason if appointment is cancelled');
            $table->datetime('cancelled_at')->nullable()->comment('When the appointment was cancelled');
            $table->json('payment_details')->nullable()->comment('Payment transaction details');
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['booking_id']);
            $table->index(['scheduled_datetime']);
            $table->index(['status', 'scheduled_datetime']);
            $table->index(['payment_status']);
            $table->index('appointment_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
}; 