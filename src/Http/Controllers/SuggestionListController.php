<?php

namespace Siteorigin\NovaSuggestionList\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Routing\Controller;
use Siteorigin\NovaSuggestionList\Contracts\Suggester;

class SuggestionListController extends Controller
{
    public function index(NovaRequest $request, Suggester $suggester): JsonResponse
    {
        $options = (array) $request->input('options');
        $values = collect($request->input('value'));

        $suggestions = $suggester->setOptions($options)->apply($values);

        return response()->json([
            'suggestions' => $suggestions
        ]);
    }
}
