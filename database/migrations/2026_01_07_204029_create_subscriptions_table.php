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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('salon_id')
                  ->unique() // ضمان سجل واحد فقط لكل صالون (مهم جدًا للنظام الحالي)
                  ->constrained('salons')
                  ->onDelete('cascade'); // لو حذف الصالون، يحذف اشتراكه
            $table->foreignId('subscription_plan_id')
                  ->nullable() // مسموح null للـ trial أو الصالونات بدون خطة
                  ->constrained('subscription_plans')
                  ->onDelete('set null'); // لو حذف الخطة، يصير null (آمن)
            $table->date('start_date');
            $table->date('end_date')->nullable(); // nullable للـ indefinite أو trial بدون نهاية ثابتة
            $table->string('status', 20)->default('trial'); // trial, active, expired, suspended
            $table->string('payment_token')->nullable(); // لـ Moyasar token
            $table->date('trial_end_date')->nullable(); // إذا بدك تفصل trial_end عن end_date
            $table->timestamps();

            // Indexes للأداء والاستعلامات الشائعة
            $table->index('salon_id');
            $table->index('subscription_plan_id');
            $table->index('status');
            $table->index('end_date');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
