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
            $table->string('google_place_id')->nullable()->after('seo_meta');
            $table->string('timezone')->nullable()->after('google_place_id');
            $table->decimal('latitude', 10, 8)->nullable()->after('timezone');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
            $table->json('features')->nullable()->nullable()->after('longitude');
            $table->enum('type',['home_salon','beauty_center'])->after('features');
            $table->boolean('verification')->default(false)->after('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('salons', function (Blueprint $table) {
            $table->dropColumn([
                'google_place_id',
                'timezone',
                'latitude',
                'longitude',
                'features',
                'type',
                'verification',
            ]);
        });
    }
};
