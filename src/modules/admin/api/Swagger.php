<?php

/**
 * Created by PhpStorm.
 * User: Huijiewei
 * Date: 2018/7/6
 * Time: 下午4:33
 */

/**
 * @OA\OpenApi(
 *   @OA\Info(
 *     title="Boilerplate 管理员 API",
 *     description="欢迎使用 Boilerplate 管理员 API",
 *     version="v1"
 *   )
 * )
 */

/**
 * @OA\SecurityScheme(
 *   securityScheme="api_key",
 *   type="apiKey",
 *   in="header",
 *   name="ACCESS-TOKEN",
 *   description="管理员认证令牌"
 * )
 */

/**
 * @OA\Tag(
 *   name="auth",
 *   description="用户认证相关 API"
 * )
 */
