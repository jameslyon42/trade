<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Repositories\SecurityRepository;


class SecurityController extends Controller
{
    public $securityRepository;

    public function __construct(SecurityRepository $security_repository)
    {
        $this->securityRepository = $security_repository;
    }

    public function search(Request $request)
    {

        $search_text = $request->search_text;

        if ($search_text) {
            $securities = $this->securityRepository->search($search_text);

            return json_encode($securities);
        }
    }

    public function show($security_id)
    {
        $average_durations = [10, 30];

        $history_graph  = $this->securityRepository->historyGraph($security_id, $average_durations);

        return json_encode([
            'data' => $history_graph,
            'average_durations' => $average_durations
        ]);
    }
}
