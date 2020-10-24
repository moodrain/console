@extends('layout.frame')

@include('admin.piece.list-title')

@section('main')
    @php
        $cols = [
            ['id', 'id', 60],
            ['name', 'name'],
            ['host', 'host'],
            ['driver', 'driver'],
            ['user', 'username'],
            ['time', 'createdAt', 160],
        ];
    @endphp
<el-card>
    <el-form inline>
        <x-input exp="model:search.id;pre:id" />
        <x-input exp="model:search.name;pre:name" />
        <x-input exp="model:search.host;pre:host" />
        <x-sort />
        @include('admin.piece.list-head-btn')
    </el-form>
    <el-divider></el-divider>mo
    <el-table :data="list" height="560" border  @selection-change="selectChange">
        <el-table-column type="selection" width="55"></el-table-column>
        <x-table-col :cols="$cols" />
        @include('admin.piece.list-body-col')
    </el-table>
</el-card>
@endsection

@section('script')
    <script>
        new Vue({
            el: '#app',
            data () {
                return {
                    @include('admin.piece.list-data')
                }
            },
            methods: {
                @include('admin.piece.list-method')
            },
            mounted() {
                @include('admin.piece.init')
            }
        })
    </script>
@endsection