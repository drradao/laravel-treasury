<?php

namespace Drradao\LaravelTreasury\Enums;

enum TransactionType: string
{
    case Credit = 'credit';
    case Debit = 'debit';
}
