<?php

use App\Models\Employee;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssistancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assistances', function (Blueprint $table) {
            $table->id();
            $table->integer('amount');
            $table->timestamp('paid_at');
            $table->timestamp('requested_at');
            $table->timestamp('accepted_at');
            $table->timestamp('rejected_at');

            $table->foreignIdFor(Employee::class, 'requested_by');
            $table->foreignIdFor(Employee::class, 'accepted_by');
            $table->foreignIdFor(Employee::class, 'rejected_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assistances');
    }
}
