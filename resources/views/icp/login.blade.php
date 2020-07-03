@extends('layout.app')
@section('title', '登录')
@section('html')
    <div id="app">
        <br />
        <el-row>
            <el-col :xs="{span:20,offset:2}" :lg="{span:6,offset:9}">
                <el-card>
                    <el-form>
                        <x-input exp="model:form.email;pre:邮箱"></x-input>
                        <x-input exp="model:form.password;pre:密码;type:password"></x-input>
                        <el-form-item>
                            <el-button @click="login">登录</el-button>
                            <el-divider>其他方式登录</el-divider>
                            <el-button size="small" @click="qq">
                                <el-image src="/qq.png" fit="contain" style="width: 30px;height: 30px;"></el-image>
                            </el-button>
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
                login() {
                    if (! this.form.email || ! this.form.password) {
                        return
                    }
                    $submit(this.form)
                },
                qq() {
                    window.open("/oa/qq", "TencentLogin", "width=450,height=320,menubar=0,scrollbars=1,resizable=1,status=1,titlebar=0,toolbar=0,location=1")
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