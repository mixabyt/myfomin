<?php

namespace App\Services;
use App\Dto\AccountDto;
use App\Dto\TransactionRequestDto;
use App\Dto\TransactionResponseDto;
use App\Repositories\AccountRepository;
use App\Repositories\TransactionRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    protected TransactionRepository $transactionRepository;
    protected AccountRepository $accountRepository;
    public function __construct(TransactionRepository $transactionRepository, AccountRepository $accountRepository) {
        $this->transactionRepository = $transactionRepository;
        $this->accountRepository = $accountRepository;

    }

    public function get() : Collection{
        return $this->transactionRepository->get();
    }

    public function store(TransactionRequestDto $dto) : TransactionResponseDto {
        return DB::transaction(function () use ($dto) {
           $transaction =  $this->transactionRepository->create($dto);
           $this->accountRepository->changeAmount($dto->account_id, $dto->amount, $dto->type);

           return new TransactionResponseDto($transaction->load('category', 'account'));

        });
    }

}
