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
        Schema::table('rating', function (Blueprint $table) {
            // Rename recipe_id to food_id
            if (Schema::hasColumn('rating', 'recipe_id') && !Schema::hasColumn('rating', 'food_id')) {
                $table->renameColumn('recipe_id', 'food_id');
            }

            // Add comment field if it doesn't exist
            if (!Schema::hasColumn('rating', 'comment')) {
                $table->text('comment')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rating', function (Blueprint $table) {
            // Rename food_id back to recipe_id
            if (Schema::hasColumn('rating', 'food_id') && !Schema::hasColumn('rating', 'recipe_id')) {
                $table->renameColumn('food_id', 'recipe_id');
            }

            // Drop comment field if it exists
            if (Schema::hasColumn('rating', 'comment')) {
                $table->dropColumn('comment');
            }
        });
    }
};
