<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registers', function (Blueprint $table) {
            $table->integer('id_user');
            $table->integer('id_batch');
            $table->string('name');
            $table->string('position');
            $table->string('linkedin')->nullable();
            $table->string('linkedin2')->nullable();
            $table->string('linkedin3')->nullable();
            $table->enum('commitmen', ['fulltime', 'parttime']);
            $table->string('email');
            $table->string('phone');
            $table->string('startup_name');
            $table->string('founded');
            $table->string('city');
            $table->string('website')->nullable();
            $table->text('desc');
            $table->enum('startup_category', ['Tourism', 'Health', 'Fishery', 'Agriculture']);
            $table->enum('company_status', ['CV', 'PT', 'unknown']);
            $table->text('problem');
            $table->text('problem_experience');
            $table->text('problem_solve');
            $table->text('problem_early_adopter');
            $table->text('problem_early_adopter_location');
            $table->enum('problem_often_feel', ['Harian', 'Mingguan', 'Bulanan', 'Tahunan']);
            $table->text('problem_intense');
            $table->text('solution');
            $table->enum('solution_exist', ['Ya', 'Tidak']);
            $table->text('solution_yes')->nullable();
            $table->text('solution_no')->nullable();
            $table->text('solution_unique');
            $table->text('solution_user');
            $table->text('solution_feature');
            $table->text('solution_tech')->nullable();
            $table->text('solution_tech_function');
            $table->text('solution_link')->nullable();
            $table->text('solution_account')->nullable();
            $table->text('solution_password')->nullable();
            $table->enum('traction_active_user', ['Ya', 'Tidak']);
            $table->enum('traction_market', ['B2B', 'B2C', 'B2B2C', 'B2G', 'Others'])->nullable();
            $table->text('traction_customer')->nullable();
            $table->text('traction_matric_primary')->nullable();
            $table->text('traction_matric_reason')->nullable();
            $table->text('traction_pm1')->nullable();
            $table->text('traction_pm2')->nullable();
            $table->text('traction_pm3')->nullable();
            $table->text('traction_pm4')->nullable();
            $table->text('traction_pm5')->nullable();
            $table->text('traction_pm6')->nullable();
            $table->enum('traction_revenue', ['Ya', 'Tidak'])->nullable();
            $table->text('traction_bm')->nullable();
            $table->text('traction_gp')->nullable();
            $table->text('other_indigo_reason');
            $table->text('other_indigo_know');
            $table->text('other_indigo_recomend')->nullable();
            $table->enum('other_bootcamp_status', ['Ya', 'Tidak']);
            $table->text('other_bootcamp')->nullable();
            $table->string('pitchdeck');
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
        Schema::dropIfExists('registers');
    }
};