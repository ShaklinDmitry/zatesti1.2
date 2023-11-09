<?php

namespace App\Modules\Statements\Infrastructure\Controllers;

use App\Modules\Statements\AddStatementCommand;
use App\Modules\Statements\Application\UseCases\CreateStatementCommand;
use App\Modules\Statements\Application\UseCases\GetStatementsUseCase;
use App\Modules\Statements\GetStatementsCommand;
use App\Modules\Statements\Infrastructure\Repositories\StatementRepository;
use App\Exceptions\NoStatementsException;
use App\Http\Controllers\Controller;
use App\Http\Controllers\json;
use App\Http\Requests\CreateStatementRequest;
use App\Models\BestStatementEloquent;
use App\Models\StatementEloquent;
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
//    public function createStatement(CreateStatementRequest $request):JsonResponse{
//
//        try{
//
//            $createStatementUseCase = new CreateStatementCommand(userId: Auth::id(), text: $request->text);
//            $statement = $createStatementUseCase->execute();
//
//            if($statement){
//                return response() -> json(["data" => ["message" => "StatementEloquent was create successfull.",
//                ]],200);
//            }
//        }catch(\Exception $exception){
//            return response() -> json(["error" => ["message" => $exception->getMessage(),
//            ]],$exception->getCode());
//        }
//    }


    /**
     * Получить все высказывания у конкретного пользователя
     * @return JsonResponse
     */
    public function getStatements():JsonResponse{

        try{
            $statementRepository = new StatementRepository();

            $getStatementUseCase = new GetStatementsUseCase(Auth::id(), $statementRepository);
            $statements = $getStatementUseCase->execute();

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
        $delete = StatementEloquent::destroy($request->id);

        if($delete){
            return response() -> json(["data" => ["message" => "StatementEloquent was deleted."]], 200);
        }
    }

    /**
     * Функция для перевода высказываний в тип "лучших"
     * @param Request $request
     * @return JsonResponse|void
     */
    public function transferToBestStatements(Request $request){
        $statement = StatementEloquent::find($request->statementId);

        $bestStatement = BestStatementEloquent::create([
            'user_id' => $statement->user_id,
            'text' => $statement->text
        ]);

        if($bestStatement){
            return response() -> json(["data" => ["message" => 'StatementEloquent ' . $statement->id . ' was transfered to best statements']], 200);
        }
    }

}
