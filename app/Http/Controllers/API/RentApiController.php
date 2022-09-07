<?php /** @noinspection ALL */

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Resources\UserResource;
use App\Models\Car;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class RentApiController extends AppBaseController
{
    /**
     * * @OA\Get(
     *      path="/api/getusers",
     *      operationId="getUserAll",
     *      tags={"Users"},
     *      summary="Получить список всех пользователей",
     *      description="Получаем список всех доступных пользователей",
     *     @OA\Response(
     *         response=200,
     *          description="successful operation",
     *     @OA\JsonContent(ref="#/components/schemas/User")
     *       ),
     *
     *     )
     */
    public function getUserAll(): JsonResponse
    {

        $users = User::with('carRent')->get();

        return $this->sendResponse(UserResource::collection($users), 'Users successfully');
    }

    /**
     * @OA\Get(
     *      path="/api/getuser/{id}",
     *      operationId="getUser",
     *      tags={"Users"},
     *      summary="Получение Пользователя и арендованнной машины , если есть",
     *      description="Метод возвращает данные ...",
     *     @OA\Parameter(
     *          name="id",
     *          description="id пользователя",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          )
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *     @OA\JsonContent(ref="#/components/schemas/User")
     *       ),
     *     @OA\Response(
     *          response=404,
     *          description="Пользователя нет",
     *     )
     * )
     */

    public function getUser($id): JsonResponse
    {
        $user = User::with('carRent')->find($id);

        if (!$user) {
            return $this->sendError('Пользователя нет', '404');
        }

        return $this->sendResponse(new UserResource($user), 'User successfully');

    }
    /**
     * @OA\Post(
     *      path="/api/user/setRent",
     *      operationId="addRentCar",
     *      tags={"Users"},
     *      summary="Аренда машины пользователем",
     *      description="Метод возвращает данные ...",
     *     @OA\Parameter(
     *          name="user_id",
     *          description="id пользователя",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="car_id",
     *          description="id машины",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          )
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *       ),
     *     @OA\Response(
     *          response=531,
     *          description="У пользователя уже есть машина",
     *     ),
     *      @OA\Response(
     *          response=532,
     *          description="Эта машина уже арендована",
     *     ),
     *      * @OA\Response(
     *          response=404,
     *          description="такого пользователя или машины нет",
     *     )
     *
     * )
     */

    public function addRentCar(Request $request): JsonResponse
    {
        $user_id = $request->user_id;
        $car_id = $request->car_id;
        $user = User::withCount('carRent')->find($user_id);
        $car = Car::withCount('userRenter')->find($car_id);

        if (!$user) {
            return $this->sendError('такого Пользователя нет', '404');
        }
        if (!$car) {
            return $this->sendError('такой машины нет', '404');
        }
        if ($user->car_rent_count !== 0) {
            return $this->sendError('У пользователя уже есть машина', '531');
        }
        if ($car->user_renter_count !== 0) {
            return $this->sendError('Эта машина уже арендована', '532');
        }
        $user->carRent()->attach($car_id);
        $user->refresh();
        return $this->sendResponse(new UserResource($user), 'User Rent Car successfully');
    }
    /**
     * @OA\Post(
     *      path="/api/user/delRent",
     *      operationId="delRentCar",
     *      tags={"Users"},
     *      summary="удаляет Аренду машины у пользователем",
     *      description="Метод возвращает данные ...",
     *     @OA\Parameter(
     *          name="user_id",
     *          description="id пользователя",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          )
     *      ),
     *
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *       ),
     *      @OA\Response(
     *          response=500,
     *          description="У пользователя нет машины",
     *     ),
     *      * @OA\Response(
     *          response=404,
     *          description="такого пользователя или машины нет",
     *     )
     *
     * )
     */
    public function delRentCar(Request $request): JsonResponse
    {
        $user_id = $request->user_id;
        $user = User::withCount('carRent')->find($user_id);
        if (!$user) {
            return $this->sendError('Пользователя нет', '404');
        }
        if ($user->car_rent_count == 0) {
            return $this->sendError('У пользователя нет машины', '500');
        }

        $user->carRent()->detach();
        $user->refresh();
        return $this->sendResponse(new UserResource($user), 'User not Rent Car successfully');
    }


    /**
     * * @OA\Get(
     *      path="/api/getcars",
     *      operationId="getCarAll",
     *     tags={"Cars"},
     *      summary="Получить список всех доступных Машин",
     *      description="Получаем список всех доступных Машин",
     *     @OA\Response(
     *         response=200,
     *          description="successful operation",
     *     @OA\JsonContent(ref="#/components/schemas/Car")
     *       ),
     *
     *     )
     */

    public function getCarAll(): \Illuminate\Http\JsonResponse
    {

        $cars = Car::with('userRenter')->get();

        return $this->sendResponse(new CarsResource($cars), 'Cars successfully');
    }
    /**
     * @OA\Get(
     *      path="/api/getcar/{id}",
     *      operationId="getCar",
     *      tags={"Cars"},
     *      summary="Получение  машины и арендатора , если есть",
     *      description="Метод возвращает данные ...",
     *     @OA\Parameter(
     *          name="id",
     *          description="id машиныя",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          )
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *     @OA\JsonContent(ref="#/components/schemas/User")
     *       ),
     *     @OA\Response(
     *          response=404,
     *          description="Такой машины нет",
     *     )
     * )
     */
    public function getCar($id)
    {
        $car = Car::with('userRenter')->find($id);
        if (!$car) {
            return $this->sendError('Такой машины нет', '404');
        }
        return $this->sendResponse(new CarResource($user), 'Car successfully');

    }

}
