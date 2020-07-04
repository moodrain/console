@php
if (request('oa')) {
    if (request('oa' == 'qq')) {
        $oaData = decrypt(urldecode(request('oa_data')));
        session()->put('avatar', $oaData['figureurl_qq_1']);
        session()->put('name', $oaData['nickname']);
    }
}
if (! session('name')) {
    echo '<script>window.location.href="/login"</script>';
    exit;
}
@endphp

@extends('layout.app')

@section('title', 'MoodRain')

@section('html')
    <div id="app">

        <el-header style="user-select: none;background-color: #545c64;color: #fff;line-height: 60px">

            <el-container style="height: 60px;line-height: 60px;float: left;">
                <p style="color: white;font-size: 1.4em;text-align: center;user-select: none">{{ 'Mood Rain' }}</p>
            </el-container>

            <el-dropdown style="float: right">

                <p style="cursor: pointer;color: #fff">
                    <el-avatar :size="40" src="{{ session('avatar') }}" fit="contain" style="position: relative;top: 10px;right: 10px"></el-avatar>
                    <span>{{ session('name') }} <i class="el-icon-arrow-down el-icon--right"></i></span>
                </p>
                <el-dropdown-menu slot="dropdown">
                    <el-dropdown-item><a href="javascript:" onclick="document.querySelector('#logout').submit()">登出</a></el-dropdown-item>
                </el-dropdown-menu>
            </el-dropdown>

        </el-header>

        <form hidden id="logout" action="/logout" method="POST"></form>

    </div>
@endsection

@section('js')
    @include('layout.js')
    <script>
        new Vue({
            el: '#app',
            data() {
                return {
                    msg: 'Hello World'
                }
            }
        })
    </script>
@endsection

@section('css')
    @include('layout.css')
    <style>

    </style>
@endsection