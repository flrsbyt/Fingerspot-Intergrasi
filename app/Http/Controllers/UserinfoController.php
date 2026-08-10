<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Userinfo;

class UserinfoController extends Controller
{
    public function index(Request $request)
    {
        $query = Userinfo::query();

        // SEARCH (nama, PIN, department)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('pin', 'like', "%$search%")
                  ->orWhere('department', 'like', "%$search%");
            });
        }

        // FILTER DEPARTMENT (tambahan)
        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        // FILTER POSITION (tambahan)
        if ($request->filled('position')) {
            $query->where('position', $request->position);
        }

        $userinfos = $query->paginate(10)->withQueryString();

        return view('admin.userinfos', compact('userinfos'));
    }

    public function show($id)
    {
        $userinfo = Userinfo::findOrFail($id);
        return view('admin.userinfo-detail', compact('userinfo'));
    }

    public function destroy($id)
    {
        Userinfo::destroy($id);
        return redirect()->back()->with('message', 'User berhasil dihapus');
    }
}