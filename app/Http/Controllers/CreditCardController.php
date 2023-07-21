<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditCardRequest;
use App\Http\Requests\UpdateCreditCardRequest;
use App\Models\CreditCard;

class CreditCardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(CreditCard::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCreditCardRequest $request)
    {
        $model = new CreditCard($request->toArray());
        return response()->json($model->save());
    }

    /**
     * Display the specified resource.
     */
    public function show(CreditCard $creditCard)
    {
        return response()->json($creditCard);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCreditCardRequest $request, CreditCard $creditCard)
    {
        return $creditCard->fill($request->toArray())->isDirty() && $creditCard->update();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CreditCard $creditCard)
    {
        return response()->json($creditCard->delete());
    }
}
