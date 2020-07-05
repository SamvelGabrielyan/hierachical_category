<template>
    <div>
        <draggable class="dragArea" tag="ul" :list="tasks" :group="{ name: 'g1' }">
            <div v-for="el in tasks" :key="el.name">
                <li @contextmenu.prevent="$refs.menu.open($event, { name: el.name, id: el.id })">
                    <p>{{ el.name }}</p>
                </li>
            </div>
        </draggable>

        <vue-context ref="menu">
            <template slot-scope="child" v-if="child.data">
                <li>
                    <a @click.prevent="onClick(child.data)" data-toggle="modal" data-target="#myModal">
                        Edit Name
                    </a>
                </li>
            </template>
        </vue-context>
    </div>
</template>
<script>
    import draggable from "vuedraggable";
    import VueContext from 'vue-context';

    export default {
        props: {
            tasks: {
                required: true,
            }
        },
        components: {
            draggable,
            VueContext
        },
        methods: {
            onClick(data) {
                this.$emit('fromNested',data)
            },
        },
        name: "nested-draggable"
    };
</script>
<style scoped>

</style>
