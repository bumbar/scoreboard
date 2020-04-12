<template>
    <div>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button @click="clearSession" class="btn btn-warning m-2">Опресняване на таблото&nbsp;&nbsp;
            <i class="fa fa-refresh" aria-hidden="true"></i></button>
        <ul id="list-group">
            <li v-if="cities[index].from" :key="index" class="list-group-item" style="font-size:16px" v-for="(item, index) in cities">
                    <a :class="{ active : active_el === cities[index].from.id }"
                       :href="`/departures?from=` + cities[index].from.id"
                       @click.prevent="activate(cities[index].from.id, 'from', cities[index].from.id)"
                    >{{ cities[index].from.name }}
                    </a>
                    <div class="float-md-right">
                        <a :href="`/departures?from=` + cities[index].from.id"
                           @click.prevent="fromOrTo(cities[index].from.id, 'from', cities[index].from.id)"
                           class="btn btn-outline-info btn-sm">От
                            <span class="badge badge-info">{{ cities[index].from.count }}</span>
                        </a>

                        <a :href="`/departures?to=` + cities[index].from.id"
                           @click.prevent="fromOrTo(cities[index].from.id, 'to', cities[index].from.id)"
                           class="btn btn-outline-info btn-sm">До</a>
                    </div>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        data: () => ({
            cities: '',
            active_el:0,
        }),
        methods: {
            activate(el, query, id) {
                this.$store.dispatch('addCity', { query, id });
                this.active_el = el;
            },
            fromOrTo(el, query, id) {
                this.$store.dispatch('addFromOrToCity', { query, id });
            },
            clearSession() {
                sessionStorage.clear();
                window.location.reload();
            }
        },
        mounted() {
            if (sessionStorage.hasOwnProperty("items")) {
                const mystore = sessionStorage.getItem('items');
                this.cities = JSON.parse(mystore);
            } else {
                axios.get("/city/get-cities")
                    .then(response => {
                        sessionStorage.setItem('items', JSON.stringify(response.data.data));
                        const mystore = sessionStorage.getItem('items');
                        this.cities = JSON.parse(mystore);
                    })
                    .catch(error => {
                        console.log(error);
                    });
           }
        },
    }
</script>

<style scoped>
    ul > li:hover {
        cursor:pointer;
    }
    .active {
        color:red;
        font-weight:bold;
    }
</style>
