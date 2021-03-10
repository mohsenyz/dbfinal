<?php

use App\Models\Absence;
use App\Models\Employee;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absences', function (Blueprint $table) {
            $table->id();
            $table->timestamp('started_at');
            $table->timestamp('ended_at');
            $table->text('description')->nullable();
            $table->string('type')->default(Absence::TYPE_UNKNOWN);
            $table->timestamp('requested_at')->useCurrent();
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('rejected_at')->nullable();

            $table->foreignIdFor(Employee::class, 'requested_by')->references('id')->on('employees');
            $table->foreignIdFor(Employee::class, 'accepted_by')->nullable()->references('id')->on('employees');
            $table->foreignIdFor(Employee::class, 'rejected_by')->nullable()->references('id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('absences');
    }
}
