@extends('layout.app')
@section('title', 'register')
@section('html')
    <div id="loading" style="position: absolute;z-index: 3000;background: #b4f3f4;width: 100%;height: 100%"></div>
    <div id="app">
        <br />
        <el-row>
            <el-col :span="6" :offset="9" :xs="{span:20,offset:2}">
                <el-card>
                    <el-form>
                        <x-input exp="model:form.email;pre:email" />
                        <x-input exp="model:form.name;pre:name" />
                        <x-input exp="model:form.password;pre:password;type:password" />
                        <x-input exp="model:form.rePassword;pre:re-password;type:password" />
                        <el-form-item>
                            <el-button @click="register">{{ ___('register') }}</el-button>
                            <el-divider direction="vertical"></el-divider>
                            <el-link href="/login">{{ ___('login') }}</el-link>
                        </el-form-item>
                    </el-form>
                </el-card>
            </el-col>
        </el-row>
    </div>
@endsection

@section('js')
    @include('common.js')
    <script>
        let vue = new Vue({
            el: '#app',
            data() {
                return {
                    @include('piece.data')
                    form: {
                        email: '{{ old('email') }}',
                        name: '{{ old('name') }}',
                        password: '',
                        rePassword: '',
                    }
                }
            },
            methods: {
                @include('piece.method')
                register() {
                    if (! this.form.email || ! this.form.password || ! this.form.name) {
                        alert('{{ __('msg.form-not-finished') }}')
                        return
                    }
                    if (this.form.password != this.form.rePassword) {
                        alert('{{ __('msg.password-not-equal') }}')
                        return
                    }
                    $submit(this.form)
                }
            },
            mounted() {
                @include('piece.init')
            }
        })
        $enter(() => vue.register())
    </script>
@endsection

@section('css')
    @include('common.css')
@endsection