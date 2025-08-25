<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function destroyUser(string $username)
    {
        $user = User::where('username', $username)->firstOrFail();

        // Cegah penghapusan user dengan role admin
        if ($user->role === 'admin') {
            return back()->withErrors([
                'admin' => 'Tidak dapat menghapus pengguna dengan role admin.']
            );
        }

        $user->delete();

        return back()->with('success', 'Pengguna berhasil dihapus.');
    }

    public function destroyPost(string $id)
    {
        $post = Post::findOrFail($id);

        // Hanya admin atau pemilik post yang bisa hapus
        if (auth()->user()->role !== 'admin' && auth()->user()->id !== $post->user_id) {
            abort(403, 'Akses ditolak.');
        }

        // Hapus gambar jika ada
        if ($post->image && Storage::exists($post->image)) {
            Storage::delete($post->image);
        }

        $post->delete();

        return back()->with('success', 'Post berhasil dihapus.');
    }
}
