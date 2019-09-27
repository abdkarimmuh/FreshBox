<template>
    <nav class="row">
        <div class="col-md-6 text-left">
            <span>
                &nbsp;Showing&nbsp;
                    {{pagination.from}}
                &nbsp;to&nbsp;
                    {{pagination.to}}
                &nbsp;of&nbsp;
                    {{ pagination.total }}
                &nbsp;Entries&nbsp;
            </span>
        </div>
        <div class="col-md-6 text-right">
            <button
                v-if="pagination.prev"
                :class="buttonClasses"
                @click="$emit('prev', pagination.prev)">
                <i class="fa fa-chevron-left" aria-hidden="true"></i>
                &nbsp;Prev
            </button>
            <button
                v-else
                :disabled="true"
                :class="buttonClasses"
                @click="$emit('prev', pagination.prev)">
                <i class="fa fa-chevron-left" aria-hidden="true"></i>
                &nbsp;Prev
            </button>
            <button
                v-if="pagination.next"
                :class="buttonClasses"
                @click="$emit('next', pagination.next)">
                Next&nbsp;
                <i class="fa fa-chevron-right" aria-hidden="true"></i>
            </button>
            <button
                v-else
                :disabled="true"
                :class="buttonClasses">
                Next&nbsp;
                <i class="fa fa-chevron-right" aria-hidden="true"></i>
            </button>
        </div>
    </nav>
</template>

<script>
    export default {
        props: ['pagination'],
        data() {
            return {
                buttonClasses: 'btn btn-primary'
            }
        }
    }
</script>
