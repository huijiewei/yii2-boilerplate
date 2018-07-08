<?php
/**
 * Created by PhpStorm.
 * User: Huijiewei
 * Date: 2018/7/6
 * Time: 下午4:33
 */

/**
 * @SWG\Swagger(
 *  schemes={"http"},
 *  host=API_HOST,
 *  basePath=API_BASE_PATH,
 *  produces={"application/json"},
 *  consumes={"application/json"},
 *  security={{
 *     "AdminSecurity":{}
 *   }},
 *   @SWG\Info(
 *     title="Boilerplate 管理员 API",
 *     description="欢迎使用 Boilerplate 管理员 API",
 *     version="1.0.0"
 *   )
 * )
 */

/**
 * @SWG\SecurityScheme(
 *   securityDefinition="AdminSecurity",
 *   type="apiKey",
 *   in="header",
 *   name="ADMIN-ACCESS-TOKEN",
 *   description="管理员认证令牌"
 * )
 */

/**
 * @SWG\Tag(
 *   name="auth",
 *   description="用户认证相关 API"
 * )
 */
