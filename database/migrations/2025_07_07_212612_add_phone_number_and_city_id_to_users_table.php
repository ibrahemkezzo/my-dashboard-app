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
            $table->string('first_name')->nullable()->after('name');
            $table->string('last_name')->nullable()->after('first_name');
            $table->string('username')->unique()->nullable()->after('last_name');
            $table->string('phone_number', 15)->nullable()->after('email');
            $table->enum('type', ['admin', 'user', 'salon_owner'])->default('user')->after('phone_number');
            $table->enum('status', ['certified', 'not_certified', 'pending'])->default('not_certified')->after('type');
            $table->enum('gender', ['male', 'female', 'other'])->nullable()->after('status');
            $table->json('social_media_links')->nullable()->after('gender');
            $table->foreignId('city_id')->nullable()->constrained('cities')->onDelete('set null')->after('social_media_links');
            // $table->foreignId('payment_method_id')->nullable()->constrained('payment_methods')->onDelete('set null')->after('city_id');
            // $table->foreignId('subscription_plan_id')->nullable()->constrained('subscription_plans')->onDelete('set null')->after('payment_method_id');
            // $table->timestamp('last_login_at')->nullable()->after('payment_method_id');
            $table->index('phone_number');
            $table->index('username');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['city_id']); // حذف المفتاح الخارجي
            $table->dropColumn(['phone_number', 'city_id']);
        });
    }
};
