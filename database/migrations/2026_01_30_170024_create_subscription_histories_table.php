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
        Schema::create('subscription_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subscription_id');
            $table->unsignedBigInteger('subscription_plan_id')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->decimal('paid_amount', 10, 2);
            $table->string('payment_method')->default('online');
            $table->text('note')->nullable();
            $table->timestamps();

            // Foreign keys مع explicit types
            $table->foreign('subscription_id')
                  ->references('id')
                  ->on('subscriptions')
                  ->onDelete('cascade');

            $table->foreign('subscription_plan_id')
                  ->references('id')
                  ->on('subscription_plans')
                  ->onDelete('set null');

            // Indexes
            $table->index('subscription_id');
            $table->index('subscription_plan_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_histories');
    }
};
