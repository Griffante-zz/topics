<template>
    <div class="container">
        <div class="row justify-content-center mb-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Pictures</div>

                    <div class="card-body">
                        <pictures-collection></pictures-collection>
                    </div>
                </div>
            </div>
        </div>
        <pagination></pagination>
    </div>

</template>

<script>
    import Pagination from "./Pagination";
    import PicturesCollection from "./PicturesCollection";

    export default {
        components: {Pagination, PicturesCollection},
    }
</script>
