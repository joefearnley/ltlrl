<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Click;

class ClickController extends Controller
{
    private $click;

    public function __construct(Click $click)
    {
        $this->click = $click;
    }

    public function stats($urlId)
	{
		$clickData = $this->forUrlGroupedByDate($urlId)->get();

		return response()->json($clickData)
	}
}
