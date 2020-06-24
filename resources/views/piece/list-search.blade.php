@php
    $search = [];
    foreach (get_class_vars($modelClass)['searchRule'] ?? [] as $key => $val) {
        $search[$key] = request('search.' . $key);
    }
@endphp
search: @json($search),