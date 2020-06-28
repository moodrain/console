@extends('layout.frame')

@include('piece.list-title')

@section('main')
    <el-card>
        <el-form inline>
            <x-input exp="model:search.id;pre:ID" />
            <x-input exp="model:search.note;pre:Note" />
            <x-select exp="model:search.applicationId;label:Application;data:applications;key:id;selectLabel:name;value:id" />
            <x-sort />
            <x-list-head-btn :m="$m" />
        </el-form>
    </el-card>
    <br />
    <el-card>
        <el-table :data="list" height="560" border  @selection-change="selectChange">
            <el-table-column type="selection" width="55"></el-table-column>
            <el-table-column prop="id" label="ID" width="60"></el-table-column>
            <el-table-column prop="application.name" label="Application"></el-table-column>
            <el-table-column label="Content">
                <template slot-scope="scope">
                    <p v-if="scope.row.content.length > 256" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">@{{ scope.row.content }}</p>
                    <p v-if="scope.row.content.length <= 256">@{{ scope.row.content }}</p>
                </template>
            </el-table-column>
            <el-table-column prop="note" label="Note"></el-table-column>
            <el-table-column prop="createdAt" label="CreatedAt" width="160"></el-table-column>
            <x-list-body-col :m="$m" />
        </el-table>
        <x-pager />
    </el-card>
@endsection

@section('script')
    <script>
        new Vue({
            el: '#app',
            data () {
                return {
                    @include('piece.list-data')
                    applications: @json(\App\Models\Application::query()->get(['id', 'name'])),
                }
            },
            methods: {
                @include('piece.list-method')
                more(row) {
                    let tab = window.open('about:blank', '_blank')
                    tab.document.write(row.content)
                    tab.document.close()
                },
            },
            mounted() {
                @include('piece.init')
            }
        })
    </script>
@endsection