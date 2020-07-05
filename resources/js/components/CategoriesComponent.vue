<template>
    <div class="container">
        <modal-component :data="this.modalData" v-on:fromModal="onChildClick"></modal-component>

        <div class="row">
            <div class="col-md-6 my-auto">

                <draggable :move="onMoveCallback" class="dragArea" tag="ul" :list="categories" :group="{ name: 'g1' }">
                    <transition-group>
                    <div v-for="el in categories" :key="el.id">
                        <li @contextmenu.prevent="$refs.menu.open($event, { name: el.name, id: el.id })">
                            <p>{{ el.name }}</p>
                        </li>
                        <nested-draggable v-on:fromNested="onNestedClick" :tasks="el.children"/>
                    </div>
                    </transition-group>
                </draggable>

                <button v-if="categories.length > 0" type="button" @click="saveTree" class="btn btn-primary">Save</button>
            </div>
            <div class="col-md-6 my-auto">
                <div class="form-group">
                    <label for="category_name">Category Name</label>
                    <input required type="text" v-model="new_cat_name" class="form-control" placeholder="Category Name"
                           id="category_name">
                </div>
                <div class="form-group">
                    <label for="choose_parent_category">Select Parent Category</label>
                    <select v-model="new_cat_parent" class="form-control" id="choose_parent_category">
                        <option v-for="cat in categories" :value="cat.id" :key="cat.id">{{cat.name}}</option>
                    </select>
                </div>
                <button type="button" @click="newCategory" class="btn btn-primary">Add</button>
            </div>
        </div>

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
    import axios from "axios"
    import VueContext from 'vue-context';
    import draggable from 'vuedraggable';
    import nestedDraggable from "./Nested";
    import 'vue-context/src/sass/vue-context.scss';

    export default {
        components: {VueContext, draggable, nestedDraggable},
        data() {
            return {
                new_cat_name: '',
                new_cat_parent: '',
                categories: [],
                modalData: {},
                status: true,
            }
        },

        mounted() {
            this.getData();
        },
        methods: {
            onMoveCallback: function (evt) {
                if(evt.draggedContext.element.parent_id == null) {
                    return false;
                }
            },
            saveTree() {
                axios.post('/saveTree',{
                    categories: this.categories
                }).then((res) => {
                    // this.categories = res.data;
                });
            },
            onClick(data) {
                this.modalData = data;
            },
            getData() {
                axios.get('/getData').then((res) => {
                    this.categories = res.data;
                })
            },
            newCategory() {
                axios.post('/', {
                    category_name: this.new_cat_name,
                    category_parent: this.new_cat_parent
                }).then((res) => {
                    this.new_cat_name = '';
                    this.new_cat_parent = '';
                    this.categories = res.data;
                })
            },
            onChildClick(value) {
                this.categories = value
            },
            onNestedClick(value) {
                this.modalData = value
            }
        },
    }
</script>
