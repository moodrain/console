@foreach($cols ?? [] as $col)
    <el-table-column prop="{{ $col[1] }}" label="{{ ____($col[0]) }}" {!! isset($col[2]) ? 'width="' . $col[2] . '"' : '' !!}></el-table-column>
@endforeach