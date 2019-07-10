<template>
    <div class="row">
        <totals v-for="pic in pics" v-bind:key="pic.id" v-bind:picture="pic._source"></totals>
    </div>
</template>

<script>
    import Totals from "./Totals";
    export default {
        name: "TotalsCollection",
        components: {Totals},
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

            window.axios.get('http://es.topics.local:9200/lastest/_search?size=20').then(({ data }) => {
                if (data.hits) {
                    this.pics = data.hits.hits;
                }
            });


        },
        data: function () {
            return {
                pics: []
            }
        },
        methods: {
            getPictures: function (pictures) {
                window.axios.get('api/favourites')
                    .then(({ data }) => {
                        let ids = data.map(item => {
                            return item.picture_id;
                        });
                        for (let i = 0; i < pictures.length; i++) {
                            let picture = pictures[i];
                            if (ids.indexOf(picture.id) > -1) {
                                picture.enabled = true;
                            }
                        }
                        this.pics = pictures;
                    });
            }
        }
    }
</script>