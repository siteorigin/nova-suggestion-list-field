<?php

namespace Siteorigin\NovaSuggestionList\Contracts;

use Illuminate\Support\Collection;

interface Suggester
{
    /**
     * Apply the suggester to the given string collection.
     *
     * @param  Collection  $items  String collection
     * @return Collection Returns Collection of suggested items
     */
    public function apply(Collection $items): Collection;

    /**
     * Configuring options for Suggester.
     *
     * @param  array  $options
     * @return Suggester
     */
    public function setOptions(array $options): Suggester;
}
