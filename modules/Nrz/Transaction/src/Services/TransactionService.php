<?php

namespace Nrz\Transaction\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Nrz\Account\Services\AccountService;
use Nrz\Transaction\Contracts\CommissionProviderInterface;
use Nrz\Transaction\Contracts\TransactionProviderInterface;
use Nrz\Transaction\Exceptions\TransactionException;
use Nrz\Transaction\Models\Transaction;

class TransactionService
{
    public function __construct(public TransactionProviderInterface $transactionProvider , public CommissionProviderInterface $commissionProvider,public AccountService $accountService)
    {

    }
    public function storeTransaction(array $data): string|int|float
    {
        try {
            DB::beginTransaction();
            $tr = $this->transactionProvider->createNewTransaction($data);
            $this->storeBankCommission($tr);
            $this->updateAccountsBalance($tr);
            $this->createAccountHistory($tr);
            DB::commit();
        }catch (\Throwable $e){
            DB::rollBack();
            Log::error($e->getMessage());
            throw new TransactionException(__('message.internal-server-error'),500);
        }
        return $tr->res_number;

    }

    private function storeBankCommission(Transaction $transaction)
    {
        $this->commissionProvider->CreateNewBankCommission($transaction);
    }

    private function updateAccountsBalance(Transaction $transaction)
    {
        $this->accountService->updateAccountBalance($transaction->receiver , $transaction->receiver->balance + $transaction->amount);
        $this->accountService->updateAccountBalance($transaction->sender , $transaction->sender->balance - ($transaction->amount + $transaction->commission->amount));
    }

    private function createAccountHistory(Transaction $tr)
    {
        $this->accountService->storeHistoryForTransaction($tr);
    }
}
