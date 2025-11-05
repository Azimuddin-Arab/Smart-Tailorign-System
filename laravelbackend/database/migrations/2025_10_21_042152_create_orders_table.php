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
        Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
        $table->date('order_date')->default(DB::raw('CURRENT_DATE'));
        $table->date('due_date')->nullable();
        $table->string('status')->default('Pending');
        $table->decimal('total_price', 10, 2)->nullable();
        $table->decimal('advance_paid', 10, 2)->default(0);
        $table->text('notes')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
