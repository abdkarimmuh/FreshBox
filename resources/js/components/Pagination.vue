<template>
    <div class="pagination-row" v-if="last_page < 5">
        <span class="pull-left" style="min-height: 40px;">Page {{current_page}} from {{last_page}}  </span>
        <span class="pull-right">
      <ul class="pagination" style="margin-top:-10px">
        <li v-for="n in last_page" v-bind:class="{ active: current_page==n }">
          <a href="#" class="links" @click.prevent="goPage(n)">{{n}}</a>
        </li>
      </ul>
    </span>
    </div>
    <div class="pagination-row" v-else>
        <span class="pull-left" style="min-height: 40px;">Page {{current_page}} from {{last_page}} </span>
        <span class="pull-right">
      <ul class="pagination" style="margin-top:-10px">
      <li v-bind:class="{ disabled: current_page==1 }">
        <a href="#" class="links" @click.prevent="goPage(1)"><i class="fa fa-fast-backward"></i></a>
      </li>
      <li v-bind:class="{ disabled: current_page==1}">
         <a href="#" class="links" @click.prevent="goPage(current_page-1)"><i class="fa fa-backward"></i></a>
      </li>

      <li v-for="n in _.range(min_page,max_page)" v-bind:class="{active: current_page == n}">
         <a href="#" class="links" @click.prevent="goPage(n)">{{n}}</a>
      </li>

      <li v-bind:class="{ disabled: current_page==last_page }">
         <a href="#" class="links" @click.prevent="goPage(current_page+1)"><i class="fa fa-forward"></i></a>
      </li>
      <li v-bind:class="{ disabled: current_page==last_page }">
        <a href="#" class="links" @click.prevent="goPage(last_page)"><i class="fa fa-fast-forward"></i></a>
      </li>
      </ul>
    </span>
    </div>
</template>

<script>
    export default {
        props: ['total', 'per_page', 'current_page', 'last_page', 'next_page_url', 'prev_page_url', 'from', 'to'],
        data() {
            return {
                n: 0,
            }

        },
        methods: {
            goPage(n) {
                this.$parent.toPage(n)
            }
        },
        computed: {
            _() {
                return _;
            },
            min_page() {
                let min_page = this.current_page - 2;
                if (min_page <= 0) {
                    return 1;
                } else if (min_page + 5 >= this.last_page) {
                    return this.last_page - 4
                } else {
                    return this.current_page - 2;
                }
            },
            max_page() {
                let max_page = this.min_page + 5;
                if (max_page > this.last_page) {
                    return this.last_page + 1
                } else {
                    return max_page
                }
            },
        }

    }
</script>
