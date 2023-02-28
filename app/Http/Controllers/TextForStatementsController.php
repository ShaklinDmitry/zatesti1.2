<?php

namespace App\Http\Controllers;

use App\Exceptions\TextForStatementsIsNullException;
use App\Http\Requests\TextForStatementsRequest;
use App\Jobs\MakeStatements;
use App\Models\Statement;
use App\Models\TextForStatements;
use App\Services\StatementService;
use App\Services\TextForStatementsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
            $textForStatementsService = new TextForStatementsService();
            $textForStatements = $textForStatementsService->addText($request->text, Auth::id());

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
    public function makeStatementsFromText(TextForStatementsService $textForStatementsService, StatementService $statementService){

        try{
            MakeStatements::dispatch(Auth::id());

            $responseData = [
                "data" => [
                    "message" => "The text was divided into statements.",
                ]
            ];

            return response() -> json($responseData,200);

        }catch (\TextForStatementsIsNullException $e){

            echo $e->getMessage();

        }
    }

}
