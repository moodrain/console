@php(extract(bladeIncludeExp($exp ?? '')))
<el-form-item

        @isset($if)
        v-if="{{ $if }}"
        @endisset

        @isset($class)
        class="{{ $class }}"
        @endisset

        @isset($label)
        label="{{ ____($label) }}"
        @endisset

>
    <el-switch

        @isset($model)
        v-model="{{ $model }}"
        @endisset

        @isset($on)
        active-text="{{ ____($on) }}"
        @endisset

        @isset($off)
        inactive-text="{{ ____($off) }}"
        @endisset

    >
    </el-switch>
</el-form-item>