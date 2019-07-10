<template>
    <tr>
        <td>{{ user.name }}</td>
        <td>{{ user.total }}</td>
    </tr>
</template>

<script>
    export default {
        name: "User",
        props: ['user'],
    }
</script>