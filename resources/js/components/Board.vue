<template>
    <div>
        <table class="table">
            <thead>
            <th>От</th>
            <th>До</th>
            <th>Заминаване</th>
            <th>Пътници брой</th>
            <th>Свободни места<br>
            [свободни / налични]
            </th>
            <th>Оставащо време</th>
            <th>Закъснение</th>
            </thead>
            <tbody>
                <tr :class="{ warning : warning_el[item.id] === item.id }" :key='index' v-for="(item, index) in departures">
                    <td>{{ item.from }}</td>
                    <td>{{ item.to }}</td>
                    <td>
                        <span v-if="!hasDelayedAt(item.delayed_at)">
                            <span style="color: red">{{ diff_delay_departure_in_minutes(item.departure_at, item.delayed_at) }}</span>
                            <br>
                            <span style="font-size: x-small">{{ $helpers.format_date(item.departure_at) }}</span>
                        </span>
                        <span v-else>
                            <span>{{ $helpers.format_date(item.departure_at) }}</span>
                        </span>
                    </td>
                    <td>
                        {{ item.passengers_count }}
                    </td>
                    <td>
                            <span style="color: red">{{ freeSeats(item.places, item.passengers_count) }}</span>
                        , <span style="color: #2a9055">{{item.places}}</span>
                    </td>
                    <td>{{ diff_minutes(item.departure_at, item.delayed_at, item.id) }}</td>
                    <td>{{ getMinutesBetweenDates(item.departure_at, item.delayed_at) }}</td>
                </tr>
            </tbody>
        </table>

        <ul>
            <li v-for="(item, index) in cities" :key="index">
                {{ item }}
            </li>
        </ul>

    </div>
</template>

<script>
    export default {
        data: () => ({
            departures: '',
            interval: '',
            warning_el: [],
        }),
        mounted() {
            this.loadData();
        },
        computed: {
            cities() {

                let city = this.$store.state.cities;
                let query = this.$store.state.query;

                axios.get("/departures?"+ query +"=" + city)
                    .then(response => {
                        this.departures = response.data.data;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        },
        methods: {
            freeSeats(places, seating) {
                return places - seating;
            },
            hasDelayedAt(delayed_at) {
                return delayed_at === null;
            },
            diff_delay_departure_in_minutes(departure_at, delayed_at) {
                if (delayed_at === null) {
                    return this.$helpers.format_date(departure_at);
                }
                return this.$helpers.format_date(delayed_at);
            },
            getMinutesBetweenDates(departure_at, delayed_at) {
                if (delayed_at) {
                    let delay = new Date(delayed_at);
                    let departure = new Date(departure_at);

                    let diff = (delay.getTime() - departure.getTime()) / 1000;
                    diff /= 60;
                    return Math.abs(Math.round(diff)) + ' мин.';
                }
            },
            diff_minutes(departure_at, delayed_at, el) {
                let currentDate = new Date();

                let inputDate = delayed_at ? new Date(delayed_at) : new Date(departure_at);

                let diff = (inputDate.getTime() - currentDate.getTime()) / 1000;
                diff /= 60;

                if (Math.abs(Math.round(diff)) <= 5) {
                    this.warning_el[el] = el;
                }

                return this.$helpers.timeConvert(Math.abs(Math.round(diff)));
            },
            loadData() {
                axios.get("/departures")
                    .then(response => {
                        this.departures = response.data.data;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
        },
        created() {
            this.loadData();

            this.interval = setInterval(() => {
                this.loadData();
            }, 30000);
        },

        beforeDestroy() {
            clearInterval(this.interval);
        }
    }
</script>

<style scoped>
    .active {
        color:red;
        font-weight:bold;
    }
    .warning {
        color: #ED4F32;
        font-weight: bold
    }
</style>
