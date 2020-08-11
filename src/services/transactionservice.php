<?php

require_once(__DIR__ . "/databaseservice.php");
require_once(__DIR__ . "/../models/transaction.php");

class TransactionService
{
    public function getTransaction($id)
    {
        // Connect with database
        $connection = $this->getDatabaseConnection();

        // Prepare query & protect against SQL injection, because we're binding parameters to the statement.
        // This will make sure that parameter values are quoted.
        $preparedStatement = $connection->prepare(
            'SELECT 
                t.id,
                t.created_at as `date`,
                up.firstname as `sender`,
                ur.firstname as `receiver`,
                t.amount,
                t.description
            FROM 
                transactions t
            INNER JOIN
                users up
            ON
                up.id = t.user_id_payer
            INNER JOIN
                users ur
            ON
                ur.id = t.user_id_receiver
            WHERE 
                t.id = :id
        ');

        // Execute query
        $preparedStatement->execute(
            [
                'id' => $id,
            ]
        );

        // Get SQL result
        return $preparedStatement->fetch(Pdo::FETCH_ASSOC);
    }

    public function getTransactionsByUserId($userId)
    {
        // Connect with database
        $connection = $this->getDatabaseConnection();

        // Prepare query & protect against SQL injection, because we're binding parameters to the statement.
        // This will make sure that parameter values are quoted.
        $preparedStatement = $connection->prepare(
            'SELECT 
                t.id,
                t.created_at as `date`,
                up.firstname as `sender`,
                ur.firstname as `receiver`,
                t.amount
            FROM 
                transactions t
            INNER JOIN
                users up
            ON
                up.id = t.user_id_payer
            INNER JOIN
                users ur
            ON
                ur.id = t.user_id_receiver
            WHERE 
                t.user_id_payer = :user_id_payer OR 
                t.user_id_receiver = :user_id_receiver');

        // Execute query
        $preparedStatement->execute(
            [
                'user_id_payer' => $userId,
                'user_id_receiver' => $userId,
            ]
        );

        // Get SQL result
        return $preparedStatement->fetchAll(Pdo::FETCH_ASSOC);
    }

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
            'INSERT INTO transactions (user_id_payer, user_id_receiver, amount, description, created_at)
            VALUES (:user_id_payer, :user_id_receiver, :amount, :description, :created_at)'
        );

        // Execute query
        $preparedStatement->execute(
            [
                'user_id_payer' => $transaction->getUserIdPayer(),
                'user_id_receiver' => $transaction->getUserIdReceiver(),
                'amount' => $transaction->getAmount(),
                'description' => $transaction->getDescription(),
                'created_at' => date('Y-m-d H:i:s'),
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
