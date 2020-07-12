@extends('layout.frame')

@include('piece.list-title')

@section('main')

<el-card>
    <el-form inline>
        <x-select exp="model:form.acl;label:Bucket;data:acls" />
        <x-input exp="model:search.path;pre:Path" />
        <el-button icon="el-icon-search" @click="search"></el-button>
        <el-button icon="el-icon-plus" @click="add"></el-button>
        <el-button icon="el-icon-refresh-left" @click="refreshBucket"></el-button>
    </el-form>
</el-card>

<br />
<el-card>
    <el-table :data="list" height="500" border>
        <el-table-column prop="name" label="Name"></el-table-column>
        <el-table-column label="Operation">
            <template slot-scope="scope">
                <el-button icon="el-icon-edit" @click="edit(scope.row)"></el-button>
                <el-button icon="el-icon-delete" @click="delete(scope.row)"></el-button>
            </template>
        </el-table-column>
    </el-table>
</el-card>
@endsection

@section('script')
<script>
    new Vue({
        el: '#app',
        data () {
            return {
                @include('piece.data')
                directories: @json($directories),
                files: @json($files),
                buckets: @json(cache('oss-bucket', [])),
                menuActive: 'oss-list',
                search: {
                    bucket: null,
                    path: null,
                }
            }
        },
        methods: {
            @include('piece.method')
            search() {

            },
            refreshBucket() {

            },
            edit() {

            },
            delete() {

            }
        },
        mounted() {
            @include('piece.init')
        }
    })
</script>
@endsection