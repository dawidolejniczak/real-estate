<?php

namespace App\Http\Controllers;

use App\Exceptions\MissingFieldException;
use App\Exceptions\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param \Exception $exception
     * @return JsonResponse
     */
    protected function respondWithException(\Exception $exception): JsonResponse
    {
        return response()->json([
            'status' => $exception->getCode(),
            'message' => $exception->getMessage(),
        ], 400);
    }

    /**
     * @param Validator $validator
     * @throws MissingFieldException
     * @throws ValidationException
     */
    protected function checkValidation(Validator $validator): void
    {
        if ($validator->fails()) {
            $required = $messages = [];
            $validatorMessages = $validator->errors()->toArray();
            foreach ($validatorMessages as $field => $message) {
                if (strpos($message[0], 'required')) {
                    $required[] = $field;
                }

                foreach ($message as $error) {
                    $messages[] = $error;
                }
            }

            if (count($required) > 0) {
                $fields = implode(', ', $required);
                $message = "Missing required fields: $fields";

                throw new MissingFieldException($message);
            }

            throw new ValidationException(implode(', ', $messages));
        }
    }
}
