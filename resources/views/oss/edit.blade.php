@extends('layout.frame')

@include('piece.edit-title')

@section('main')
<el-row>
    <el-col :xs="{span:22,offset:1}" :lg="8">
        <el-card>
            <el-form>
                <x-select exp="model:form.bucket;label:Bucket;data:buckets" />
                <x-input exp="model:form.path;label:Path" />
                <el-form-item label="Content">
                    <el-input type="textarea" :autosize="{minRows:2,maxRows:20}" v-model="form.content" ></el-input>
                </el-form-item>
                <el-form-item>
                    <el-button @click="save">{{ request('file') ? 'Save' : 'Create' }}</el-button>
                </el-form-item>
                <el-form-item>
                    <el-upload
                        :action="uploadAction"
                        :on-success="uploadOk"
                        :show-file-list="false"
                        :with-credentials="true"
                        :before-upload="uploadCheck"
                    >
                        <el-button slot="trigger">Upload File</el-button>
                    </el-upload>
                </el-form-item>
            </el-form>
        </el-card>
    </el-col>
</el-row>
@endsection

@section('script')
<script>
new Vue({
    el: '#app',
    data() {
        return {
            menuActive: 'oss-edit',
            @include('piece.data')
            buckets: @json(cache('oss-bucket', [])),
            form: {
                bucket: '{{ old('bucket') ?? request('bucket') }}',
                path: '{{ old('path') ?? request('file') ?? request('path') }}',
                content: atob('{{ request('file') ? base64_encode((new \App\Services\OssService())->get(request('bucket'), request('file'))) : '' }}'),
            },
        }
    },
    methods: {
        @include('piece.method')
        uploadOk(rs) {
            if (rs.code === 0) {
                this.$notify({message: 'Success', type: 'success'})
                this.form.content = rs.data
            } else {
                this.$notify({message: rs.msg, type: 'warning'})
            }
        },
        uploadCheck() {
            if (! (this.form.bucket && this.form.path)) {
                this.$notify({message: 'fill bucket and path before upload file', type: 'warning'})
                return false
            }
        },
        save() {
            if (! (this.form.bucket && this.form.path)) {
                return
            }
            this.$submit(this.form)
        }
    },
    mounted() {
        @include('piece.init')
    },
    computed: {
        uploadAction: {
            get() {
                return '/oss/upload?bucket=' + this.form.bucket + '&path=' + this.form.path
            }
        }
    }
})
</script>
@endsection