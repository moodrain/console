@extends('layout.app')
@section('title', 'Register')
@section('html')
    <div id="app">
        <br />
        <el-row>
            <el-col :xs="{span:20,offset:2}" :lg="{span:6,offset:9}">
                <el-card>
                    <el-form>
                        <x-input exp="model:form.email;pre:Email"></x-input>
                        <x-input exp="model:form.name;pre:Name"></x-input>
                        <x-input exp="model:form.password;pre:Password;type:password"></x-input>
                        <x-input exp="model:form.re_password;pre:RePassword;type:password"></x-input>
                        <el-form-item>
                            <el-button @click="register">Register</el-button>
                            <el-divider direction="vertical"></el-divider>
                            <el-link href="/login">or Login</el-link>
                        </el-form-item>
                    </el-form>
                </el-card>
            </el-col>
        </el-row>
    </div>
@endsection

@section('js')
    @include('layout.js')
    <script>
        let vue = new Vue({
            el: '#app',
            data () {
                return {
                    @component('piece.data')@endcomponent
                    form: {
                        email: '{{ old('email') }}',
                        name: '{{ old('name') }}',
                        password: '',
                        re_password: '',
                    }
                }
            },
            methods: {
                @component('piece.method')@endcomponent
                register () {
                    if (! this.form.email || ! this.form.password || ! this.form.name) {
                        alert('some inputs are empty')
                        return
                    }
                    if (this.form.password != this.form.re_password) {
                        alert('password not equal re password')
                        return
                    }
                    $submit(this.form)
                }
            },
            mounted() {
                @component('piece.init')@endcomponent
            }
        })
        $enter(() => vue.submit())
    </script>
@endsection

@section('css')
    @include('layout.css')
@endsection