<template>
    <div class="container">
        <div class="row p-input go-back-flex">
            <div class="col-md-4">
                <button @click.prevent="deleteGroup(group.id)" class="form-control btn btn-danger btn-xs">Delete group</button>
            </div>
            <div class="col-md-2">
                <a href="http://localhost:3000/home" class="form-control group-name-btn btn btn-xs link-btn">Go back</a>    
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card-header">Create new aspirant{{group.id}}</div>
                <div class="card-body">
                    <form>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <input name="group" id="group" 
                                           class="form-control group-name is-valid p-input" 
                                           type="text" 
                                           placeholder="First name ..." 
                                           required="true"
                                           v-model="aspirant.firstName">
                                </div>
                                <div class="col-md-12"></div>
                                <div class="col-md-12">
                                    <input name="group" id="group" 
                                           class="form-control group-name is-valid p-input" 
                                           type="text" 
                                           placeholder="Last name ..." 
                                           required="true"
                                           v-model="aspirant.lastName">
                                </div>
                                <div class="col-md-12 p-input">
                                    <p>Download avatar image</p>
                                </div>
                                <div class="col-md-12 p-input">
                                    <button class="form-control group-name-btn btn btn-xs" @click.prevent="createAspirant">
                                        Create
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card-header">Current aspirant</div>
                <div class="card-body">
                    <div class="card-body current-group-box" v-for="allAspirant in allAspirants">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="card card-block p-2">{{ allAspirant.last_name }} {{ allAspirant.first_name }}</div>
                            </div>
                            <div class="col-md-3">
                                <a href="#" class="eye form-control group-name-btn btn btn-xs" @click.prevent="getCurrentAspirantUrl(parseInt(allAspirant.id))">
                                    <i class="fas fa-search-plus">{{ allAspirant.id }}</i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
        </div>
        <!-- <div class="row">
            <div class="col-md-12">
                <div class="card-header">User name current result</div>
                <div class="card-body">Graf JS</div>    
            </div>
        </div> -->
    </div>
</template>

<script>
    import swal from 'sweetalert2'
    import axios from 'axios'
    import EventBus from '../app'
export default {
    props:['group'],
    data(){
        return {
            aspirant:{
                firstName: '',
                lastName: '',
            },
            allAspirants: [],
            errors: {}            
        }
    },
    methods:{
        createAspirant(){
            axios.post('/createAspirant', [this.aspirant, {'id':this.group.id}]).then((response)=>{
                if(response.data == 1){
                    swal('Success', 'Aspirant successfuly created', 'success')
                    EventBus.$emit(this.getAllAspirant(), this.allAspirants.data)
                }else if(response.data == 0){
                    swal('Error','Fill out the form to the end!','error')
                }
            }).catch((errors)=>{
                console.log(errors.response.data);
            })
        },
        getAllAspirant(){
            axios.post('/getAllAspirant', {'id':this.group.id}).then((response)=>{
                this.allAspirants = response.data
            }).catch((errors)=>{
                console.log(errors.response.data);
            })
        },
        getCurrentAspirantUrl(id){
                // console.log(window.location.pathname);
                
                let url = 'http://localhost:3000/aspirant/' + id
                // console.log(url);
                axios.get(url).then((response)=>{
                    window.location.href = url
                    console.log(response);
                }).catch((errors)=>{
                    console.log(errors.response.data);
                })
        },
        deleteGroup(id){
            let url = 'http://localhost:3000/home'
            axios.post('/deleteGroup', {'groupId': id}).then((response)=>{
                if(response.data == 1){

                    swal({
                        title: 'Are you sure?',
                        text: 'You will not be able to recover this Group data!',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!',
                        closeOnConfirm: false
                        },
                        function() {
                            swal(
                                'Deleted!',
                                'Group successfuly deleted.',
                                'success'
                                
                            );
                            // window.location.href = url
                        }).then(function(result) { 
                            if (true) { 
                           window.location.href = url 
                            } 
                        });

                    // swal('Success', 'Group successfuly deleted', 'success')
                    // window.location.href = url
                }else if(response.data == 0){
                    swal('Error','Current group does not deleted','error')
                }
            }).catch((response)=>{
                console.log(errors.response.data);
            })
        }
    },
    mounted() {
        // this.getAllAspirant();
         EventBus.$on(this.getAllAspirant(),(payload)=>{               
                this.allAspirants = payload
            })
        // this.getCurrentAspirantUrl();
    }
}
</script>

