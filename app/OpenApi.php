<?php

namespace App;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="My API",
 *     version="1.0.0",
 *     description="This is a sample API documentation.",
 *     @OA\Contact(
 *         name="API Support",
 *         url="http://www.example.com/support",
 *         email="support@example.com"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 */
class OpenApi
{
    // This class can be empty; its purpose is to hold the annotations.
}
