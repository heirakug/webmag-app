<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\SoftDeletes;

return new class extends Migration
{

    use SoftDeletes;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('title_background')->nullable();
            $table->string('category')->nullable();
            $table->text('body');
            $table->text('excerpt')->nullable();
            $table->json('tags')->nullable();
            $table->enum('status', [
                'draft',
                'ready_for_review',
                'submitted',
                'editor_review',
                'revision_required',
                'editor_approved',
                'editor_rejected',
                'published',
                'archived'
            ])->default('draft');
            $table->foreignId('writer_id')->constrained('writers');
            $table->string('writer_name');
            $table->foreignId('editor_id')->nullable()->constrained('editors');
            $table->string('editor_name')->nullable();
            $table->timestamps();
            $table->SoftDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
