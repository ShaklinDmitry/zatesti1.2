<?php

namespace App\Http\Controllers;

use App\classes\Statements\AddStatementCommand;
use App\classes\Statements\GetStatementsCommand;
use App\Exceptions\NoStatementsException;
use App\Http\Requests\CreateStatementRequest;
use App\Models\BestStatement;
use App\Models\Statement;
use App\Services\TextForStatementsService;
use App\Services\UserResponseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatementController extends Controller
{

    /**
     * функция для создания высказывания
     * @param CreateStatementRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createStatement(CreateStatementRequest $request):JsonResponse{

        try{
            $addStatementCommand = new AddStatementCommand();
            $statement = $addStatementCommand->execute($request->text, Auth::id());

            if($statement){
                return response() -> json(["data" => ["message" => "Statement was create successfull.",
                ]],200);
            }
        }catch(\Exception $exception){
            return response() -> json(["error" => ["message" => $exception->getMessage(),
            ]],$exception->getCode());
        }
    }


    /**
     * Получить все высказывания у конкретного пользователя
     * @return JsonResponse
     */
    public function getStatements():JsonResponse{

        try{
            $getStatementsCommand = new GetStatementsCommand();
            $statements = $getStatementsCommand->execute(Auth::id());

            $responseData = [
                "data" => [
                    "statements" => $statements
                ]
            ];

            return response() -> json($responseData,200);

        }catch(NoStatementsException $exception){

            return response() -> json([
                "error" => [
                    "message" => $exception->getMessage()
                ]
            ], $exception->getCode());

        }catch (\Exception $exception){
            return response() -> json(["error" => ["message" => $exception->getMessage(),
            ]], $exception->getCode());
        }
    }


    /**
     * Удалить высказывание
     *
     * @return json
     */
    public function destroy(Request $request){
        $delete = Statement::destroy($request->id);

        if($delete){
            return response() -> json(["data" => ["message" => "Statement was deleted."]], 200);
        }
    }

    /**
     * Функция для перевода высказываний в тип "лучших"
     * @param Request $request
     * @return JsonResponse|void
     */
    public function transferToBestStatements(Request $request){
        $statement = Statement::find($request->statementId);

        $bestStatement = BestStatement::create([
            'user_id' => $statement->user_id,
            'text' => $statement->text
        ]);

        if($bestStatement){
            return response() -> json(["data" => ["message" => 'Statement ' . $statement->id . ' was transfered to best statements']], 200);
        }
    }

}
