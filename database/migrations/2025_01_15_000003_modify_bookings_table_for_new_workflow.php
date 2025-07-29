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
        Schema::table('bookings', function (Blueprint $table) {
            // Add new status values for the workflow
            $table->enum('status', ['pending', 'salon_confirmed', 'user_confirmed', 'rejected', 'cancelled','completed'])->default('pending')->change();

            // Add fields for salon response
            $table->datetime('salon_confirmed_datetime')->nullable()->comment('When salon confirmed/modified the booking');
            $table->datetime('user_confirmed_datetime')->nullable()->comment('When user confirmed the salon response');
            $table->datetime('salon_proposed_datetime')->nullable()->comment('Salon proposed date/time (if different from user preferred)');
            $table->decimal('salon_proposed_price', 10, 2)->nullable()->comment('Salon proposed price');
            $table->integer('salon_proposed_duration')->nullable()->comment('Salon proposed duration in minutes');
            $table->text('salon_notes')->nullable()->comment('Salon notes or modifications');
            $table->text('salon_modification_reason')->nullable()->comment('Reason for modification if salon changed the booking');

            // Remove fields that are no longer needed in booking (moved to appointment)
            $table->dropColumn(['special_requirements']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Revert status enum
            $table->enum('status', ['pending', 'confirmed', 'rejected', 'cancelled'])->default('pending')->change();

            // Remove new fields
            $table->dropColumn([
                'salon_confirmed_datetime',
                'user_confirmed_datetime',
                'salon_proposed_datetime',
                'salon_proposed_price',
                'salon_proposed_duration',
                'salon_notes',
                'salon_modification_reason'
            ]);

            // Add back removed fields
            $table->text('special_requirements')->nullable()->comment('Any special requirements or notes');
        });
    }
};