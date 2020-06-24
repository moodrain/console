<el-menu-item index="dashboard" @click="$to('/', {}, true)">Dashboard</el-menu-item>

<el-submenu index="application">
    <template slot="title">Application</template>
    <el-menu-item index="application-list" @click="$to('/application/list', {}, true)">App List</el-menu-item>
    <el-menu-item index="application-edit" @click="$to('/application/edit', {}, true)">App Edit</el-menu-item>
</el-submenu>

<el-submenu index="json-storage">
    <template slot="title">Json Storage</template>
    <el-menu-item index="json-storage-list" @click="$to('/json-storage/list', {}, true)">Json List</el-menu-item>
    <el-menu-item index="json-storage-edit" @click="$to('/json-storage/edit', {}, true)">Json Edit</el-menu-item>
</el-submenu>