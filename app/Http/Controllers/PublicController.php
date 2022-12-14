<?php

namespace App\Http\Controllers;

use App\Console\Kernel;
use App\Models\OrderBook;
use Illuminate\Events\Dispatcher;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Artisan;
use React\EventLoop\Loop;
use React\EventLoop\LoopInterface;
use React\EventLoop\StreamSelectLoop;
use Spatie\ShortSchedule\ShortSchedule;

class PublicController extends Controller
{
    /**
     * return view to frontend with data
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getIndexView()
    {
        //$this->startJob(); // start schedule job
        $data = $this->dataForChart();
        return view('chart')->with('data', $data);
    }

    /**
     * return data to frontend called by AJAX
     * @return array
     */
    public function getFreshData()
    {
        return $this->dataForChart();
    }

    /**
     * take data from DB, merge and return
     * @return array
     */
    private function dataForChart()
    {
        $data['asks'] = OrderBook::where('priznak', '=', 'asks')->orderBy('casova_peciatka', 'DESC')->take(1000)->get()->toArray();
        $data['bids'] = OrderBook::where('priznak', '=', 'bids')->orderBy('casova_peciatka', 'DESC')->take(1000)->get()->toArray();
        $datamerged = array_merge($data['asks'], $data['bids']);
        $columns = array_column($datamerged, 'casova_peciatka');
        array_multisort($columns, SORT_ASC, $datamerged);
        return $datamerged;
    }

    /**
     * automatic schedule job starting
     * @return void
     */
    private function startJob()
    {
        //TODO: make automatic job triggering
         //overlaping is handled by withoutOverlapping() at Kernel.php
         Artisan::call('short-schedule:run');
    }

}
