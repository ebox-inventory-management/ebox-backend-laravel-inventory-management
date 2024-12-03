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
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('role', 15)
                ->default(config('settings.default_role')); // User role with default value
            $table->string('first_name'); // User's first name
            $table->string('last_name'); // User's last name
            $table->string('business_name')->nullable(); // Optional business name
            $table->date('dob')->nullable(); // Optional date of birth
            $table->string('gender', 10)->nullable(); // Gender (optional, e.g., Male/Female/Other)
            $table->text('address')->nullable(); // Full address (optional)
            $table->string('contact_number', 20)->nullable(); // Contact number (optional)
            $table->string('email')->unique(); // Unique email address
            $table->timestamp('email_verified_at')->nullable(); // Email verification timestamp
            $table->string('password'); // Password for authentication
            $table->string('image')->nullable(); // Optional profile image
            $table->rememberToken(); // Token for "remember me" functionality
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
