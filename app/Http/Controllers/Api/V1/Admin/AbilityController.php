<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;

class AbilityController extends Controller
{
    public function index()
    {
        $permissions = auth()->user()->roles()->with('permissions')->get()
            ->pluck('permissions')
            ->flatten()
            ->pluck('value')
            ->toArray();

        return response()->json(['permissions' => $permissions]);
    }
}
