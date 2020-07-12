@extends('layout.frame')

@include('piece.list-title')

@section('main')

<el-card>
    <el-form inline>
        <x-input exp="model:form.name;pre:Name" />
        <x-select exp="model:form.acl;label:ACL;data:acls" />
        <el-button icon="el-icon-plus" @click="create"></el-button>
    </el-form>
</el-card>

<br />
<el-card>
    <el-table :data="list" height="500" border>
        <el-table-column prop="name" label="Name"></el-table-column>
        <el-table-column label="Operation">
            <template slot-scope="scope">
                <el-button @click="setAcl(scope.row, '{{ \OSS\OssClient::OSS_ACL_TYPE_PRIVATE }}')">setPrv</el-button>
                <el-button @click="setAcl(scope.row, '{{ \OSS\OssClient::OSS_ACL_TYPE_PUBLIC_READ }}')">setPubR</el-button>
                <el-button @click="setAcl(scope.row, '{{ \OSS\OssClient::OSS_ACL_TYPE_PUBLIC_READ_WRITE }}')">setPubRW</el-button>
                <el-button icon="el-icon-delete" @click="drop(scope.row)"></el-button>
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
                acls: @json(\OSS\OssClient::$OSS_ACL_TYPES),
                list: @json($d),
                menuActive: 'oss-bucket-list',
                form: {
                    name: null,
                    acl: null,
                }
            }
        },
        methods: {
            @include('piece.method')
            create() {
                this.$submit('/oss-bucket/create', this.form)
            },
            drop(bucket) {
                if (! confirm('confirm to drop ?')) {
                    return
                }
                this.$submit('/oss-bucket/drop', {name: bucket.name})
            },
            setAcl(bucket, acl) {
                if (! confirm('confirm to set ACL ?')) {
                    return
                }
                this.$submit('/oss-bucket/acl', {name: bucket.name, acl})
            }
        },
        mounted() {
            @include('piece.init')
        }
    })
</script>
@endsection