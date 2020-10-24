@extends('layout.frame')

@include('admin.piece.list-title')

@section('main')
    <el-card>
        <el-form inline>
            <x-input exp="model:search.id;pre:id" />
            <x-input exp="model:search.name;pre:name" />
            <x-sort />
            @include('admin.piece.list-head-btn')
        </el-form>
    </el-card>
    <br />
    <el-card>
        @php
            $cols = [
                ['id', 'id', 60],
                ['name', 'name'],
                ['connection', 'conn.name'],
            ];
        @endphp
        <el-table :data="list" height="560" border  @selection-change="selectChange">
            <el-table-column type="selection" width="55"></el-table-column>
            <x-table-col :cols="$cols" />
            @include('admin.piece.list-body-col')
        </el-table>
        <x-pager />
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