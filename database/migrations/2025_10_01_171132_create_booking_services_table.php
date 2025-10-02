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
        Schema::create('booking_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->foreignId('salon_sub_service_id')->constrained('salon_sub_service')->onDelete('cascade');
            $table->integer('quantity')->default(1); // إذا كانت الخدمة تدعم الكميات (مثل 2 جلسات)
            $table->text('notes')->nullable(); // ملاحظات خاصة بالخدمة
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_services');
    }
};
