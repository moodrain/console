@extends('layout.app')
@section('title', 'login')
@section('html')
    <div id="loading" style="position: absolute;z-index: 3000;background: #b4f3f4;width: 100%;height: 100%"></div>
    <div id="app">
        <br />
        <el-row>
            <el-col :span="6" :offset="9" :xs="{span:20,offset:2}">
                <el-card>
                    <el-form>
                        <x-input exp="model:form.email;pre:email;ref:email" />
                        <x-input exp="model:form.password;pre:password;type:password;ref:password" />
                        <el-form-item>
                            <el-button @click="login">{{ ___('login') }}</el-button>
                            <el-divider direction="vertical"></el-divider>
                            <el-link href="/register">{{ ___('register') }}</el-link>
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
                        password: '',
                    }
                }
            },
            methods: {
                @include('piece.method')
                login() {
                    if (! this.form.email || ! this.form.password) {
                        return
                    }
                    $submit(this.form)
                }
            },
            mounted() {
                @include('piece.init')
                this.form.email ? this.$refs.password.focus() : this.$refs.email.focus()
            }
        })
        $enter(() => vue.login())
    </script>
@endsection

@section('css')
    @include('common.css')
@endsection