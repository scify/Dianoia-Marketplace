<?php

namespace App\Http\Controllers\Analytics;

use App\Http\Controllers\Controller;
use App\Repository\Analytics\AnalyticsEventRepository;
use Illuminate\Http\Request;

class AnalyticsEventController extends Controller {
    protected AnalyticsEventRepository $analyticsEventRepository;

    public function __construct(AnalyticsEventRepository $analyticsEventRepository) {
        $this->analyticsEventRepository = $analyticsEventRepository;
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'source' => 'required',
        ]);
        $response = json_encode([]);

        return $this->analyticsEventRepository->create([
            'name' => $request->name,
            'source' => $request->source,
            'payload' => json_encode($request->all()),
            'response' => $response,
        ]);
    }
}
