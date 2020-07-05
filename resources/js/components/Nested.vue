<template>
    <draggable class="dragArea" tag="ul" :list="tasks" :group="{ name: 'g1' }">
        <li v-for="el in tasks" :key="el.name">
            <p>{{ el.name }}</p>
        </li>
    </draggable>
</template>
<script>
    import draggable from "vuedraggable";

    export default {
        props: {
            tasks: {
                required: true,
            }
        },
        components: {
            draggable
        },
        name: "nested-draggable"
    };
</script>
<style scoped>

</style>
