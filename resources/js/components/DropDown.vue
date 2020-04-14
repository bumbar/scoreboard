<template>
    <div>
        <ul>
            <li style="list-style-type: none; margin-left: -3px;">
                <button @click="clearSession" style="color: #2a9055; width: 310px" class="btn btn-warning m-1">Опресняване на таблото
                    <i class="fa fa-refresh" aria-hidden="true"></i></button>
            </li>
        </ul>

        <ul id="list-group">
            <li v-if="cities[index].from || cities[index].to" :key="index" class="list-group-item" style="font-size:16px" v-for="(item, index) in cities">

                <span v-if="cities[index].from">
                    <a :class="{ active : active_el === cities[index].from.id }"
                       :href="`/departures?from=` + cities[index].from.id"
                       @click.prevent="activate(cities[index].from.id, 'from', cities[index].from.id)"
                    >{{ cities[index].from.name }}
                    </a>
                </span>
                <span v-else>
                    <a href="#">{{ item.name }}</a>
                </span>

                    <div class="float-md-right">
                        <span v-if="cities[index].from">
                            <a :href="`/departures?from=` + cities[index].from.id"
                               @click.prevent="fromOrTo(cities[index].from.id, 'from', cities[index].from.id)"
                               class="btn btn-outline-info btn-sm" title="Тръгва">От
                                <span class="badge badge-info">{{ cities[index].from.count }}</span>
                            </a>
                        </span>
                        <span v-else>
                            <a href="#" class="btn btn-outline-info btn-sm" title="Тръгва">От</a>
                        </span>

                        <span v-if="cities[index].to">
                            <a :href="`/departures?to=` + cities[index].to.id"
                               @click.prevent="fromOrTo(cities[index].to.id, 'to', cities[index].to.id)"
                               class="btn btn-outline-info btn-sm" title="Пристига">До
                                <span class="badge badge-info">{{ cities[index].to.count }}</span>
                            </a>
                        </span>
                        <span v-else>
                            <a href="#" class="btn btn-outline-info btn-sm" title="Пристига">До</a>
                        </span>

                    </div>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        data: () => ({
            cities: '',
            active_el:0
        }),
        methods: {
            activate(el, query, id) {
                this.$store.dispatch('addCity', { query, id });
                this.active_el = el;
            },
            fromOrTo(el, query, id) {
                if (window.location.pathname === '/departures') {
                    window.location = '?' + query + '=' + id;
                }
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
