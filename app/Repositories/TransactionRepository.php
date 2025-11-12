<?php

namespace App\Repositories;

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

    public function create(TransactionRequestDto $dto) : Transaction {
        return $this->transaction->create([
            'account_id' => $dto->account_id,
            'type' => $dto->type,
            'amount' => $dto->amount,
            'description' => $dto->description,
            'category_id' => $dto->category_id,
        ]);
    }
}
