<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class KelolaPenggunaController extends Controller
{
    public function index()
    {
       
    $users = User::all(); // Ambil semua user dari database
    return view('kelola-pengguna.index', [
        'title' => 'Dashmin LifeCareYou',
        'users' => $users
    ]);
}


    public function store(Request $request)
    {
        // dd($request->all());
        // Validate and store the user data
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'jabatan' => 'required',
            'password' => 'required'
        ]);

        // Create the user
       User::create([
            'name' => $request->name,
            'email' => $request->email,
            'jabatan' => $request->jabatan,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('kelola-pengguna')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'jabatan' => 'required'
        ]);

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->jabatan = $request->jabatan;
        
        if($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        
        $user->save();

        return redirect()->route('kelola-pengguna')->with('success', 'Data pengguna berhasil diperbarui');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect()->route('kelola-pengguna')->with('success', 'Data pengguna berhasil dihapus');
    }
}
