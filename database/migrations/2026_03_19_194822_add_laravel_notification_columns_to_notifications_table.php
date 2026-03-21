<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->string('notifiable_type')->nullable()->after('user_id');
            $table->unsignedBigInteger('notifiable_id')->nullable()->after('notifiable_type');
            $table->text('data')->nullable()->after('notifiable_id');
            $table->timestamp('read_at')->nullable()->after('data');
        });
    }

    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropColumn(['notifiable_type', 'notifiable_id', 'data', 'read_at']);
        });
    }
};
