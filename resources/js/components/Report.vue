<template>
    <div class="container">
        <div class="row p-input go-back-flex">
            <div class="col-md-2">
                <a href="http://localhost:3000/home" class="form-control group-name-btn btn btn-xs link-btn">Go back</a>    
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <div class="card-header">Query conditions</div>
                <div class="card-body">
                    <form class="form">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-8 offset-md-1">
                                        Complete group    
                                    </div>
                                    <div class="col-md-3">
                                        <input @change="changeCompleteGroup" :value="true" type="checkbox" v-model="checkedAllAspirant">
                                    </div>     
                                </div>
                                <div v-if="!checkedAllAspirant[0] == true" class="report-flex" v-for="aspirant in allAspirant">
                                        <div class="row">
                                            <div class="col-md-8 offset-md-1">
                                                  {{ aspirant.last_name }} {{ aspirant.first_name }}      
                                            </div>
                                            <div class="col-md-3">
                                                <input :value="aspirant.id" type="checkbox" v-model="checkedAspirant">
                                            </div>     
                                        </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div v-if="!checkedAllTask[0] == true">
                                            <select @change="reportSubTaskFun" class="custom-select custom-select-lg mb-3" name="task" v-model="reportCurrentTask">
                                                <option value="">Choose task</option>
                                                <option v-for="task in reportTask" :value="task.task_id">{{ task.task.name }}</option>
                                            </select>
                                            <select class="custom-select custom-select-lg mb-3" name="subtask" v-model="reportCurrentSubTask">
                                                <option value="">Choose subtask</option>
                                                <option v-for="subtask in reportSubTask" :value="subtask.id">{{ subtask.name }}</option>
                                            </select>    
                                        </div>
                                    </div>
                                    <div v-if="!reportCurrentTask" class="col-md-8 offset-md-1">
                                        All tools    
                                    </div>
                                    <div v-if="!reportCurrentTask" class="col-md-3">
                                        <input @change="changeAllTools" :value="true" type="checkbox" v-model="checkedAllTask">
                                    </div>      
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <v2-datepicker-range v-model="val" lang="en" format="yyyy-MM-DD"></v2-datepicker-range>     
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card-header">Report action</div>
                <div class="card-body">
                    <div v-if="runResult">
                        <transition name="fade">
                            <button @click.prevent="queryRun" class="form-control group-name btn-run group-name-btn btn btn-xs">Run</button>
                        </transition>    
                    </div>
                    <div v-if="!runResult">
                        <transition name="fade">
                            <button class="form-control group-name group-name-btn btn btn-xs">Save xls</button>
                            <button class="form-control group-name group-name-btn btn btn-xs">Save HTML</button>
                            <button class="form-control group-name group-name-btn btn btn-xs">Sent to email</button>
                            <button class="form-control group-name group-name-btn btn-reset btn btn-xs">Reset</button>    
                        </transition>
                    </div>
                </div>
            </div>
        </div>
        <div class="delimiter"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="card-header">Report</div>
                <div class="card-body">
                    xxx
                </div>
            </div>
        </div>
        <div class="delimiter"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="card-header">Mailing options</div>
                <div class="card-body">
                    xxx
                    <form>

                    </form>
                </div>
            </div>
        </div>
        <div class="delimiter"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="card-header">Scheduled Mailing</div>
                <div class="card-body">
                    xxx
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue';
    import V2Datepicker from 'v2-datepicker';
    import axios from 'axios'
    import swal from 'sweetalert2'
export default {
    props:['group'],
    data(){
        return{
            val: '',
            allAspirant: '',
            checkedAspirant: [],
            checkedAllAspirant: [],
            checkedAllTask: [],
            reportTask: [],
            reportCurrentTask: '',
            reportSubTask: [],
            reportCurrentSubTask: '',
            runResult: [],
            errors: []
        }
    },
    methods:{
        getAllAspirantReport(){
            axios.post('/getAllAspirantReport', {'id': this.group.id}).then((response)=>{
                this.allAspirant = response.data
            }).catch((errors)=>{
                console.log(errors.response.data);
            })
        },
        reportTaskFun(){
            axios.post('/reportTaskFun', {'group_id': this.group.id}).then((response)=> {
                this.reportTask = response.data
            }).catch((errors)=>{
                console.log(errors.response.data);
            })
        },
        changeCompleteGroup(){
            this.checkedAspirant.length = 0; 
        },
        changeAllTools(){
            this.reportCurrentSubTask = '';
            this.reportCurrentTask = ''; 
        },
        reportSubTaskFun(){
            axios.post('/reportSubTaskFun', {'task_id': this.reportCurrentTask}).then((response)=>{
                this.reportSubTask = response.data
            }).catch((errors)=>{
                console.log(errors.response.data);
            })
        },
        queryRun(){
            axios.post('/queryRun', [{'task': this.reportCurrentTask},
                                     {'subTask': this.reportCurrentSubTask},
                                     {'allTools': this.checkedAllTask},
                                     {'aspirant': this.checkedAspirant},
                                     {'allAspirant': this.checkedAllAspirant},
                                     {'dateRange': this.val}
            ]).then((response)=>{
                this.runResult = response.data
            }).catch((errors)=>{
                console.log(errors.response.data);
            })
        }
    },
    mounted() {
        this.reportTaskFun()
        this.getAllAspirantReport()
    },
}
</script>

