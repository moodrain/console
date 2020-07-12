@extends('layout.frame')

@include('piece.list-title')

@section('main')

<el-card>
    <el-form inline>
        <x-select exp="model:search.bucket;label:Bucket;data:buckets" />
        <x-input exp="model:search.path;pre:Path" />
        <el-button icon="el-icon-search" @click="doSearch"></el-button>
        <el-button icon="el-icon-plus" @click="add"></el-button>
        <el-button icon="el-icon-refresh-left" @click="refreshBucket"></el-button>
    </el-form>
</el-card>

<br />
<el-card>

    <el-table v-if="directories.length > 0" :data="directories" max-height="500" border>
        <el-table-column label="Directory">
            <template slot-scope="scope">
                <p @click="pendDir(scope.row)">@{{ scope.row.name }}</p>
            </template>
        </el-table-column>
    </el-table>

    <br />

    <el-table v-if="files.length > 0" :data="files" max-height="500" border>
        <el-table-column prop="name" label="File"></el-table-column>
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
                    bucket: '{{ request('bucket') }}',
                    path: '{{ request('path') }}',
                }
            }
        },
        methods: {
            @include('piece.method')
            doSearch() {
                this.$to(this.search)
            },
            refreshBucket() {

            },
            add() {

            },
            edit() {

            },
            delete() {

            },
            pendDir(dir) {
                this.search.path += ('/' + dir.name)
                this.doSearch()
            }
        },
        mounted() {
            @include('piece.init')
        }
    })
</script>
@endsection