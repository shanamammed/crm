<?php

use App\Enums\DealStatus;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('pipeline_id');
            $table->foreign('pipeline_id')
                ->references('id')
                ->on('pipelines');

            $table->unsignedBigInteger('stage_id');
            $table->foreign('stage_id')
                ->references('id')
                ->on('stages');

            $table->unsignedInteger('status')->default('1');
            $table->dateTime('won_date')->index()->nullable();
            $table->dateTime('lost_date')->index()->nullable();
            $table->string('lost_reason')->nullable()->index();

            $table->unsignedBigInteger('user_id')->nullable()->comment('Owner');
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->dateTime('owner_assigned_date')->nullable();
            $table->date('expected_close_date')->index()->nullable();
            $table->dateTime('stage_changed_date')->nullable();
            $table->decimal('amount', 15, 3)->index()->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')
                ->references('id')
                ->on('users');
            $table->softDeletes();
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
        Schema::dropIfExists('deals');
    }
};
