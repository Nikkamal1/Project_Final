<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLineNotifyTable extends Migration
{
    public function up()
    {
        Schema::create('line_notifies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique(); // หรือไม่ก็สามารถเอา unique ออกได้ถ้าต้องการให้ user_id ซ้ำ
            $table->string('access_token'); // เพิ่ม access_token
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('line_notifies');
    }
}
