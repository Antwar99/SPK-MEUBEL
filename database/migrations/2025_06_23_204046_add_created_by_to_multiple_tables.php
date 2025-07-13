<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        $tables = ['woods', 'criterias', 'sub_criteria', 'alternatives', 'categories', 'criteria_analyses'];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->foreignId('created_by')
                      ->nullable()
                      ->after('id') // kamu bisa ubah letaknya sesuai kebutuhan
                      ->constrained('users')
                      ->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        $tables = ['woods', 'criterias', 'sub_criteria', 'alternatives', 'categories', 'criteria_analyses'];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropForeign([$table->getTable().'_created_by_foreign']);
                $table->dropColumn('created_by');
            });
        }
    }
};
