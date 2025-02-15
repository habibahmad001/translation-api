<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Translation;
use OpenApi\Annotations as OA;
use Illuminate\Support\Facades\DB;

/**
 * @OA\SecurityScheme(
 *     securityScheme="passport",
 *     type="oauth2",
 *     @OA\Flow(
 *         flow="password",
 *         tokenUrl="/oauth/token",
 *         refreshUrl="/oauth/token/refresh",
 *         scopes={}
 *     )
 * )
 */

/**
 * @OA\Schema(
 *     schema="TranslationRequest",
 *     type="object",
 *     required={"key", "content", "locale"},
 *     @OA\Property(property="key", type="string", example="example_key"),
 *     @OA\Property(property="content", type="string", example="This is an example translation."),
 *     @OA\Property(property="locale", type="string", example="en"),
 *     @OA\Property(property="tag", type="string", example="example_tag"),
 * )
 */
class TranslationController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/translations",
     *     security={{"passport": {}}},
     *     summary="Get all translations",
     *     @OA\Parameter(
     *         name="tag",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="locale",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="key",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="A list of translations",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Translation")
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = Translation::select(['key', 'content', 'locale', 'tag', 'created_at', 'updated_at'])->orderByDesc("id");

        if ($request->has('tag')) {
            $query->where('tag', $request->tag);
        }
        if ($request->has('locale')) {
            $query->where('locale', $request->locale);
        }
        if ($request->has('key')) {
            $query->where('key', 'like', "%{$request->key}%");
        }

        return response()->json($query->paginate(50));
    }

    /**
     * @OA\Post(
     *     path="/api/translations",
     *     summary="Create a new translation",
     *     tags={"Translations"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TranslationRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Translation created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="key", type="string", example="example_key"),
     *             @OA\Property(property="content", type="string", example="This is an example translation."),
     *             @OA\Property(property="locale", type="string", example="en"),
     *             @OA\Property(property="tag", type="string", example="example_tag"),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01T00:00:00Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01T00:00:00Z"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="object")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|string|unique:translations,key',
            'content' => 'required|string',
            'locale' => 'required|string',
            'tag' => 'nullable|string',
        ]);

        $translation = Translation::create($request->all());

        return response()->json($translation, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/translations/{id}",
     *     security={{"passport": {}}},
     *     summary="Update a translation",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TranslationRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Translation updated",
     *         @OA\JsonContent(ref="#/components/schemas/Translation")
     *     )
     * )
     */
    public function update(Request $request, Translation $translation)
    {
        // Validate the incoming request
        $request->validate([
            'content' => 'required|string',
        ]);

        // Prepare the data to be updated
        $udata = [];

        if ($request->has('tag')) {
            $udata['tag'] = $request->tag; // Use associative array
        }
        if ($request->has('locale')) {
            $udata['locale'] = $request->locale; // Use associative array
        }
        if ($request->has('key')) {
            $udata['key'] = $request->key; // Use associative array
        }
        if ($request->has('content')) {
            $udata['content'] = $request->content; // Use associative array
        }

        // Update the translation instance with the new data
        $translation->update($udata);

        // Return the updated translation as a JSON response
        return response()->json($translation);
    }

    /**
     * @OA\Delete(
     *     path="/api/translations/{id}",
     *     security={{"passport": {}}},
     *     summary="Delete a translation",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Translation deleted"
     *     )
     * )
     */
    public function destroy(Translation $translation)
    {
        $translation->delete();

        return response()->json(['message' => 'Translation deleted'], 204);
    }

    /**
     * @OA\Get(
     *     path="/api/translations/export",
     *     security={{"passport": {}}},
     *     summary="Export all translations grouped by locale",
     *     @OA\Response(
     *         response=200,
     *         description="Translations exported",
     *         @OA\JsonContent(
     *             type="object",
     *             additionalProperties={
     *                 "type": "array",
     *                 "items": {
     *                     "$ref": "#/components/schemas/Translation"
     *                 }
     *             }
     *         )
     *     )
     * )
     */
//    public function export()
//    {
//        $translations = Translation::all()->groupBy('locale');
//
//        return response()->json($translations);
//    }

    public function export()
    {
        $translations = DB::table('translations')
            ->select('id', 'key', 'content', 'locale', 'tag', 'created_at', 'updated_at')
            ->get()
            ->groupBy('locale');

        return response()->json($translations);
    }
}
