selectChange (selects) { this.selects = selects },
more() { if(this.doMore) { this.doMore() } },
doDelete(id) {
    if(this.selects.length > 0) {
        this.$confirm('{{ ____('confirm delete') }} ' + this.selects.length + ' {{ ___($mBase) }} ?', '{{ ___('confirm') }}', {
            confirmButtonText: '{{ ___('confirm') }}',
            cancelButtonText: '{{ ___('cancel') }}',
            type: 'warning',
        }).then(() => {
            let ids = []
            this.selects.forEach(e => ids.push(e.id))
            $submit('/{{ $prefix }}destroy', {ids})
        }).catch(() => {})
    } else {
        this.$confirm('{{ ____('confirm delete ' . $mBase) }} ?', '{{ ___('confirm') }}', {
            confirmButtonText: '{{ ___('confirm') }}',
            cancelButtonText: '{{ ___('cancel') }}',
            type: 'warning',
        }).then(() => {
            $submit('/{{ $prefix }}destroy', {id})
        }).catch(() => {})
    }
},