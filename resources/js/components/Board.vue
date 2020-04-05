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
            </thead>
            <tbody>
                <tr :class="{ warning : warning_el[item.id] === item.id }" :key='index' v-for="(item, index) in departures">
                    <td>{{ item.from }}</td>
                    <td>{{ item.to }}</td>
                    <td>{{ $helpers.format_date(item.departure_at) }}</td>
                    <td>
                        {{ item.passengers_count }}
                    </td>
                    <td>
                            <span style="color: red">{{ freeSeats(item.places, item.passengers_count) }}</span>
                        , <span style="color: #2a9055">{{item.places}}</span>
                    </td>
                    <td>{{ diff_minutes(item.departure_at, item.id) }}</td>
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
            diff_minutes(date, el) {
                let currentDate = new Date();
                let inputDate = new Date(date);
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
