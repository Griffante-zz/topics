<template>
    <div class="row">
        <picture-top v-for="pic in pics" v-bind:key="pic.id" v-bind:picture="pic"></picture-top>
    </div>
</template>

<script>
    import PictureTop from "./PictureTop";

    const API_TOKEN = document.getElementById('api_token') ? document.getElementById('api_token').value : '';

    export default {
        name: "PicturesCollection",
        components: {PictureTop},
        mounted() {
            window.axios.interceptors.request.use(
                (config) => {

                    if (API_TOKEN) {
                        config.headers['Authorization'] = `Bearer ${ API_TOKEN }`;
                    }

                    config.headers['Accept'] = 'application/json';

                    return config;
                },

                (error) => {
                    return Promise.reject(error);
                }
            );

            if (window.location.search) {
                let uri = window.location.search.substring(1);
                let params = new URLSearchParams(uri);
                this.page = parseInt(params.get("page")) ? parseInt(params.get("page")) : 1;
            }

            let start = (this.page - 1) * 20;

            window.axios.get('http://jsonplaceholder.typicode.com/photos?_start='+start+'&_limit=20').then(({ data }) => {
                this.getPictures(data);
            });
        },
        data: function () {
            return {
                page: 1,
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
