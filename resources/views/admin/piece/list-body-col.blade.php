<el-table-column label="{{ ___('operation') }}" width="170">
    <template slot-scope="scope">
        <el-button icon="el-icon-more" circle @click="more(scope.row)"></el-button>
        <el-button icon="el-icon-edit" circle @click="$to('/{{ $prefix }}edit', {id: scope.row.id})"></el-button>
        <el-button icon="el-icon-delete" circle @click="doDelete(scope.row.id)"></el-button>
    </template>
</el-table-column>