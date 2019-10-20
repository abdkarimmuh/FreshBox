<template>
    <div class="text-right">
        <nav class="d-inline-block">
            <ul class="pagination mb-0">
                <li class="page-item">
                    <a class="page-link" @click.prevent="changePage(pagination.current_page - 1)"
                       :disabled="pagination.current_page < 1" v-if="pagination.current_page > 1">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                </li>
                <li class="page-item " :class="isCurrentPage(page) ? 'active' : ''" v-for="page in pages">
                    <a class="page-link"
                       @click.prevent="changePage(page)">{{ page }}</a>
                </li>
                <li class="page-item">
                    <a class="page-link" @click.prevent="changePage(pagination.current_page + 1)"
                       :disabled="pagination.current_page >= pagination.last_page" v-if="pagination.current_page >= pagination.last_page">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
    export default {
        props: ['pagination', 'offset'],
        methods: {
            isCurrentPage(page) {
                return this.pagination.current_page === page;
            },
            changePage(page) {
                if (page > this.pagination.last_page) {
                    page = this.pagination.last_page;
                }
                this.pagination.current_page = page;
                this.$emit('paginate');
            }
        },
        computed: {
            pages() {
                let pages = [];
                let from = this.pagination.current_page - Math.floor(this.offset / 2);
                if (from < 1) {
                    from = 1;
                }
                let to = from + this.offset - 1;
                if (to > this.pagination.last_page) {
                    to = this.pagination.last_page;
                }
                while (from <= to) {
                    pages.push(from);
                    from++;
                }
                return pages;
            }
        }
    }
</script>
