<x-select exp="model:sort.prop;label:{{ __('sort') }};data:sortOptions"></x-select>
<el-form-item>
    <el-select v-model="sort.order">
        <el-option :key="'ascending'" :label="'{{ ___('ascend') }}'" :value="'asc'"></el-option>
        <el-option :key="'descending'" :label="'{{ ___('descend') }}'" :value="'desc'"></el-option>
    </el-select>
</el-form-item>