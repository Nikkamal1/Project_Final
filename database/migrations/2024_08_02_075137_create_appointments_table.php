<?php
// database/migrations/xxxx_xx_xx_create_appointments_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone');
            $table->string('pickup_house_number')->nullable();
            $table->string('pickup_street')->nullable();
            $table->string('pickup_subdistrict')->nullable();
            $table->string('pickup_district')->nullable();
            $table->string('pickup_province')->nullable();
            $table->string('dropoff_location');
            $table->date('appointment_date');
            $table->string('picture')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
