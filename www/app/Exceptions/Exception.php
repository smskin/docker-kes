<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.04.2019
 * Time: 15:11
 */

namespace App\Exceptions;

use App\Responses\Response;
use \Exception as BaseException;

/**
 * Class Exception
 *
 * @OA\Schema(
 *     title="Exception",
 *     description="Exception model",
 * )
 */
class Exception extends BaseException
{
    /**
     * @OA\Property(
     *     title="message",
     *     description="Exception message"
     * )
     *
     * @var string
     */
    protected $message;

    final public function render(): void
    {
        (new Response())
            ->setCode($this->code)
            ->json((object)[
                'message'=>$this->message
            ]);
    }
}