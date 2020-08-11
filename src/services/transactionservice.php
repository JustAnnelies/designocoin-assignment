<?php

require_once(__DIR__ . "/databaseservice.php");
require_once(__DIR__ . "/../models/transaction.php");

class TransactionService
{
    public function storeTransaction($payer, array $data)
    {
        $this->doesPayerHaveSufficientFunds($payer, $data['amount']);

        // Create instance of Transaction
        // This will only create the instance if the given data is valid
        $transaction = new Transaction($payer['id'], $data['receiver'], $data['amount'], $data['description']);

        // Connect with database
        $connection = $this->getDatabaseConnection();

        // Prepare query & protect against SQL injection, because we're binding parameters to the statement.
        // This will make sure that parameter values are quoted.
        $preparedStatement = $connection->prepare(
            'INSERT INTO transactions (user_id_payer, user_id_receiver, amount, description)
            VALUES (:user_id_payer, :user_id_receiver, :amount, :description)'
        );

        // Execute query
        $preparedStatement->execute(
            [
                'user_id_payer' => $transaction->getUserIdPayer(),
                'user_id_receiver' => $transaction->getUserIdReceiver(),
                'amount' => $transaction->getAmount(),
                'description' => $transaction->getDescription(),
            ]
        );
    }

    /**
     * The payer should have sufficient funds for a transaction to go through
     */
    private function doesPayerHaveSufficientFunds(array $payer, $amount)
    {
        $payerBalance = $payer['balance'];

        if ($payerBalance < $amount) {
            throw new Exception('The payer does not have sufficient funds for a transfer of ' . $amount);
        }
    }

    private function getDatabaseConnection()
    {
        $connection = new DatabaseService();

        return $connection->connect();
    }
}
