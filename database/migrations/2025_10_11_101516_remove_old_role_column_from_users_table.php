<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, ensure all users without role_id get assigned a default role
        $registeredRole = Role::where('name', 'registered')->first();
        
        if ($registeredRole) {
            User::whereNull('role_id')->update(['role_id' => $registeredRole->id]);
        }
        
        // Then remove the old role column
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add back the role column if needed to rollback
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('registered')->after('email_verified_at');
        });
        
        // Populate the old role column based on role_id
        $users = User::with('role')->get();
        foreach ($users as $user) {
            if ($user->role) {
                $user->update(['role' => $user->role->name]);
            }
        }
    }
};
