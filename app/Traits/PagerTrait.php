<?php

namespace App\Traits;

trait PagerTrait
{
    /**
     * Call laravel pagination
     *
     * @param QueryBuilder $query
     * @return Illuminate\Pagination\Paginator
     */
    public function pager($query)
    {
        $request = request();

        $rpp = 20;

        if ($request->filled('rpp')) {
            $rpp = intval($request->input('rpp'));
        }

        if ($request->filled('query')) {
            $query = $this->buildQuery($query);
        }

        if ($request->filled('sort')) {
            $query = $this->buildSorting($query);
        }
        if ($request->filled('paginate') && ! $request->input('paginate')) {
            return $query->get();
        }
        return $query->paginate($rpp);
    }

    public function buildQuery($query)
    {
        $request = request();

        $fragments = explode(':', $request->input('query'));
        $fragmentsCount = count($fragments);

        if ($fragmentsCount < 2 || $fragmentsCount > 3) {
            throw new \Exception("Invalid format for parameter query");
        }

        if (count($fragments) == 2) {
            return $query->where($fragments[0], $fragments[1]);
        }

        if ($fragments[1] == 'like') {
            return $query->where($fragments[0], 'like', "%{$fragments[2]}%");
        }

        return $query->where($fragments[0], $fragments[1], $fragments[2]);
    }

    public function buildSorting($query)
    {
        $request = request();

        $fragments = explode(':', $request->input('sort'));

        if (count($fragments) !== 2) {
            throw new \Exception("Invalid format for parameter sort");
        }

        $field = $fragments[0];
        $direction = $fragments[1];

        $excludeListExists = property_exists($this, 'excludeFromSort');
        $shouldSkipSort = $excludeListExists && in_array($field, $this->excludeFromSort);

        if ($shouldSkipSort) {
            return $query;
        }

        if (property_exists($this, 'foreignProperties') && array_key_exists($field, $this->foreignProperties)) {
            $foreignProperty = explode('|', $this->foreignProperties[$field]);
            $relatedModel  = $foreignProperty[0];
            $matchingField = end($foreignProperty);

            $query = $this->loopRelatedJoin($query, $foreignProperty);

            $query = $query->orderBy($matchingField, $direction);
        } else {
            $query = $query->orderBy($field, $direction);
        }

        return $query;
    }

    public function loopRelatedJoin($query, $foreignProperty)
    {
        $lastJoinIndex = count($foreignProperty) - 1;

        for ($i = 0; $i < $lastJoinIndex; $i++) {
            $query = $query->joinRelations($foreignProperty[$i]);
        }

        return $query;
    }
}
