<?php

namespace App;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Translation",
 *     type="object",
 *     required={"key", "content", "locale"},
 *     @OA\Property(property="key", type="string", example="example_key"),
 *     @OA\Property(property="content", type="string", example="This is an example translation."),
 *     @OA\Property(property="locale", type="string", example="en"),
 *     @OA\Property(property="tag", type="string", example="example_tag"),
 * )
 */
class Schemas
{
    // This class can be empty; its purpose is to hold the annotations.
}
