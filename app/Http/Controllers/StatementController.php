<?php

namespace App\Http\Controllers;

use App\Models\Statement;
use Illuminate\Http\Request;

class StatementController extends Controller
{

    /**
     * создать новое высказывание
     * @return json
     */
    public function createStatement(Request $request){
        $statement = new Statement();
        $result = $statement->add($request);

        if($result){
            $responseData = [
                "data" => [
                    "message" => "Statement was create successfull.",
                ]
            ];

            return response() -> json($responseData, 201);
        }else{
            $responseData = [
                "error" => [
                    "message" => "Statement not created"
                ]
            ];
            return response() -> json($responseData,200);
        }
    }


    /**
     * получить все высказывания
     * @return void
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
}
