<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBirthdayMajorPhotoToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->date('birthday')->nullable(); // Nullable if not required immediately
            $table->string('major')->nullable(); // Nullable if not required immediately
            $table->string('photo')->nullable(); // Path to the uploaded photo
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['birthday', 'major', 'photo']);
        });
    }
}
