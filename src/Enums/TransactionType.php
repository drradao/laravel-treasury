<?php

namespace DRRAdao\LaravelTreasury\Enums;

enum TransactionType: string
{
    case Credit = 'credit';
    case Debit = 'debit';
}
