<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @OA\Schema(
 *     title="Car",
 *     description="Car model",
 *     @OA\Xml(
 *         name="Car"
 *     )
 * )
 */

class Car extends Model
{
    use HasFactory;

    /**
     * @OA\Property(
     *     title="id",
     *     description="id",
     *     format="int64",
     *     example=1
     * )
     *
     * @var bigInteger
     */
    private $id;
    /**
     * @OA\Property(
     *      title="Name",
     *      description="Название Машины",
     *      example="ford"
     * )
     *
     * @var string
     */
    private $name;





    protected $fillable = [
        'name',
    ];


    public function userRenter(){
        return $this->belongsToMany(User::class);
    }
}
