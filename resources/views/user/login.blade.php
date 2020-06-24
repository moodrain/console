@extends('layout.app')
@section('title', 'Login')
@section('html')
    <div id="app">
        <br />
        <el-row>
            <el-col :xs="{span:20,offset:2}" :lg="{span:6,offset:9}">
                <el-card>
                    <el-form>
                        <x-input exp="model:form.email;pre:Email"></x-input>
                        <x-input exp="model:form.password;pre:Password;type:password"></x-input>
                        <el-form-item>
                            <el-button @click="login">Login</el-button>
                            <el-divider direction="vertical"></el-divider>
                            <el-link href="/register">or Register</el-link>
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
                        password: '',
                    }
                }
            },
            methods: {
                @component('piece.method')@endcomponent
                login () {
                    if (! this.form.email || ! this.form.password) {
                        return
                    }
                    $submit(this.form)
                }
            },
            mounted() {
                @component('piece.init')@endcomponent
            }
        })
        $enter(() => vue.login())
    </script>
@endsection

@section('css')
    @include('layout.css')
@endsection