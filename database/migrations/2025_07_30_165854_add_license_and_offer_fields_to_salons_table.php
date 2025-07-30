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
        Schema::table('salons', function (Blueprint $table) {
            $table->string('license_document')->nullable()->after('logo');
            $table->date('license_start_date')->nullable()->after('type');
            $table->date('license_end_date')->nullable()->after('license_start_date');
            $table->boolean('hasOffer')->default(false)->after('license_end_date');
            $table->json('offer')->nullable()->after('hasOffer');
            $table->boolean('is_promoted')->default(false)->after('offer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('salons', function (Blueprint $table) {
            $table->dropColumn(['license_document','license_start_date', 'license_end_date', 'hasOffer', 'offer','is_promoted']);
        });
    }
};
