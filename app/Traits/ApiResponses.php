<?php

namespace App\Traits;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

trait ApiResponses
{


    public function Data($data, $code = 200): \Illuminate\Http\JsonResponse
    {
        DB::commit();
        return $this->FinalResponse($data, $code);
    }

    public function Success($message, $code = 200): \Illuminate\Http\JsonResponse
    {
        DB::commit();
        return $this->FinalResponse(['message' => $message], $code);
    }

    public function Error($error, $code = 402): \Illuminate\Http\JsonResponse
    {
        DB::rollBack();
        return $this->FinalResponse(['error' => $error], $code);
    }

    public function ValidationError($error, $code = 422): \Illuminate\Http\JsonResponse
    {
        DB::rollBack();
        return $this->FinalResponse([
            "message" => "The given data was invalid.",
            "errors" => $error], $code);

    }

    public function FinalResponse($data, $code): \Illuminate\Http\JsonResponse
    {
        return response()->json($data, $code);
    }
}
