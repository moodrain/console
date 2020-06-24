selectChange (selects) { this.selects = selects },
more() { if(this.doMore) { this.doMore() } },
doDelete(id) {
    console.log(this.selects)
    if(this.selects.length > 0) {
        this.$confirm('Confirm to Delete ' + this.selects.length + ' {{ $m }} ?', 'Confirm', {
            confirmButtonText: 'Ok',
            cancelButtonText: 'No',
            type: 'warning',
        }).then(() => {
            let ids = []
            this.selects.forEach(e => ids.push(e.id))
            $submit('/{{ $m }}/destroy', {ids})
        }).catch(() => {})
    } else {
        this.$confirm('Confirm to Delete a {{ $m }} ?', 'Confirm', {
            confirmButtonText: 'Ok',
            cancelButtonText: 'No',
            type: 'warning',
        }).then(() => {
            $submit('/{{ $m }}/destroy', {id})
        }).catch(() => {})
    }
},