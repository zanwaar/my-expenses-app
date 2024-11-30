<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('approvals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('expense_id');
            $table->unsignedBigInteger('approver_id');
            $table->unsignedBigInteger('status_id')->default(1); // Default: 'menunggu persetujuan'
            $table->timestamps();
        
            $table->foreign('expense_id')->references('id')->on('expenses')->onDelete('cascade');
            $table->foreign('approver_id')->references('id')->on('approvers')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approvals');
    }
};
