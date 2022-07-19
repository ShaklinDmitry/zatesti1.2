<?php

namespace App\Http\Controllers;

use App\Models\Statement;
use App\Models\TextForStatements;
use App\Services\TextForStatementsService;
use Illuminate\Http\Request;

class TextForStatementsController extends Controller
{
    /**
     * Функция, которая получает  и сохраняет текст, который дальше парсится в высказывания
     *
     * @return void
     */
    public function createText(Request $request){
        $textForParsing = new TextForStatements();

        $result = $textForParsing->addText($request->text);

        if($result){
            $responseData = [
                "data" => [
                    "message" => "Text was added.",
                ]
            ];

            return response() -> json($responseData, 200);
        }else{
            $responseData = [
                "error" => [
                    "message" => "Text was not added."
                ]
            ];
            return response() -> json($responseData,200);
        }
    }

    /**
     * разделить текст на высказывания и записать в БД
     *
     * @return mixed
     */
    public function splitTextIntoStatements(){
        $textForStatementsService = new TextForStatementsService();
        $statements = $textForStatementsService->getStatements();


        foreach ($statements as $text){
            $statement = new Statement();
            $statement->add($text);
        }

        $responseData = [
            "data" => [
                "message" => "The text was divided into sentences.",
            ]
        ];

        return response() -> json($responseData,200);
    }

}
