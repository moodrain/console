@extends('layout.frame')

@include('admin.piece.edit-title')

@section('main')
    <el-row>
        <el-col :span="8" :xs="24">
            <el-card>
                <el-form>
                    @include('admin.piece.edit-id')
                    <x-input exp="model:form.name;pre:name" />
                    <x-select exp="model:form.connectionId;label:connection;data:connections;selectLabel:name;key:id;value:id" />
                    <x-select exp="model:form.databaseId;label:database;data:databases;selectLabel:name;key:id;value:id" />
                    <x-select exp="model:form.saveType;data:saveTypes;label:saveType" />
                    <x-input exp="model:form.backupInterval;pre:backupInterval" />
                    <x-input exp="model:form.backupKeepCount;pre:backupKeepCount" />
                    <x-input exp="model:form.ignoreDatabases;label:ignoreDatabases;type:textarea" />
                    <x-input exp="model:form.ignoreTables;label:ignoreTables;type:textarea" />
                    <x-switch exp="model:form.on;label:on" />
                    @include('admin.piece.edit-submit')
                </el-form>
            </el-card>
        </el-col>
    </el-row>
@endsection

@section('script')
<script>
    new Vue({
        el: '#app',
        data () {
            return {
                @include('admin.piece.edit-data')
                form: {
                    id: {{ bv('id', null) }},
                    name: '{{ bv('name') }}',
                    connectionId: {{ bv('connectionId', null) }},
                    databaseId: {{ bv('databaseId', null) }},
                    saveType: '{{ bv('saveType') }}',
                    backupInterval: {{ bv('backupInterval', null) }},
                    backupKeepCount: {{ bv('backupKeepCount', null) }},
                    on: {{ bv('on') ? 'true' : 'false' }},
                    @php
                        $iDbs = bv('ignoreDatabases', []);
                        $iTbs = bv('ignoreTables', []);
                    @endphp
                    ignoreDatabases: `{!! is_array($iDbs) ? json_encode($iDbs) : $iDbs !!}`,
                    ignoreTables: `{!! is_array($iTbs) ? json_encode($iTbs) : $iTbs !!}`,
                },
                connections: @json(\App\Models\DbBackup\Connection::query()->get(['id', 'name'])),
                databaseAll: @json(\App\Models\DbBackup\Database::query()->get(['id', 'name', 'connection_id'])),
                saveTypes: @json(\App\Models\DbBackup\Task::SAVE_TYPES),
            }
        },
        methods: {
            @include('admin.piece.edit-method')
        },
        mounted() {
            @include('admin.piece.init')
        },
        computed: {
            databases: {
                get() {
                    return this.databaseAll.filter(d => d.connectionId === this.form.connectionId)
                }
            }
        }
    })
</script>
@endsection
