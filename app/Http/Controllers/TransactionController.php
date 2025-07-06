<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransactionController extends Controller
{
    // get all transactions
    public function getAllTransactions()
    {
        $transactions = Transaction::all();
        $transactionsCount = $transactions->count();

        // if perams count=true then return only count of transactions
        if (request()->count) {
            return response()->json([
                'message' => 'Transactions count retrieved successfully',
                'count' => $transactionsCount
            ]);
        }

        return response()->json([
            'message' => 'Transactions retrieved successfully',
            'count' => $transactionsCount,
            'transactions' => $transactions
        ]);
    }

    // get transaction by id
    public function getTransactionById($id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json([
                'message' => 'Transaction not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Transaction retrieved successfully',
            'transaction' => $transaction
        ]);
    }

    // create transaction
    public function createTransaction(Request $request)
    {
        $createTransaction = $request->all();

        if ($createTransaction['amount'] < 0) {
            return response()->json([
                'message' => 'Amount cannot be negative'
            ], 400);
        }

        // if has file then upload it
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $image->move(public_path('images/transaction'), $imageName);
            $createTransaction['image'] = 'images/transaction/' . $imageName;
        }

        if (isset($createTransaction['user_id'])) {
            $createTransaction['user_id'] = $createTransaction['user_id'];
        }

        if (isset($createTransaction['participant_id'])) {
            $createTransaction['participant_id'] = $createTransaction['participant_id'];
        }

        if (!isset($createTransaction['transaction_type']) === "bva") {
            User::where('id', $createTransaction['user_id'])
                ->update(['isBva' => true]);
        }

        $transaction = Transaction::create($createTransaction);

        return response()->json([
            'message' => 'Transaction created successfully',
            'transaction' => $transaction
        ]);
    }

    // update transaction by id
    public function updateTransaction(Request $request, $id)
    {
        $updateTransaction = $request->all();
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json([
                'message' => 'Transaction not found'
            ], 404);
        }

        // if amount is negative
        if ($updateTransaction['amount'] < 0) {
            return response()->json([
                'message' => 'Amount cannot be negative'
            ], 400);
        }

        // if has file then upload it
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $image->move(public_path('images/transaction'), $imageName);
            $updateTransaction['image'] = 'images/transaction/' . $imageName;
        }

        // delete the old image
        if (file_exists(public_path($transaction->image))) {
            unlink(public_path($transaction->image));
        }

        $transaction->update($updateTransaction);

        return response()->json([
            'message' => 'Transaction updated successfully',
            'transaction' => $transaction
        ]);
    }

    // delete transaction by id
    public function deleteTransaction($id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json([
                'message' => 'Transaction not found'
            ], 404);
        }

        // delete old image
        if (file_exists(public_path($transaction->image))) {
            unlink(public_path($transaction->image));
        }

        $transaction->delete();

        return response()->json([
            'message' => 'Transaction deleted successfully'
        ]);
    }

    // get transactions by user id
    public function getTransactionsByUserId($user_id)
    {
        $transactions = Transaction::where('user_id', $user_id)->get();
        $transactionsCount = $transactions->count();

        return response()->json([
            'message' => 'Transactions retrieved successfully',
            'count' => $transactionsCount,
            'transactions' => $transactions
        ]);
    }

    // get transactions by participant id
    public function getTransactionsByParticipantId($participant_id)
    {
        $transactions = Transaction::where('participant_id', $participant_id)->get();
        $transactionsCount = $transactions->count();

        return response()->json([
            'message' => 'Transactions retrieved successfully',
            'count' => $transactionsCount,
            'transactions' => $transactions
        ]);
    }
}
