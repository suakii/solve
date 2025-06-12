<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProblemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('problems', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained();
            $t->string('slug')->unique();
            $t->string('title');

            // Markdown 하나만 필수
            $t->text('statement');

            // 나머지는 선택 입력 → nullable()
            $t->text('input_format')->nullable();
            $t->text('output_format')->nullable();
            $t->text('constraints')->nullable();
            $t->text('sample_input')->nullable();
            $t->text('sample_output')->nullable();
            $t->text('explanation')->nullable();

            $t->integer('time_limit')->default(1000);
            $t->integer('memory_limit')->default(256 * 1024); // KB
            $t->enum('judge_type', ['NORMAL','SPECIAL','OUTPUT_ONLY'])
            ->default('NORMAL');
            $t->string('judge_lang')->nullable();
            $t->enum('status',['CREATED','CREATED_NOT_LISTED','DELETED'])
            ->default('CREATED_NOT_LISTED');
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
        Schema::dropIfExists('problems');
    }
}
