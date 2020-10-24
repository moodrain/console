@extends('layout.frame')

@section('title', 'home')

@section('main')
    <el-row>
        <el-col :xs="{span:18,offset:3}" :span="8" :offset="8">
            <br />
            <el-card>
                <br />
                <p>{{ ___('greet') }} {{ user()->name }}</p>
                <br />
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
            @include('piece.data')
            menuActive: 'home'
        }
    },
    methods: {
        @include('piece.method')
    },
    mounted() {
        @include('piece.init')
    }
})
</script>
@endsection