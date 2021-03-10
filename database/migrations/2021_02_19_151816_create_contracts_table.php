<?php

use App\Models\Employee;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->text('description')->nullable();
            $table->timestamp('starts_at')->useCurrent();
            $table->timestamp('ends_at');
            $table->string('pay_check_period');
            $table->integer('required_working_hours');
            $table->integer('allowed_absence_hours');

            $table->foreignIdFor(Employee::class)->references('id')->on('employees');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contracts');
    }
}
