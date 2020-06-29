@extends('layout.frame')

@include('piece.edit-title')

@section('main')
    <el-row>
        <el-col :xs="{span:22,offset:1}" :lg="8">
            <el-card>
                <el-form label-width="80px">
                    <x-edit-id :d="$d"></x-edit-id>
                    <x-input exp="model:form.name;label:Name"></x-input>
                    <x-input exp="model:form.tempId;label:TemplateId"></x-input>
                    <x-select exp="model:form.applicationId;label:Application;data:applications;key:id;selectLabel:name;value:id" />
                    <x-input exp="model:form.dataJson;label:dataJson;type:textarea"></x-input>
                    <x-input exp="model:form.mapJson;label:mapJson;type:textarea"></x-input>
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
                    name: '{{ bv('name') }}',
                    tempId: '{{ bv('tempId') }}',
                    dataJson: '{!! bv('dataJson') !!}',
                    mapJson: '{!! bv('mapJson') !!}',
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