<?php

namespace App\Services;

use App\Models\RankedUser;
use App\Services\Contracts\UserServiceContract;
use DB;

/**
 * Class UserService
 * @package App\Services
 */
class UserService implements UserServiceContract
{

    public function overallUserPosition($user, $numberOfRecord)
    {
        $numberOfRecord -= 1;
        if ($numberOfRecord % 2 != 0) {
            $previousNumber = (int)($numberOfRecord / 2) + 1;
            $nextNumber = (int)($numberOfRecord / 2);
        } else {
            $previousNumber = $numberOfRecord / 2;
            $nextNumber = $numberOfRecord / 2;
        }
        $rank = $this->getUsersKarmaScore(); // get all karma_score from highest karma_score to lowest
        $helpArrayOfRank = $rank;
        $rank = $rank->implode('karma_score', ', '); // convert collection to string
        $rank = str_replace(' ', '', $rank); // remove all spaces from this string
        $user1 = $this->getUserWithPosition($user, $rank);
        if ($user1->get()[0]->karma_score == $helpArrayOfRank[count($helpArrayOfRank) - 1]->karma_score || $user1->get()[0]->karma_score == $helpArrayOfRank[0]->karma_score) {
            $previousNumber = $numberOfRecord;
            $nextNumber = $numberOfRecord;
        }
        $previous = $this->getUsersWithPosition($user, $rank, 'Previous', $previousNumber);
        $next = $this->getUsersWithPosition($user, $rank, 'Next', $nextNumber);
        return $previous->union($user1)->union($next)->orderBy('karma_score', 'DESC')->get();
    }

    public function getUsersKarmaScore()
    {
        return RankedUser::select('karma_score as karma_score')
            ->orderBy('karma_score', 'DESC')
            ->get();
    }

    public function getUserWithPosition($user, $rank)
    {
        return RankedUser::where('ranked_users.id', '=', $user->id)
            ->join('images', 'images.id', '=', 'ranked_users.image_id')
            ->select('ranked_users.id', 'ranked_users.username', 'images.url', 'ranked_users.karma_score', DB::raw('FIND_IN_SET(ranked_users.karma_score, "' . $rank . '") as position'));
    }

    public function getUsersWithPosition($user, $rank, $type, $numberOfRecord)
    {
        if ($type == 'Previous') {
            $operand = '<=';
            $order = 'DESC';
        } else {
            $operand = '>=';
            $order = 'ASC';
        }
        return RankedUser::where('ranked_users.id', '!=', $user->id)
            ->join('images', 'images.id', '=', 'ranked_users.image_id')
            ->where('ranked_users.karma_score', $operand, $user->karma_score)
            ->select('ranked_users.id', 'ranked_users.username', 'images.url', 'ranked_users.karma_score', DB::raw('FIND_IN_SET(ranked_users.karma_score, "' . $rank . '") as position'))
            ->orderBy('ranked_users.karma_score', $order)
            ->take($numberOfRecord);
    }
}
