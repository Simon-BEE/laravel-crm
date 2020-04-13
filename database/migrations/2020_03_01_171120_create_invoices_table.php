<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id')->unique();
            $table->foreignId('admin_id')->constrained('users');
            $table->foreignId('customer_id')->constrained('users');
            $table->foreignId('project_id')->constrained();
            $table->foreignId('status_id')->constrained();
            $table->longText('items');
            $table->string('file')->nullable();
            $table->integer('amount');
            $table->dateTime('issue_date');
            $table->dateTime('due_date');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
