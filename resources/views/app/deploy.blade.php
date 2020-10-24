@extends('layout.frame')

@section('title', 'app deploy')

@section('main')
    <el-row>
        <el-col :xs="{span:22,offset:1}" :lg="8">
            <el-card>

                <el-form>
                    <x-input exp="model:form.path;pre:path"></x-input>
                    <el-form-item>
                        <el-button @click="$submit(form)">{{ ___('deploy') }}</el-button>
                    </el-form-item>
                </el-form>

            </el-card>
        </el-col>
    </el-row>
@endsection

@section('script')
    <script>
        let vue = new Vue({
            el: '#app',
            data() {
                return {
                    @include('piece.data')
                    menuActive: 'app-deploy',
                    form: {
                        path: '{{ old('path') ?? $path ?? '' }}',
                    },
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