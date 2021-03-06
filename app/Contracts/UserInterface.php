<?php

namespace App\Contracts;

interface UserInterface
{
    /**
     * @param  int  $id
     * @return \App\User
     */
    public function getUser(int $id);

    /**
     * @return \App\User
     */
    public function storeUser();

    /**
     * @param  int  $id
     * @return \App\User
     */
    public function updateUser(int $id);
}
