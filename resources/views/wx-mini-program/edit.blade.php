@extends('layout.frame')

@include('piece.edit-title')

@section('main')
    <el-row>
        <el-col :xs="{span:22,offset:1}" :lg="8">
            <el-card>
                <el-form label-width="80px">
                    <x-edit-id :d="$d"></x-edit-id>
                    <x-input exp="model:form.appid;label:Appid"></x-input>
                    <x-input exp="model:form.appsecret;label:Appsecret"></x-input>
                    <x-select exp="model:form.applicationId;label:Application;data:applications;key:id;selectLabel:name;value:id" />
                    <x-edit-submit :d="$d"></x-edit-submit>
                </el-form>
            </el-card>
        </el-col>
    </el-row>
@endsection

@section('script')
<script>
    let vue = new Vue({
        el: '#app',
        data () {
            return {
                @include('piece.edit-data')
                form: {
                    id: {{ bv('id', null) }},
                    appid: '{{ bv('appid') }}',
                    appsecret: '{{ bv('appsecret') }}',
                    applicationId: {{ bv('id', null) }},
                },
                applications: @json(\App\Models\Application::query()->get(['id', 'name'])),
            }
        },
        methods: {
            @include('piece.edit-method')
        },
        mounted() {
            @include('piece.init')
        }
    })
    $enter(() => $submit(vue.form))
</script>
@endsection
