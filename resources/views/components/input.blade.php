@php(extract(bladeIncludeExp($exp ?? '')))
<el-form-item

    @isset($if)
        v-if="{{ $if }}"
    @endisset

    @isset($class)
        class="{{ $class }}"
    @endisset

    @isset($label)
        label="{{ $label }}"
    @endisset

>
    <el-input

        @isset($ref)
            ref="{{ $ref }}"
        @endisset

        @isset($model)
            v-model="{{ $model }}"
        @endisset

        @isset($value)
            :value="{{ $value }}"
        @endisset

        @isset($type)
            type="{{ $type }}"
        @endisset

        @isset($disabled)
            disabled
        @endisset

        @isset($change)
            @change="{{ $change }}"
        @endisset

    >

        @isset($pre)
            <template slot="prepend">{{ $pre }}</template>
        @endisset

    </el-input>
</el-form-item>