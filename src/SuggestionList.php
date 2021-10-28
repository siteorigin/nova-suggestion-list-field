<?php

namespace Siteorigin\NovaSuggestionList;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;

class SuggestionList extends Field
{
    public $component = 'nova-suggestion-list';

    public function autorefresh(bool $autorefresh = true): SuggestionList
    {
        $this->withMeta(['autorefresh' => $autorefresh]);
        return $this;
    }

    public function suggesterOptions(array $options): SuggestionList
    {
        $this->withMeta(['suggesterOptions' => $options]);
        return $this;
    }

    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute)
    {
        if ($request->exists($requestAttribute)) {
            $value = $request[$requestAttribute];

            $model->{$attribute} = $this->isNullValue($value)
                ? null
                : json_decode($value, true);
        }
    }
}
