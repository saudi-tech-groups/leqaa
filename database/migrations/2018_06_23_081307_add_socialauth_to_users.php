<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSocialauthToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('google_id')->nullable();
            $table->timestamp('google_updated_at')->nullable();

            $table->string('github_id')->nullable();
            $table->timestamp('github_updated_at')->nullable();

            $table->string('twitter_id')->nullable();
            $table->timestamp('twitter_updated_at')->nullable();

            $table->boolean('need_password_update')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('google_id');
            $table->dropColumn('google_updated_at');
            $table->dropColumn('github_id');
            $table->dropColumn('github_updated_at');
            $table->dropColumn('twitter_id');
            $table->dropColumn('twitter_updated_at');

            $table->dropColumn('need_password_update');
        });
    }
}
