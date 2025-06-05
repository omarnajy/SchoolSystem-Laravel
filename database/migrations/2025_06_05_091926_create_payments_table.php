<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('parent_id');
            $table->unsignedBigInteger('student_id');
            $table->decimal('amount', 10, 2);
            $table->date('due_date');
            $table->date('payment_date')->nullable();
            $table->enum('status', ['pending', 'paid', 'overdue', 'partial'])->default('pending');
            $table->enum('payment_method', ['cash', 'card', 'transfer', 'check', 'online'])->nullable();
            $table->string('description');
            $table->enum('payment_type', ['tuition', 'transport', 'lunch', 'books', 'uniform', 'activities', 'other']);
            $table->string('academic_year');
            $table->string('month');
            $table->text('notes')->nullable();
            $table->string('reference_number')->nullable();
            $table->decimal('discount', 8, 2)->default(0);
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('parents')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            
            $table->index(['parent_id', 'student_id']);
            $table->index('status');
            $table->index('payment_type');
            $table->index('academic_year');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}