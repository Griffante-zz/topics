<template>
    <div class="col-md-3 mb-3">
        <img :src="picture.thumbnailUrl" :alt="picture.title" />
        <div class="custom-control custom-checkbox" >
            <input type="checkbox" class="custom-control-input" v-model="picture.enabled" v-on:change="toggleFavourite(picture)" :id="picture.id">
            <label class="custom-control-label" :for="picture.id">Favourite</label>
        </div>
    </div>
</template>

<script>
    const API_TOKEN = document.getElementById('api_token') ? document.getElementById('api_token').value : '';

    export default {
        name: "PictureTop",
        props: ['picture'],
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
        },
        methods: {
            toggleFavourite: function (picture) {
                let data = {
                    picture_id: picture.id,
                    enabled: picture.enabled
                };

                window.axios.post('api/favourites', data)
                .then(({ data }) => {
                    picture.favourite_id = data.id;
                });
            }
        }
    }
</script>