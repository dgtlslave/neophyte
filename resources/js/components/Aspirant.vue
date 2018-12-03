<template>
    <div class="container">
        <div class="row p-input go-back-flex">
            <div class="col-md-4">
                <h3>{{ aspirant.last_name }} {{ aspirant.first_name }}</h3>
            </div>
            
            <div class="col-md-2">
                <a href="http://localhost:3000/home" class="form-control group-name-btn btn btn-xs link-btn">
                    Go back
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 tabs-row">
                <ul class="nav nav-tabs" v-for="allTask in allTasks">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" 
                           data-toggle="dropdown" 
                           href="#" 
                           role="button" 
                           aria-haspopup="true" 
                           aria-expanded="false">{{ allTask.name }}</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" @click.prevent="showSubtask(subtask.name)" href="#" v-for="subtask in allTask.sub_task">
                                {{ subtask.name }}
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="subtask_content" v-if="this.task_content.length" v-html="this.task_content"></div>
    </div>
</template>

<script>
     import swal from 'sweetalert2'
     import axios from 'axios'
     import VueMomentLib from 'vue-moment-lib';
export default {
    props:['aspirant'],
    data(){
        return{
            allTasks: '',
            // currentDate:  Date.now(),
            currentRaiting: [],
            task_id: '',
            errors: {},
            task_content: ""
        }
    },
    methods:{
        showSubtask(subtask){
            this.task_content = '<resulttable></resulttable>'
        },
        getAllTask(){
            axios.get('/getAllTask').then((response)=>{
                this.allTasks = response.data
            }).catch((errors)=>{
                 console.log(errors.response.data)
            })
        }
    },
    mounted() {
        this.getAllTask()
    }
}

</script>