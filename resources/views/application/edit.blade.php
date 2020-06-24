@extends('layout.frame')

@include('piece.edit-title')

@section('main')
    <el-row>
        <el-col :xs="{span:22,offset:1}" :lg="8">
            <el-card>
                <el-form label-width="80px">
                    <x-edit-id :d="$d"></x-edit-id>
                    <x-input exp="model:form.name;label:Name"></x-input>
                    <x-input exp="model:form.site;label:Site"></x-input>
                    <x-input exp="model:form.detail;label:Detail"></x-input>
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
                    site: '{{ bv('site') }}',
                    detail: '{{ bv('detail') }}',
                },
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
