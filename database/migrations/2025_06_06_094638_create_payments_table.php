<?php

// 1. MIGRATION - create_payments_table.php
// php artisan make:migration create_payments_table

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id');
            $table->unsignedBigInteger('student_id')->nullable();
            $table->string('invoice_number')->unique();
            $table->string('payment_type'); // scolarité, inscription, cantine, transport, etc.
            $table->decimal('amount', 10, 2);
            $table->string('academic_year'); // 2024-2025
            $table->string('period')->nullable(); // trimestre1, trimestre2, trimestre3, mensuel, etc.
            $table->enum('status', ['pending', 'paid', 'overdue', 'cancelled'])->default('pending');
            $table->date('due_date');
            $table->date('paid_date')->nullable();
            $table->string('payment_method')->nullable(); // espèces, chèque, virement, carte
            $table->string('transaction_reference')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by'); // admin qui a créé
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('parents')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            
            $table->index(['parent_id', 'status']);
            $table->index(['academic_year', 'status']);
            $table->index('due_date');
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}