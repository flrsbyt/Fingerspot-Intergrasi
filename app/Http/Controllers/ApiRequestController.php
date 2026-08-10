<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApiRequest;

class ApiRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = ApiRequest::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('command')) {
            $query->where('command', 'like', "%{$request->command}%");
        }

        $apiRequests = $query->latest()->paginate(30);

        return view('admin.api-requests', compact('apiRequests'));
    }

    public function show($id)
    {
        $apiRequest = ApiRequest::findOrFail($id);
        return view('admin.api-request-detail', compact('apiRequest'));
    }
}