<template>
    <div class="col-md-3 mb-3">
        <img :src="picture.thumbnailUrl" :alt="picture.title" />
    </div>
</template>

<script>
    export default {
        name: "Totals",
        props: ['picture'],
    }
</script>