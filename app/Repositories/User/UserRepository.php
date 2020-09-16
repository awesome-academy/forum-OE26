<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function getModel(): string
    {
        return User::class;
    }

    public function getUserDashboard(int $itemPerPage): LengthAwarePaginator
    {
        return User::withCount('questions')
            ->withCount('answers')
            ->withCount('comments')
            ->withCount('votes')
            ->paginate($itemPerPage);
    }

    public function getUserChartData(int $months): array
    {
        $data = User::select(DB::raw('count(*) as `data`'),  DB::raw('YEAR(created_at) year, MONTHNAME(created_at) month'))
            ->groupby('year', 'month')
            ->get()
            ->reduce(function ($array, $item) {
                $length = isset($array['dataset']) ? count($array['dataset']) : 0;
                $array['labels'][$length] = $item->month . ' - ' . $item->year;
                if ($length > 0) {
                    $array['dataset'][$length] = $array['dataset'][$length - 1] + $item->data;
                } else {
                    $array['dataset'][$length] = $item->data;
                }

                return $array;
            }, []);

        $data['labels'] = array_slice($data['labels'], -$months, $months);
        $data['dataset'] = array_slice($data['dataset'], -$months, $months);

        return $data;
    }
}
