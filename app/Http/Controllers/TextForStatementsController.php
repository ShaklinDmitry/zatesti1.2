<?php

namespace App\Http\Controllers;

use App\Exceptions\TextForStatementsIsNullException;
use App\Http\Requests\TextForStatementsRequest;
use App\Jobs\MakeStatements;
use App\Models\Statement;
use App\Models\TextForStatements;
use App\Services\StatementService;
use App\Services\TextForStatementsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TextForStatementsController extends Controller
{
    /**
     * Функция, которая сохраняет текст
     *
     * @return json
     */
    public function createText(TextForStatementsRequest $request, TextForStatementsService $textService){

        $text = $textService->addText($request->text, Auth::id());

        if($text != null){
            $responseData = [
                "data" => [
                    "message" => "Text was added.",
                    "text_id" => $text->id
                ]
            ];
        }else{
            $responseData = [
                "error" => [
                    "message" => "Text was not added."
                ]
            ];
        }

        return response() -> json($responseData,200);

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
