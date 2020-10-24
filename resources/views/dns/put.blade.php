@extends('layout.frame')

@section('title', 'DNS')

@section('main')
    <el-row>
        <el-col :xs="{span:22,offset:1}" :lg="8">
            <el-card>

                <el-form>
                    <x-input exp="model:form.domain;pre:domain"></x-input>
                    <x-input exp="model:form.rr;pre:rr"></x-input>
                    <x-input exp="model:form.value;pre:value"></x-input>
                    <x-select exp="model:form.type;data:types;label:type"></x-select>
                    <el-form-item>
                        <el-button @click="$submit(form)">{{ ___('save') }}</el-button>
                    </el-form-item>
                </el-form>

            </el-card>

            <br />
            <el-card v-if="result">
                <p slot="header">{{ ___('result') }}</p>
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
            menuActive: 'dns',
            form: {
                domain: '{{ bv('domain') }}',
                rr: '{{ bv('rr') }}',
                type: '{{ bv('type', 'A') }}',
                value: '{{ bv('value') }}',
            },
            types: ['A', 'NS', 'MX', 'TXT', 'CNAME', 'SRV', 'AAAA', 'CAA', 'REDIRECT_URL', 'FORWARD_URL'],
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
</script>
@endsection