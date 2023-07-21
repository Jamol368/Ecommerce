<?php

namespace App\Observers;

use App\Models\CreditCard;

class CreditCardObserver
{
    /**
     * Handle the CreditCard "saving" event.
     *
     * @param CreditCard $creditCard
     * @return void
     */
    public function saving(CreditCard $creditCard): void
    {
        if ($creditCard->main && auth()->user()->getAuthIdentifier()) {
            CreditCard::where(['user_id' => $creditCard->user->id])->update(['main' => false]);
        }

        if (strlen($creditCard->expiration_month)<2) {
            $creditCard->expiration_month = '0'.$creditCard->expiration_month;
        }
    }
}
