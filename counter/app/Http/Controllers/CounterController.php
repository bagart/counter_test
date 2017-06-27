<?php

namespace App\Http\Controllers;

use App\Repositories\CounterRepository;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CounterController extends Controller
{
    public function get(Request $request)
    {
        $counters = (new CounterRepository)
            ->getLastTopEventSumByCountry();
        switch ($request->get('format') ?? 'json') {
            case 'csv':
                return $this->exportCsv($counters);
            case 'json':
                return response()->json($counters);
            default:
                throw new \InvalidArgumentException('format not allowed');
        }
    }

    private function exportCsv($counters)
    {
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=counter.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $callback = function () use ($counters) {
            if ($counters) {
                $file = fopen('php://output', 'w');
                fputcsv($file, array_keys((array)$counters[0]));
                foreach ($counters as $counter) {
                    fputcsv($file, (array)$counter);
                }
                fclose($file);
            }
        };

        return StreamedResponse::create($callback, 200, $headers);
    }

    public function inc(Request $request)
    {
        (new CounterRepository())
            ->inc(
                $request->get('country'),
                $request->get('event')
            );

        return response()->json([
            'result' => true,
        ]);
    }
}
