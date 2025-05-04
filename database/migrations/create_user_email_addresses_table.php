<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create(config('vetrol-auth.user_email_addresses_table', 'user_email_addresses'), function (Blueprint $table) {
            $table->id();
            $table->morphs('emailable');
            $table->string('email')->unique();
            $table->boolean('is_primary')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop(config('vetrol-auth.user_email_addresses_table', 'user_email_addresses'));
    }
};
