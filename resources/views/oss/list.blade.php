@extends('layout.frame')

@section('title', 'OSS list')

@section('main')

<el-card>
    <el-breadcrumb separator="/">
        <el-breadcrumb-item @click.native="breadTo(index)" style="cursor: pointer;font-size: 1.15em" v-for="(item, index) in pathArr" :key="index">@{{ item }}</el-breadcrumb-item>
    </el-breadcrumb>
    <el-divider></el-divider>
    <el-form inline>
        <el-form-item><el-button icon="el-icon-back" @click="parentPath"></el-button></el-form-item>
        <x-select exp="model:search.bucket;data:buckets;change:toBucket" />
        <x-input exp="model:search.path;pre:Path" />
        <el-button icon="el-icon-search" @click="doSearch"></el-button>
        <el-button icon="el-icon-plus" @click="add"></el-button>
        <el-button icon="el-icon-refresh-left" @click="refreshBucket"></el-button>
    </el-form>
</el-card>

<br />
<el-card>

    <el-table v-if="directories.length > 0" :data="directories" max-height="500" border>
        <el-table-column label="{{ ___('directory') }}">
            <template slot-scope="scope">
                <p @click="pendDir(scope.row)">@{{ scope.row.name }}</p>
            </template>
        </el-table-column>
    </el-table>

    <br />

    <el-table v-if="files.length > 0" :data="files" max-height="500" border>
        <el-table-column prop="name" label="{{ ___('file') }}"></el-table-column>
        <el-table-column label="{{ ___('operation') }}">
            <template slot-scope="scope">
                <el-button icon="el-icon-view" @click="view(scope.row)"></el-button>
                <el-button icon="el-icon-edit" @click="edit(scope.row)"></el-button>
                <el-button icon="el-icon-delete" @click="remove(scope.row)"></el-button>
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
                buckets: @json($buckets),
                menuActive: 'oss-list',
                search: {
                    bucket: '{{ $bucket }}',
                    path: '{{ request('path') }}',
                },
                path: '{{ request('path') }}',
            }
        },
        methods: {
            @include('piece.method')
            doSearch() {
                this.$to(this.search)
            },
            refreshBucket() {
                this.$submit('/oss-bucket/refresh')
            },
            add() {
                this.$to('/oss/edit', {bucket: this.search.bucket, path: this.search.path + '/'})
            },
            edit(file) {
                this.$to('/oss/edit', {bucket: this.search.bucket, file: this.search.path + '/' + file.name})
            },
            remove(file) {
                this.$confirm('{{ ___('confirm') }}').then(() => {
                    this.$submit('/oss/destroy', {bucket: this.search.bucket, file: this.search.path + '/' + file.name})
                }).catch(() => {})
            },
            pendDir(dir) {
                this.search.path += (this.search.path ? ('/' + dir.name) : dir.name)
                this.doSearch()
            },
            view(dir) {
                window.open('http://' + this.search.bucket + '.{{ $endpoint }}/' + this.search.path + '/' + dir.name)
            },
            breadTo(index) {
                this.$to('/oss/list', {path: this.pathArr.slice(1, index + 1).join('/')})
            },
            parentPath() {
                let pathPieces = this.path.split('/')
                if (pathPieces.length < 1) {
                    return
                }
                let parentPath = pathPieces.slice(0, pathPieces.length - 1).join('/')
                this.$to({path: parentPath})
            },
            toBucket(bucket) {
                this.$to('/oss/list', {bucket}, true)
            }
        },
        mounted() {
            @include('piece.init')
        },
        computed: {
            pathArr: {
                get() {
                    return ['root'].concat(this.path.split('/'))
                }
            },
        }
    })
</script>
@endsection