<?php

namespace App\Http\Controllers\Analytics;

use App\BusinessLogicLayer\Shapes\ShapesIntegrationManager;
use App\Http\Controllers\Controller;
use App\Repository\Analytics\AnalyticsEventRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AnalyticsEventController extends Controller {
    protected AnalyticsEventRepository $analyticsEventRepository;

    protected ShapesIntegrationManager $shapesIntegrationManager;

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
            try {
                $response = $this->shapesIntegrationManager->sendMobileUsageDataToDatalakeAPI($data['token'], $data['name'], $data['lang'], $data['version'], $data['source']);
            } catch (\Exception $e) {
                Log::error($e);
                app('sentry')->captureException($e);
            }
        }

        return $this->analyticsEventRepository->create([
            'name' => $request->name,
            'source' => $request->source,
            'payload' => json_encode($request->all()),
            'response' => $response,
        ]);
    }
}
