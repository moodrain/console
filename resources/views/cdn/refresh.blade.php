@extends('layout.frame')

@section('title', 'CDN')

@section('main')
    <el-row>
        <el-col :xs="{span:22,offset:1}" :lg="8">
            <el-card>

                <el-form>
                    <x-input exp="model:form.url;pre:Url"></x-input>
                    <el-form-item>
                        <el-switch v-model="form.isDir" active-text="目录" inactive-text="文件"></el-switch>
                    </el-form-item>
                    <el-form-item>
                        <el-button @click="$submit(form)">Refresh</el-button>
                    </el-form-item>
                </el-form>

            </el-card>

            <br />
            <el-card v-if="result">
                <p slot="header">Result</p>
                <el-input v-model="result" type="textarea" autosize></el-input>
            </el-card>

        </el-col>
    </el-row>
@endsection

@php(bv($d ?? []))

@section('script')
<script>
let vue = new Vue({
    el: '#app',
    data() {
        return {
            @include('piece.data')
            menuActive: 'cdn',
            form: {
                url: '{{ bv('url') }}',
                isDir: {{ bv('isDir', false) ? 'true' : 'false' }}
            },
            result: `{!! $result ?? '' !!}`,
        }
    },
    methods: {
        @include('piece.method')
    },
    mounted() {
        @include('piece.init')
    }
})
$enter(() => $submit(vue.form))
</script>
@endsection