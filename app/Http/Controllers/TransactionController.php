<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

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
        $transaction = Transaction::create($request->all());

        return response()->json([
            'message' => 'Transaction created successfully',
            'transaction' => $transaction
        ]);
    }

    // update transaction by id
    public function updateTransaction(Request $request, $id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json([
                'message' => 'Transaction not found'
            ], 404);
        }

        $transaction->update($request->all());

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
}
