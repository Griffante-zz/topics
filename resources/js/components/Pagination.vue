<template>
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <li class="page-item"><a class="page-link" :href="previous" >Previous</a></li>
            <li class="page-item"><a class="page-link" :href="next" >Next</a></li>
        </ul>
    </nav>
</template>

<script>
    export default {
        name: "Pagination",
        beforeMount: function () {
            if (window.location.search) {
                let uri = window.location.search.substring(1);
                let params = new URLSearchParams(uri);
                this.page = parseInt(params.get("page")) ? parseInt(params.get("page")) : 1;
            }

            let next = this.page + 1;
            let previous = 1;
            if (this.page > 1) {
                previous = this.page - 1;
            }
            this.previous = window.location.pathname + '?page=' + previous;
            this.next = window.location.pathname + '?page=' + next;
        },
        data: function () {
            return {
                page: 1,
                next: '',
                previous: ''
            }
        }
    }
</script>