@foreach(config('view.' . $key, []) as $item)
    @if(is_string($item[2]))
        <el-menu-item index="{{ $item[0] }}" @click="$to('/{{ $item[2] }}', {}, true)">{{ ____($item[1]) }}</el-menu-item>
    @else
        <el-submenu index="{{ $item[0] }}">
            <template slot="title">{{ ____($item[1]) }}</template>
            @foreach($item[2] as $subItem)
                <el-menu-item index="{{ $subItem[0] }}" @click="$to('/{{ $subItem[2] }}', {}, true)">{{ ____($subItem[1]) }}</el-menu-item>
            @endforeach
        </el-submenu>
    @endif
@endforeach