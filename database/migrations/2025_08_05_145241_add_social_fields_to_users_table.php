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
        Schema::table('users', function (Blueprint $table) {
            $table->string('google_id')->nullable()->unique();
            $table->string('google_token')->nullable(); // رمز الوصول (Access Token)
            $table->string('google_refresh_token')->nullable(); // رمز التجديد (إذا كان متاحًا)
            $table->timestamp('google_token_expires_at')->nullable(); // تاريخ انتهاء صلاحية التوكن
            $table->string('avatar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'google_id',
                'google_token',
                'google_refresh_token',
                'google_token_expires_at',
                'avatar'
            ]);
        });
    }
};
