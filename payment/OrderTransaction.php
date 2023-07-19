<?php

class OrderTransaction {

    public function getRecordQuery($tran_id)
    {
        $sql = "select * from accounts WHERE transaction_id='" . $tran_id . "'";
        return $sql;
    }

    public function saveTransactionQuery($post_data)
    {   
        require('../config.php');
        global $pdo;
        $userId = $post_data['user_id'];
        $transaction_amount = $post_data['total_amount'];
        $transaction_id = $post_data['tran_id'];
        $currency = $post_data['currency'];
        $event_id = intval($post_data['event_id']);

        $result = $pdo->prepare("SELECT * FROM accounts WHERE donor_id=? AND event_id=?");
        $result->execute(array(intval($userId),$event_id));
        $check  = $result->rowCount();
        $admin_profit = intval($transaction_amount) * 0.1;
        $donate_amount = doubleval($transaction_amount) - $admin_profit;
        if($check > 0){
            $data = $result->fetch();
            $total_amount = $data['donation_amount'] + doubleval($donate_amount);
            $total_profit = $data['platform_fee'] +doubleval($admin_profit);
            $sql = "UPDATE accounts SET amount='$total_amount',platform_fee='$total_profit', 
                    status='Pending', transaction_id='$transaction_id' WHERE donor_id='$userId' AND event_id='$event_id'
                    ";
            return $sql;
        }else{
            $sql = "INSERT INTO accounts (platform_fee,donor_id,event_id,donation_amount, status, transaction_id,currency)
                                VALUES ('$admin_profit','$userId', '$event_id', '$donate_amount', 'Pending', '$transaction_id','$currency')";
            return $sql;
        }
    }
    public function updateTransactionQuery($tran_id, $type = 'Success')
    {
        $sql = "UPDATE accounts SET status='$type' WHERE transaction_id='$tran_id'";

        return $sql;
    }
}

