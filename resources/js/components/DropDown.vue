<template>
    <div>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button @click="clearSession" class="btn btn-warning m-2">Опресняване на таблото&nbsp;&nbsp;
            <i class="fa fa-refresh" aria-hidden="true"></i></button>
        <ul id="list-group">
            <li v-if="cities[index].relationCityWithDepartures" :key="index" class="list-group-item" style="font-size:16px" v-for="(item, index) in cities">
                    <a :class="{ active : active_el === cities[index].relationCityWithDepartures.id }"
                       :href="`/departures?from=` + cities[index].relationCityWithDepartures.id"
                       @click.prevent="activate(cities[index].relationCityWithDepartures.id, 'from', cities[index].relationCityWithDepartures.id)"
                    >{{ cities[index].relationCityWithDepartures.name }}
                    </a>
                    <div class="float-md-right">
                        <a :href="`/departures?from=` + cities[index].relationCityWithDepartures.id"
                           @click.prevent="fromOrTo(cities[index].relationCityWithDepartures.id, 'from', cities[index].relationCityWithDepartures.id)"
                           class="btn btn-outline-info btn-sm">От</a>
                        <a :href="`/departures?to=` + cities[index].relationCityWithDepartures.id"
                           @click.prevent="fromOrTo(cities[index].relationCityWithDepartures.id, 'to', cities[index].relationCityWithDepartures.id)"
                           class="btn btn-outline-info btn-sm">До</a>
                            &nbsp;<span class="badge badge-info"> {{ cities[index].relationCityWithDepartures.count }} </span>
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
