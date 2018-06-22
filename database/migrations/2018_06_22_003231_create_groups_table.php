<?php

use App\GroupMembershipType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');

            $table->text('description');
            $table->string('logo')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('group_membership_types', function (Blueprint $table) {
            $table->string('type')->primary();
            $table->timestamps();
        });

        GroupMembershipType::forceCreate(['type' => 'ORGANIZER']);
        GroupMembershipType::forceCreate(['type' => 'MEMBER']);

        Schema::create('group_memberships', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('group_id')
                ->references('id')->on('groups');
            $table->unsignedInteger('user_id')
                ->references('id')->on('users');

            $table->unique(['group_id', 'user_id']);

            $table->string('type')
                ->references('type')->on('group_membership_types');

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
        Schema::dropIfExists('group_membership_types');
        Schema::dropIfExists('group_memberships');
        Schema::dropIfExists('groups');
    }
}
