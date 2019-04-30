<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.04.2019
 * Time: 12:23
 */

namespace App\Controllers;

use App\Exceptions\Exception;
use App\Requests\Kes\AppInfoRequest;
use App\Requests\Kes\ScanFileRequest;
use App\Responses\Response;

class KesController extends Controller
{
    /**
     * @OA\Get(
     *     path="/kes/app-info",
     *     tags={"Kaspersy endpoint security"},
     *     summary="Get app info",
     *     operationId="kesAppInfo",
     *     @OA\Response(
     *      response=200,
     *      description="successful operation",
     *      @OA\JsonContent(ref="#/components/schemas/AppInfoModel"),
     *      @OA\XmlContent(ref="#/components/schemas/AppInfoModel")
     *     )
     * )
     */
    final public function appInfo(): void
    {
        $response = (new AppInfoRequest())
            ->execute();

        (new Response())
            ->setCode(Response::OK)
            ->json($response);
    }

    /**
     * @OA\Post(
     *     path="/kes/scan-file",
     *     tags={"Kaspersy endpoint security"},
     *     summary="Scan file",
     *     operationId="kesScanFile",
     *     @OA\RequestBody(
     *      required=true,
     *      @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema(
     *              @OA\Property(
     *                  description="file to upload",
     *                  property="file",
     *                  type="file",
     *                  format="file",
     *              ),
     *              required={"file"}
     *          )
     *      )
     *     ),
     *     @OA\Response(
     *      response=200,
     *      description="successful operation",
     *      @OA\JsonContent(ref="#/components/schemas/ScanFileModel"),
     *      @OA\XmlContent(ref="#/components/schemas/ScanFileModel")
     *     ),
     *     @OA\Response(
     *      response=405,
     *      description="validation exception",
     *      @OA\JsonContent(ref="#/components/schemas/Exception"),
     *      @OA\XmlContent(ref="#/components/schemas/Exception")
     *     )
     * )
     */
    final public function scanFile(): void
    {
        try {
            $response = (new ScanFileRequest())
                ->execute();
            (new Response())
                ->setCode(Response::OK)
                ->json($response);
        } catch (Exception $exception){
            $exception->render();
        }
    }
}