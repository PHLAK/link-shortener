<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CreateUsersTable extends Migration
{
    /** Run the migrations. */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('is_admin')->default(false);
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->text('profile_photo_path')->nullable();
            $table->timestamps();
        });

        $this->seed();
    }

    /** Reverse the migrations. */
    public function down()
    {
        Schema::dropIfExists('users');
    }

    /** Seed the users table. */
    protected function seed()
    {
        $user = new User([
            'name' => 'Chris Kankiewicz',
            'email' => 'Chris@ChrisKankiewicz.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make(
                App::environment('local') ? 'secret' : Str::random(32)
            ),
        ]);

        $user->is_admin = true;

        $user->save();
    }
}
