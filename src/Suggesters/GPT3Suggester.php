<?php

namespace Siteorigin\NovaSuggestionList\Suggesters;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Siteorigin\NovaSuggestionList\Contracts\Suggester;

class GPT3Suggester implements Suggester
{
    protected array $options = [];

    /**
     * @todo replace it with GPT-3
     */
    public function apply(Collection $items): Collection
    {
        return $items->map(fn($item) => Str::random());
    }

    public function setOptions(array $options): Suggester
    {
        $this->options = $options;

        return $this;
    }
}
