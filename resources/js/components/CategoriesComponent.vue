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
                        <nested-draggable :tasks="el.children"/>
                    </div>
                    </transition-group>
                </draggable>

                <button type="button" @click="saveTree" class="btn btn-primary">Save</button>
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
        // watch: {
        //     categories(newValue, oldValue) {
        //         // console.log('FROM WATCHER', newValue);
        //     }
        // },
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


            allowDrag(model, component) {
                console.log(model);
                if (model.parent_id === null) {
                    // can't be dragged
                    return false;
                }
                // can be dragged
                return true;
            },
            allowDrop(model, component) {
                if (model.name === 'Node 2-2') {
                    // can't be placed
                    return false;
                }
                // can be placed
                return true;
            },
            curNodeClicked(model, component) {
                // console.log('curNodeClicked', model, component);
            },
            dragHandler(model, component, e) {
                // console.log('dragHandler: ', model, component, e);
            },
            dragEnterHandler(model, component, e) {
                // console.log('dragEnterHandler: ', model, component, e);
            },
            dragLeaveHandler(model, component, e) {
                // console.log('dragLeaveHandler: ', model, component, e);
            },
            dragOverHandler(model, component, e) {
                // console.log('dragOverHandler: ', model, component, e);
            },
            dragEndHandler(model, component, e) {
                // console.log('dragEndHandler: ', model, component, e);
            },
            dropHandler(model, component, e) {
                // console.log('dropHandler: ', model, component, e);
            }
        },
    }
</script>
