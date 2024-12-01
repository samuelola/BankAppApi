<?php

namespace App\Services;

use App\Exceptions\ANotFountException;
use App\Interfaces\TransferServiceInterface;
use App\Repositories\TransferRepository;
use App\Models\Transfer;

class TransferService implements TransferServiceInterface 
{

    public function modelQuery()
    {
       return Transfer::query();
    }

    public function generateReference()
    {
        return Str::upper('TF'. '/' . Carbon::now()->getTimestampMs() . '/' . Str::random(4));
    }

    public function createTransfer($transferRepo)
    {    
        $transferRepository = new TransferRepository(); 
        $data = [];
        $data = $transferRepository->forTransferToArray($transferRepo);
        $transfer = $this->modelQuery()->create($data);
        return $transfer;
    }

    public function getTransferById(int $transferId)
    {
        $transfer = $this->modelQuery()->where('id', $transferId)->first();
        if(!$transfer){
            throw new ANotFoundException("Transfer not found");
        }
        return $transfer;
    }

    public function getTransferByReference(string $reference)
    {
        $transfer = $this->modelQuery()->where('reference', $reference)->first();
        if(!$transfer){
            throw new ANotFoundException("Transfer not found with this reference");
        }
        return $transfer;
    }
}