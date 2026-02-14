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

            // الربط بالصالون والاشتراك
            $table->foreignId('salon_id')->constrained('salons')->cascadeOnDelete();
            $table->foreignId('subscription_id')->constrained('subscriptions')->cascadeOnDelete();

            // المراجع (References)
            $table->string('payment_reference')->unique()->comment('Our internal unique reference');
            $table->string('gateway_transaction_id')->nullable()->index()->comment('External ID from Moyasar/Payment Gateway');

            // تفاصيل المبلغ والعملة
            $table->decimal('amount', 12, 2);
            $table->string('currency', 3)->default('SAR');

            // الحالة والبوابة المستخدمة
            $table->string('status')->default('pending')->index(); // pending, completed, failed, refunded
            $table->string('gateway')->default('moyasar'); // moyasar, manual, tap, etc.
            $table->string('method')->nullable(); // visa, mada, applepay, cash

            // اللوغات والردود التقنية
            $table->json('gateway_response')->nullable(); // Full JSON response for debugging
            $table->text('failure_reason')->nullable(); // In case of rejection
            $table->text('note')->nullable(); // Internal notes

            // التواريخ
            $table->timestamp('paid_at')->nullable()->index(); // When it was actually paid
            $table->timestamp('processed_at')->nullable(); // Technical process completion time
            $table->timestamps();
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
