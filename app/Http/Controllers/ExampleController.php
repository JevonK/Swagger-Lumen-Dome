<?php

namespace App\Http\Controllers;

use App\Http\Responses\DemoResp;
use App\Http\Responses\DemoAdditionalProperty;
use Illuminate\Http\Request;
use OpenApi\Annotations\Get;
use OpenApi\Annotations\MediaType;
use OpenApi\Annotations\Property;
use OpenApi\Annotations\RequestBody;
use OpenApi\Annotations\Response;
use OpenApi\Annotations\Schema;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * @Get(
     *     path="/demo",
     *     tags={"演示"},
     *     summary="演示API",
     *     @RequestBody(
     *         @MediaType(
     *             mediaType="application/json",
     *             @Schema(
     *                 required={"name", "age"},
     *                 @Property(property="name", type="string", description="姓名"),
     *                 @Property(property="age", type="integer", description="年龄"),
     *                 @Property(property="gender", type="string", description="性别")
     *             )
     *         )
     *     ),
     *     @Response(
     *         response="200",
     *         description="正常操作响应",
     *         @MediaType(
     *             mediaType="application/json",
     *             @Schema(
     *                 allOf={
     *                     @Schema(ref="#/components/schemas/ApiResponse"),
     *                     @Schema(
     *                         type="object",
     *                         @Property(property="data", ref="#/components/schemas/DemoResp")
     *                     )
     *                 }
     *             )
     *         )
     *     )
     * )
     *
     * @param Request $request
     *
     * @return DemoResp
     */
    public function hello(Request $request) {
        $resp         = new DemoResp();
        $resp->name   = $request->input('name', 'zhang');
        $resp->id     = 123;
        $resp->age    = $request->input('age', '11');
        $resp->gender = $request->input('gender', '男');

        $prop1        = new DemoAdditionalProperty();
        $prop1->key   = "foo";
        $prop1->value = "bar";

        $prop2        = new DemoAdditionalProperty();
        $prop2->key   = "foo2";
        $prop2->value = "bar2";

        $resp->properties = [$prop1, $prop2];
        return response()->json($resp);
    }
}
