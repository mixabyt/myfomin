<?php

namespace App\Repositories;

use App\Dto\TransactionDto;
use App\Dto\TransactionRequestDto;
use App\Models\Transaction;
use Illuminate\Support\Collection;

class TransactionRepository
{
    public function __construct(protected Transaction $transaction) {}

    public function get() :Collection {
        return $this->transaction->with('category', 'account')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getById(int $id) :Transaction {
        return $this->transaction->where('id', $id)->first();
    }

    public function create(TransactionRequestDto $dto) : Transaction {
        return $this->transaction->create([
            'account_id' => $dto->account_id,
            'type' => $dto->type,
            'amount' => $dto->amount,
            'description' => $dto->description,
            'category_id' => $dto->category_id,
        ]);
    }

    public function update(TransactionDto $dto) : Transaction {
         $transaction = $this->transaction->where('id', $dto->id)->first();
        $transaction->account_id = $dto->account_id;
        $transaction->type = $dto->type;
        $transaction->amount = $dto->amount;
        $transaction->description = $dto->description ?? null;
        $transaction->category_id = $dto->category_id;
        if ($dto->created_at !== null) {
            $transaction->created_at = $dto->created_at;
        }
        $transaction->save();
        return $transaction;
    }



    public function deleteById($id) : bool {
        return $this->transaction->where('id', $id)->delete() > 0;
    }
}
