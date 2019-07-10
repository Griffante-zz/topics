<template>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <user v-for="user in users" v-bind:key="user.id" v-bind:user="user._source"></user>
        </tbody>
    </table>
</template>

<script>
    import User from "./User";
    export default {
        name: "UsersCollection",
        components: {User},
        mounted() {

            window.axios.interceptors.request.use(
                (config) => {

                    config.headers['Access-Control-Allow-Origin'] = '*';

                    return config;
                },

                (error) => {
                    return Promise.reject(error);
                }
            );

            window.axios.get('http://es.topics.local:9200/users/_search?size=20').then(({ data }) => {
                if (data.hits) {
                    this.users = data.hits.hits;
                }
            });


        },
        data: function () {
            return {
                users: []
            }
        },
    }
</script>