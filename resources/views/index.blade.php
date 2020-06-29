@extends('layout.frame')

@section('title', 'Dashboard')

@section('main')
    <el-row>
        <el-col :xs="24" :lg="8">
            <br />
            <el-card>
                <br />
                <p>Greeting {{ user()->name }}</p>
                <el-divider></el-divider>
                @if($key)
                    <el-button class="clipboard-btn" icon="el-icon-document" data-clipboard-text="{!! $key !!}"></el-button>
                @else
                    <el-button @click="$to({genKey: true})">Generate Key</el-button>
                @endif
            </el-card>
        </el-col>
    </el-row>
@endsection

@section('script')
<script>
new Vue({
    el: '#app',
    data () {
        return {
            menuActive: 'dashboard'
        }
    }
})
</script>
@endsection