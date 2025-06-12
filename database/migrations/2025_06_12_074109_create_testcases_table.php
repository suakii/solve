<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestcasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('testcases', function (Blueprint $t) {
            $t->id();
            $t->foreignId('problem_id')->constrained()->cascadeOnDelete();
            $t->string('name');          // '1', 'sample1' …
            $t->string('in_path');
            $t->string('out_path');
            $t->boolean('is_sample')->default(false);
            $t->unsignedBigInteger('size_in')->nullable();
            $t->unsignedBigInteger('size_out')->nullable();
            $t->string('md5_in', 32)->nullable();
            $t->string('md5_out',32)->nullable();
            $t->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('testcases');
    }
}
