<?php

namespace App\Modules\Text\Infrastructure\Controllers;

use App\Modules\Text\Application\UseCases\SaveTextForStatementsCommand;
use App\Modules\Text\Infrastructure\Jobs\MakeStatementsFromText;
use App\Modules\Text\Infrastructure\Repositories\TextForStatementsRepository;
use App\Modules\Text\Infrastructure\Requests\TextForStatementsRequest;
use App\Exceptions\TextForStatementsIsNullException;
use App\Http\Controllers\Controller;
use App\Http\Controllers\json;
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

            $textForStatementsRepository = new TextForStatementsRepository();

            $saveTextForStatementsUseCase = new SaveTextForStatementsCommand(userId: Auth::id(), text: $request->text, textForStatementsRepository: $textForStatementsRepository);
            $textForStatements = $saveTextForStatementsUseCase->execute();

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

            MakeStatementsFromText::dispatch(Auth::id());

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
