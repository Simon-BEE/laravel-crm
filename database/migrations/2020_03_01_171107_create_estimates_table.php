<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstimatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimates', function (Blueprint $table) {
            $table->id();
            $table->string('estimate_id')->unique();
            $table->foreignId('admin_id')->constrained('users');
            $table->foreignId('customer_id')->constrained('users');
            $table->foreignId('project_id')->constrained();
            $table->foreignId('status_id')->constrained();
            $table->longText('items');
            $table->string('file')->nullable();
            $table->integer('amount');
            $table->dateTime('issue_date');
            $table->dateTime('limit_date');
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
        Schema::dropIfExists('estimates');
    }
}
