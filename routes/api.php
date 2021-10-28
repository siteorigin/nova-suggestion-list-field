<?php

use Siteorigin\NovaSuggestionList\Http\Controllers\SuggestionListController;

Route::post('suggestions', [SuggestionListController::class, 'index']);
