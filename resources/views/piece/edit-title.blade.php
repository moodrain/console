@section('title')
    @if($d ?? '')
        {{ ucfirst($m) }} Edit
    @else
        New {{ ucfirst($m) }}
    @endif
@endsection