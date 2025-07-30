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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('salon_id')->constrained('salons')->onDelete('cascade');
            $table->foreignId('salon_sub_service_id')->constrained('salon_sub_service')->onDelete('cascade');
            $table->string('booking_number')->unique()->comment('Unique booking reference number');
            $table->text('service_description')->comment('Detailed description of the service requested');
            $table->datetime('preferred_datetime')->comment('User preferred appointment time');
            $table->enum('status', ['pending', 'confirmed', 'rejected', 'cancelled'])->default('pending');
            $table->text('rejection_reason')->nullable()->comment('Reason if booking is rejected');
            $table->text('special_requirements')->nullable()->comment('Any special requirements or notes');
            $table->json('additional_data')->nullable()->comment('Additional booking data');
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['user_id', 'status']);
            $table->index(['salon_id', 'status']);
            $table->index(['preferred_datetime']);
            $table->index('booking_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
}; 