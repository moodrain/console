@extends('layout.app')

@section('title', 'Word Read GUI')

@section('html')
<div class="container" id="app">
    <el-row>
        <el-col :xs="24" :lg="{span:8,offset:8}">
            <br />
            <el-card>
                <el-form>
                    <el-form-item>
                        <el-input v-model="form.text">
                            <template slot="prepend">Text</template>
                            <template slot="append">
                                <el-button @click="generate" slot="append" icon="el-icon-caret-right"></el-button>
                            </template>
                        </el-input>
                    </el-form-item>
                    @if(request('text'))
                        @php($url = url('wr') . '/' . base64_encode(request('text')))
                        <el-form-item>
                            <el-input :value="'{{ $url }}'">
                                <template slot="append">
                                    <el-button class="clipboard-btn" icon="el-icon-document" data-clipboard-text="{{ $url }}"></el-button>
                                </template>
                            </el-input>
                        </el-form-item>
                    @endif
                </el-form>
            </el-card>
        </el-col>
    </el-row>
</div>
@endsection

@section('js')
@include('layout.js')
<script>
let vue = new Vue({
    el: '#app',
    data() {
        return {
            form: {
                text: '{{ request('text') }}',
            }
        }
    },
    methods: {
        generate() {
            this.$to(this.form)
        }
    }
})
$enter(e => vue.generate())
</script>
@endsection

@section('css')
    @include('layout.css')
@endsection