<template>
    <div class="container">
        <div class="row justify-content-center mb-3">
            <div class="col-md-12">
                <div class="card" v-if="is_weekend">
                    <div class="card-header">Top Users</div>

                    <div class="card-body">
                        <users-collection></users-collection>
                    </div>
                </div>

                <div class="card" v-else>
                    <div class="card-header">Favourite Pictures</div>

                    <div class="card-body">
                        <totals-collection></totals-collection>
                    </div>
                </div>

            </div>
        </div>
    </div>

</template>

<script>
    import TotalsCollection from "./TotalsCollection";
    import UsersCollection from "./UsersCollection";

    export default {
        name: 'HomeDefault',
        components: {UsersCollection, TotalsCollection},
        data: function () {
            return {
                is_weekend: false,
            }
        },
        beforeMount: function () {
            let today = new Date();
            let day = today.getDay();
            this.is_weekend = (day == 0) || (day == 6);
        },
    }
</script>
