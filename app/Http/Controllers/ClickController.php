<?php

namespace App\Http\Controllers;

use App\Click;
use Carbon\Carbon;

class ClickController extends Controller
{
    /**
     * Click model instance.
     *
     * @var Click
     */
    private $click;

    /**
     * Create a ClickController instance.
     *
     * @param Click $click
     */
    public function __construct(Click $click)
    {
        $this->click = $click;
    }

    /**
     * Get the clicks status for a given url.
     *
     * Build a click history of the number of clicks
     *
     * @param $urlId
     * @return \Illuminate\Http\JsonResponse
     */
    public function statsForUrl($urlId)
	{
        $clickData = $this->click->forUrlGroupedByDate($urlId)->get();
        $twoWeeksOfClickData = collect([]);

        for ($i = 14; $i > 0; $i--) {
            $data = [
                'clicks' => 0,
                'date' => Carbon::now()->subDays($i)->format('m/d/Y')
            ];

            foreach ($clickData as $cd) {
                if ($data['date'] === $cd->date) {
                    $data['clicks'] = $cd->clicks;
                }
            }

            $twoWeeksOfClickData->push($data);
        }

		return response()->json($twoWeeksOfClickData);
	}
}
