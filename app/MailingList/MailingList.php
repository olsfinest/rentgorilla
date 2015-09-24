<?php namespace RentGorilla\MailingList;

use RentGorilla\User;

interface MailingList
{
    public function addUserToList(User $user);
    public function removeUserFromList(User $user);
}