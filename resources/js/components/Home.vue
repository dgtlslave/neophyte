<template>
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="card-header">Create new group</div>
                    <div class="card-body">
                        <form class="form">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-9">
                                        <input name="group" id="group" class="form-control group-name is-valid" type="text" placeholder="Set group name ..." v-model="group" required="true">
                                        <transition name="slide-fade">
                                            <div class="card card-block info-card text-center" v-if="!group">Required field for new group</div>
                                        </transition>
                                        <!-- <transition name="slide-fade">
                                            <div v-if="group!=''" class="card card-block aspirant">
                                                <input class="form-control first-name" type="text" placeholder="Aspirant first name ...">
                                                <input class="form-control second-name" type="text" placeholder="Aspirant second name ...">
                                                <button class="form-control aspirant-name-btn btn btn-xs" @click.prevent="addAspirant">+</button>
                                            </div>
                                            
                                        </transition> -->
                                    </div>
                                    <div class="col-md-3">
                                        <button class="form-control group-name-btn btn btn-xs" @click.prevent="saveGroup">Create</button>   
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="padding col-md-12"></div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card-header">Group progress diagram</div>
                            <div class="card-body">
                                Graf js diagrame
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card-header">Current group</div>
                            <div class="card-body">
                                <div class="card-body current-group-box" v-for="allGroup in this.allGroups">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="card card-block p-2 badge-flex">{{allGroup.name}}
                                                <span v-if="allGroup.aspirant.length" class="badge badge-danger">{{ allGroup.aspirant.length }}</span>
                                                <span v-if="!allGroup.aspirant.length" class="badge badge-success">New</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <a href="#" class="eye form-control group-name-btn btn btn-xs" @click.prevent="getCurrentGroup(parseInt(allGroup.id))">
                                                <i class="fas fa-search-plus">{{allGroup.id}}</i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="padding col-md-12"></div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card-header">Group record</div>
                            <div class="card-body">
                                                Group record list
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card-header">Personal record</div>
                            <div class="card-body">
                                        Personl record list
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card-header">Personal anti-record</div>
                            <div class="card-body">
                                        Personal anti-record
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
    import swal from 'sweetalert2'
    import axios from 'axios'
    import EventBus from '../app'

    export default {
        data(){
            return {
                group: '',
                allGroups: '',
                errors: {}
            }
        },
        methods:{
            saveGroup(){
                axios.post('saveGroup', {'group':this.group}).then((response)=>{
                    if(response.data == 1){
                        swal('Success', 'Group successfuly created', 'success')
                        EventBus.$emit(this.getAllGroup(), this.allGroups.data)
                    }else if(response.data == 0){
                        swal('Error','Something is wrong...','error')
                    }
                }).catch((errors)=>{
                    this.errors = errors.response.data.errors
                })
            },

            getAllGroup(){
                axios.get('getAllGroup').then((response)=>{
                    this.allGroups = response.data
                }).catch((errors)=>{
                    console.log(errors.response.data);
                })
            },
            getCurrentGroup(id){
                let url = 'http://localhost:3000/group/'+id
                axios.get(url).then((response)=>{
                    window.location.href = url
                    console.log(response);
                }).catch((errors)=>{
                    console.log(errors.response.data);
                })
            }
        },
        mounted() {
            // this.getAllGroup();
            EventBus.$on(this.getAllGroup(),(payload)=>{               
                this.allGroups = payload
            })
        }
    }
</script>

