<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \App\Models\Leave\LeaveApplication;

class CreateHrLeaveApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_leave_applications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('leave_type', [
                LeaveApplication::TYPE_SICK,
                LeaveApplication::TYPE_CASUAL,
                LeaveApplication::TYPE_EARNED,
                LeaveApplication::TYPE_MATERNITY,
                LeaveApplication::TYPE_PATERNITY,
            ]);
            $table->text('reason');
            $table->enum('status', [
                LeaveApplication::STATUS_PENDING,
                LeaveApplication::STATUS_APPROVED,
                LeaveApplication::STATUS_DENIED,
            ])->default(LeaveApplication::STATUS_PENDING);
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
        Schema::dropIfExists('hr_leave_applications');
    }
}
