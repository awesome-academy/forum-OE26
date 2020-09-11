<?php

namespace App\Charts;

use App\Repositories\User\UserRepositoryInterface;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;

class UserChart extends BaseChart
{
    protected $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $data = $this->userRepository->getUserChartData(config('constants.chart_months'));

        return Chartisan::build()
            ->labels($data['labels'])
            ->dataset(trans('admin.blank'), $data['dataset'])
            ->dataset(trans('admin.number_of_users'), $data['dataset']);
    }
}
