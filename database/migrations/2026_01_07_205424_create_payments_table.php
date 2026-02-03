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
        Schema::create('payments', function (Blueprint $table) {
$table->id();
            $table->foreignId('subscription_id')
                  ->constrained('subscriptions')
                  ->onDelete('cascade'); // حذف الدفعات إذا حذف الاشتراك
            $table->string('payment_id')->unique(); // معرف الدفع من البوابة أو manual_...
            $table->decimal('amount', 12, 2); // 12,2 أفضل للمبالغ الكبيرة + دعم فواصل
            $table->string('currency', 3)->default('SAR'); // عملة افتراضية SAR
            $table->string('status')->default('pending'); // pending, paid, failed, refunded
            $table->string('method')->nullable(); // cash, card, online, manual
            $table->text('note')->nullable(); // ملاحظات (مثل سبب الفشل أو تفاصيل كاش)
            $table->timestamp('paid_at')->nullable(); // تاريخ الدفع الناجح
            $table->json('gateway_response')->nullable(); // تخزين response كامل من Moyasar للـ debug
            $table->timestamps();

            // Indexes للأداء
            $table->index('subscription_id');
            $table->index('status');
            $table->index('paid_at');
            $table->index('payment_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
