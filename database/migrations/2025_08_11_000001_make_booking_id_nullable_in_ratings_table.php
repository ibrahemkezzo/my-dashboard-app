<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ratings', function (Blueprint $table) {
            // Make booking_id nullable (requires doctrine/dbal installed)
            $table->foreignId('booking_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('ratings', function (Blueprint $table) {
            $table->foreignId('booking_id')->nullable(false)->change();
        });
    }
};
