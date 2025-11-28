<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User; // Ensure User model is imported
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Import the Log facade for error logging
// If you plan to use Gate for more granular authorization beyond the 'is_admin' middleware,
// you might also need: use Illuminate\Support\Facades\Gate;

class AdminUserController extends Controller
{
    /**
     * Display a listing of all registered users for admin.
     * This will now load the 'resources/views/admin/users/view_user.blade.php' file.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch all users from the database who are NOT administrators.
        // If you want to view ALL users (including admins), remove the 'where' clause.
        $users = User::where('is_admin', false) // Exclude admin users (adjust column name if different)
                     ->latest() // Order by most recently registered
                     ->paginate(10); // Display 10 users per page

        // Return the 'admin.users.view_user' view, passing the $users collection
        return view('admin.users.view_user', compact('users'));
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  \App\Models\User  $user  // Laravel's Route Model Binding
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        // --- IMPORTANT: Authorization & Safety Checks ---
        // 1. Prevent Admin Self-Deletion: You should ideally prevent an admin from deleting themselves.
        //    This depends on how your admin user is identified (e.g., ID=1, or a specific email).
        //    Example: if (auth()->id() === $user->id) {
        //                 return redirect()->back()->with('error', 'You cannot delete your own admin account.');
        //             }
        // 2. Prevent Deleting Primary Admin: If you have a 'super admin' account (e.g., ID 1 or a specific email),
        //    you might want to prevent its deletion entirely.
        //    Example: if ($user->id === 1) { // Assuming ID 1 is the primary admin
        //                 return redirect()->back()->with('error', 'Cannot delete the primary administrator account.');
        //             }
        // 3. More Granular Authorization: The 'is_admin' middleware ensures only admins can reach this,
        //    but if you have roles like 'editor' vs 'super_admin' within admins, you'd use Gates/Policies.
        //    Example: $this->authorize('delete', $user); // Requires a UserPolicy

        try {
            $user->delete();
            return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');

        } catch (\Exception $e) {
            // Log the detailed error for debugging purposes
            Log::error('Error deleting user: ' . $e->getMessage(), ['user_id' => $user->id, 'trace' => $e->getTraceAsString()]);

            // Redirect back with an error message
            return redirect()->back()->with('error', 'Error deleting user: ' . $e->getMessage());
        }
    }
}