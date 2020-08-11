<?php

class Transaction
{
    private $userIdPayer;
    private $userIdReceiver;
    private $amount;
    private $description;

    public function __construct($userIdPayer, $userIdReceiver, $amount, $description)
    {
        $this->setUserIdPayer($userIdPayer);
        $this->setUserIdReceiver($userIdReceiver);
        $this->setAmount($amount);
        $this->setDescription($description);
    }

    public function getUserIdPayer()
    {
        return $this->userIdPayer;
    }

    public function setUserIdPayer($userIdPayer)
    {
        $this->userIdPayer = $userIdPayer;
    }

    public function getUserIdReceiver()
    {
        return $this->userIdReceiver;
    }

    public function setUserIdReceiver($userIdReceiver)
    {
        $this->userIdReceiver = $userIdReceiver;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * The amount should not be smaller than 1
     */
    public function setAmount($amount)
    {
        if ($amount < 1) {
            throw new Exception('The amount should not be smaller than 1');
        }

        $this->amount = $amount;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }
}
