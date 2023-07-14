<?php

namespace Nrz\Account\Database\Repo\Mysql;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Nrz\Account\Exceptions\CreateAccountException;
use Nrz\Account\Models\Account;

class MysqlAccountRepo implements \Nrz\Account\Contracts\AccountProviderInterface
{

    /**
     * @throws CreateAccountException
     */
    public function createNewAccount(array $data): \Nrz\Account\Models\Account
    {
        try {
            DB::beginTransaction();
            $ac = Account::query()->create($data);
            DB::commit();
            return $ac;
        }catch (\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());
            throw new CreateAccountException(__("message.internal-server-error"),500);
        }
    }


    /**
     * @throws CreateAccountException
     */
    public function checkAccountNumberIsExist(float|int|string $number): bool
    {
        try {
            return !!Account::query()->where("account_number", $number)
                ->first();
        }catch (\Exception $e){
            Log::error($e->getMessage());
            throw new CreateAccountException(__("message.internal-server-error"),500);
        }
    }

    public function updateAccountBalance(Account $account, float|int $newBalance)
    {
        $account->updateBalance($newBalance);
    }
}
