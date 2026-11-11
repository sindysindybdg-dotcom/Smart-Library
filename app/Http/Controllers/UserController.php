<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::with('role')->orderBy('created_at', 'desc');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->where('id_role', $request->role);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $users = $query->paginate(10);
        $roles = Role::all();

        return view('admin.users', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.users-create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|unique:users,username|max:100',
            'password' => 'required|min:6',
            'nama' => 'required|max:100',
            'id_role' => 'required|exists:roles,id_role',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        // PERBAIKAN: Gunakan 'users.index' (tanpa admin.)
        return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('admin.users-edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'username' => 'required|unique:users,username,'.$id.',id_user|max:100',
            'nama' => 'required|max:100',
            'id_role' => 'required|exists:roles,id_role',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        // Update password only if provided
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        // PERBAIKAN: Gunakan 'users.index' (tanpa admin.)
        return redirect()->route('users.index')->with('success', 'Pengguna berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        // PERBAIKAN: Gunakan 'users.index' (tanpa admin.)
        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus!');
    }

    /**
     * Export users to CSV
     */
    public function export()
    {
        $users = User::with('role')->get();
        
        $filename = 'users_' . date('Y-m-d_His') . '.csv';
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Username', 'Nama', 'Role', 'Status', 'Last Login', 'Created At']);
        
        foreach ($users as $user) {
            fputcsv($output, [
                $user->id_user,
                $user->username,
                $user->nama,
                $user->role->nama_role,
                $user->status,
                $user->last_login,
                $user->created_at
            ]);
        }
        
        fclose($output);
        exit;
    }
}