<?php

namespace Nrz\Transaction\Enums;

enum TransactionTypeEnum :string
{
    case TRANSACTION = "transaction";
    case BANK_COMMISSION='bank_commission';
}
