<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('description')->nullable();
            $table->decimal('amount', 10, 2)->default(0);
            $table->string('category')->nullable();
            $table->string('document')->nullable();
            $table->boolean('is_active')->default(false);

            // Manager Status
            $table->string('status_manager')->default('Submitted');
            $table->text('remarks_manager')->nullable();

            // HOD Status
            $table->string('status_hod')->default('Submitted');
            $table->text('remarks_hod')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('expenses');
    }
};
