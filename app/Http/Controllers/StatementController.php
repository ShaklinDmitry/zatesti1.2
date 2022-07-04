<?php

namespace App\Http\Controllers;

use App\Models\Statement;
use App\Models\TextForParsingIntoStatements;
use Illuminate\Http\Request;

class StatementController extends Controller
{

    /**
     * создать новое высказывание
     * @return json
     */
    public function createStatement(Request $request){

        $statement = new Statement();

        if(empty($request->text)){
            $createStatementResult = false;
        }else{
            $createStatementResult = $statement->add($request->text);
        }

        if($createStatementResult){
            $responseData = [
                "data" => [
                    "message" => "Statement was create successfull.",
                ]
            ];

            return response() -> json($responseData, 201);
        }else{
            $responseData = [
                "error" => [
                    "message" => "Statement not created."
                ]
            ];
            return response() -> json($responseData,200);
        }
    }


    /**
     * получить все высказывания
     * @return json
     */
    public function getStatements(){
        $statement = new Statement();

        $statements = $statement->getAll();

        $response = [
            "data" => [
                "statements" => $statements
            ]
        ];

        return $response;
    }


    /**
     * Удалить высказывание
     *
     * @return json
     */
    public function deleteStatement(Request $request){
        $statement = new Statement();

        $result = $statement->deleteItem($request->id);

        if($result){
            $responseData = [
                "data" => [
                    "message" => "Statement was deleted.",
                ]
            ];

            return response() -> json($responseData, 200);
        }else{
            $responseData = [
                "error" => [
                    "message" => "Statement not deleted."
                ]
            ];
            return response() -> json($responseData,200);
        }

    }

    /**
     * Функция, которая получает текст, который дальше парсится в высказывания
     *
     * @return void
     */
    public function createTextForParsingIntoStatements(Request $request){
            $textForParsing = new TextForParsingIntoStatements();

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

}
