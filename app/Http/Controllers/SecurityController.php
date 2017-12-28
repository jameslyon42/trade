<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Security;

class SecurityController extends Controller
{
    public function search(Request $request) {

        $search_text = $request->search_text;

        if ($search_text) {
            $securities = Security::where('symbol','like', "%$search_text%")
                ->orWhere('name', 'like', "%$search_text%")
                ->orderBy('symbol', 'asc')
                ->limit(10)
                ->get();

            return $securities->toJson();
        }
    }

    public function show($id) {
        $security = Security::with('prices')->find($id);

        return $security->toJson();
    }
}
