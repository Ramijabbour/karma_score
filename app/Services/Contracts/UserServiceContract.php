<?php

namespace App\Services\Contracts;

/**
 * Interface UserServiceContract
 * @package App\Services\Contracts
 */
interface UserServiceContract
{

    // get position with all information for this user and previous and next Users
    public function overallUserPosition($user, $numberOfRecord);

    // get user information
    public function getUserWithPosition($user, $rank);

    //If type Next then we will get next 2 users for this user otherwise we get previous 2 users
    public function getUsersWithPosition($user, $rank, $type, $numberOfRecord);

    //get Karma_score order by karma_score DESC
    public function getUsersKarmaScore();

}
