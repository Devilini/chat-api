<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tokens', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->timestamp('expires_at');
            $table->timestamps();
        });

        \Illuminate\Support\Facades\DB::table('tokens')->insert(
            [
                'id' => 'eyJhbGciOiJIUzI1NiJ9.eyJSb2xlIjoiQWRtaW4iLCJJc3N1ZXIiOiJJc3N1ZXIiLCJVc2VybmFtZSI6IkphdmFJblVzZSIsImV4cCI6MTYyNjg5NzU1NywiaWF0IjoxNjI2ODk3NTU3fQ.QLtDeDWzRANP4nD3WhruFQGDRMnbqqsn0KAAUha9Ows',
                'expires_at' => '2023-12-31 23:59:59',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tokens');
    }
}
