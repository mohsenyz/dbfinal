<?php

use App\Models\Employee;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayChecksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_checks', function (Blueprint $table) {
            $table->id();
            $table->integer('gross_profit');
            $table->integer('net_profit');
            $table->integer('tax_amount');
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->timestamps();

            $table->foreignIdFor(Employee::class)->references('id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pay_checks');
    }
}
