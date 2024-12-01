<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;

interface MainInterface {

    public static function fromApiFormRequest(FormRequest $request);
    public static function fromModel(Model $model);
    public static function toArray(Model $model);
}