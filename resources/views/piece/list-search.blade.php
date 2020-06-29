@php
    $search = [];
    $keys = array_keys(get_class_vars($modelClass)['searchRule']);
    foreach ($keys as $key) {
        $keyInfo = explode('/', $key);
        $key = $keyInfo[0];
        $type = $keyInfo[1] ?? 's';
        if (! request()->filled('search.' . $key)) {
            $search[$key] = null;
        } else {
            $val = request('search.' . $key);
            switch ($type) {
                case 's':
                    $val = (string) $val;
                    break;
                case 'i':
                    // no break
                case 'd':
                    $val = (int) $val;
                    break;
                case 'f':
                    $val = (float) $val;
            }
            $search[$key] = $val;
        }

    }
@endphp
search: @json($search),