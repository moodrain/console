@extends('layout.frame')

@section('title', 'Bucket list')

@section('main')

<el-card>
    <el-form inline>
        <x-input exp="model:form.name;pre:name" />
        <x-select exp="model:form.acl;label:acl;data:acls" />
        <el-button icon="el-icon-plus" @click="create"></el-button>
    </el-form>
</el-card>

<br />
<el-card>
    <el-table :data="list" height="500" border>
        <el-table-column prop="name" label="{{ ___('name') }}"></el-table-column>
        <el-table-column label="{{ ___('acl') }}">
            <template slot-scope="scope">
                <p v-if="scope.row.acl === 'private'">{{ ___('private') }}</p>
                <p v-if="scope.row.acl === 'public-read'">{{ ___('public-read') }}</p>
                <p v-if="scope.row.acl === 'public-read-write'">{{ ___('public-read-write') }}</p>
            </template>
        </el-table-column>
        <el-table-column label="{{ ___('operation') }}">
            <template slot-scope="scope">
                <el-button :disabled="scope.row.acl === 'private'" @click="setAcl(scope.row, '{{ \OSS\OssClient::OSS_ACL_TYPE_PRIVATE }}')">{{ ____('set private') }}</el-button>
                <el-button :disabled="scope.row.acl === 'public-read'" @click="setAcl(scope.row, '{{ \OSS\OssClient::OSS_ACL_TYPE_PUBLIC_READ }}')">{{ ____('set public-read') }}</el-button>
                <el-button :disabled="scope.row.acl === 'public-read-write'" @click="setAcl(scope.row, '{{ \OSS\OssClient::OSS_ACL_TYPE_PUBLIC_READ_WRITE }}')">{{ ____('set public-read-write') }}</el-button>
                <el-button icon="el-icon-delete" @click="destroy(scope.row)"></el-button>
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
                list: @json($l),
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
            destroy(bucket) {
                this.$confitm('{{ ___('confirm') }}').then(() => {
                    this.$submit('/oss-bucket/destroy', {name: bucket.name})
                }).catch(() => {})
            },
            setAcl(bucket, acl) {
                this.$confitm('{{ ___('confirm') }}').then(() => {
                    this.$submit('/oss-bucket/acl', {name: bucket.name, acl})
                }).catch(() => {})
            }
        },
        mounted() {
            @include('piece.init')
        }
    })
</script>
@endsection