<?php

namespace App\Http\Controllers\Analytics;

use App\BusinessLogicLayer\Shapes\ShapesIntegrationManager;
use App\Http\Controllers\Controller;
use App\Repository\Analytics\AnalyticsEventRepository;
use Illuminate\Http\Request;

class AnalyticsEventController extends Controller {
    protected $analyticsEventRepository;

    protected $shapesIntegrationManager;

    public function __construct(AnalyticsEventRepository $analyticsEventRepository,
                                ShapesIntegrationManager $shapesIntegrationManager) {
        $this->analyticsEventRepository = $analyticsEventRepository;
        $this->shapesIntegrationManager = $shapesIntegrationManager;
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'source' => 'required',
        ]);
        $data = $request->all();
        $response = json_encode([]);
        if (isset($data['token']) && strlen($data['token']) > 5 && ShapesIntegrationManager::isEnabled()) {
            $response = $this->shapesIntegrationManager->sendMobileUsageDataToDatalakeAPI($data['token'], $data['name'], $data['lang'], $data['version'], $data['source']);
        }

        $record = $this->analyticsEventRepository->create([
            'name' => $request->name,
            'source' => $request->source,
            'payload' => json_encode($request->all()),
            'response' => $response,
        ]);

        return $record;
    }
}
