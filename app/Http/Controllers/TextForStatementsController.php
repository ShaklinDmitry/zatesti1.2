<?php

namespace App\Http\Controllers;

use App\Domains\Text\SaveTextForStatementsCommand;
use App\Exceptions\TextForStatementsIsNullException;
use App\Http\Requests\TextForStatementsRequest;
use App\Jobs\MakeStatementsFromTextForUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class TextForStatementsController extends Controller
{
    /**
     * Функция, которая сохраняет текст
     * @param TextForStatementsRequest $request
     * @return JsonResponse
     */
    public function createText(TextForStatementsRequest $request):JsonResponse{

        try{
            $saveTextForStatements = new SaveTextForStatementsCommand();
            $textForStatements = $saveTextForStatements->execute(Auth::id(), $request->text);

            if($textForStatements){
                $responseData = [
                    "data" => [
                        "message" => "Text was added.",
                        "text_id" => $textForStatements->id
                    ]
                ];
            }

            return response() -> json($responseData,200);

        }catch (\Exception $exception){
            return response() -> json(["error" => ["message" => $exception->getMessage(),
            ]], $exception->getCode());
        }

    }

    /**
     * разделить текст на высказывания и записать в БД
     *
     * @return json
     */
    public function makeStatementsFromText(){

        try{
            MakeStatementsFromTextForUser::dispatch(Auth::id());

            $responseData = [
                "data" => [
                    "message" => "The text was divided into statements.",
                ]
            ];

            return response() -> json($responseData,200);

        }catch (TextForStatementsIsNullException $exception){

            return response() -> json(["error" => ["message" => $exception->getMessage(),
            ]],$exception->getCode());

        }
    }

}
