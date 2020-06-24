@include('piece.data')
menuActive: '{{ $m }}-list',
selects: [],
sort: {
    prop: '{{ request('sort.prop') }}',
    order: '{{ request('sort.order') ?? 'asc' }}',
},
list: @json($l).data,
page: {{ $l->currentPage() }},
total: {{ $l->total() }},
sortOptions: @json(get_class_vars($modelClass)['sortRule']),
users: @json(\App\Models\User::query()->get(['id', 'name'])),
@include('piece.list-search')