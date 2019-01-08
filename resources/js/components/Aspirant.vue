<template>
    <div class="container">
        <div class="row p-input go-back-flex">
            <div class="col-md-6">
                <h3>{{ aspirant.last_name }} {{ aspirant.first_name }}</h3>
            </div>
            
            <div class="col-md-2">
                <a href="http://localhost:3000/home" class="form-control group-name-btn btn btn-xs link-btn">
                    Go back
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <form>
                    <v2-datepicker v-model="val" lang="en"></v2-datepicker>
                    <select @change="getAllSubtask" class="custom-select custom-select-lg mb-3" name="task" id="" v-model="currentTask">
                        <option value="">Choose task</option>
                        <option v-for="allTask in allTasks" :value="allTask.id">{{ allTask.name }}</option>
                    </select>
                    <select @change="getCurrentSubTaskResult" class="custom-select custom-select-lg mb-3" name="subtask" id="" v-model="currentSubTask">
                        <option value="">Choose subtask</option>
                        <option v-for="allSubtask in allSubtasks" :value="allSubtask.id">{{ allSubtask.name }}</option>
                    </select>
                </form>
                <table class="table table-striped table-dark">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">#</th>
                            <th scope="col" class="text-center">Result</th>
                            <th scope="col" class="text-center">Checked</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr :id="key" v-for="(cell, key) in currentRaiting">
                            <th scope="row" class="text-center">{{ key + 1 }}</th>
                            <td class="text-center">
                                <input name="result" class="form-control group-name text-center num" type="number" v-model="cell[1]">    
                            </td>
                            <td class="text-center">{{ cell[2] }}</td>
                            <td class="text-center">
                                <button @click.prevent="delArr(key)" class="form-control btn btn-xs btn-danger del-btn">
                                    +
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button class="form-control group-name-btn btn btn-xs btn-margin" @click.prevent="addCells">Add cells</button>
                <button class="form-control group-name-btn btn btn-xs btn-margin" @click.prevent="saveResult" :disabled="!this.currentRaiting.length">Save</button>      
            </div>
            <div class="col-md-6">
                <div class="card-header">Totally by chosen tool:</div>
                <div class="card-body result-center">
                    <div class="text-center">
                        Valid: <span class="badge badge-success">{{ this.totalResult }}</span>
                    </div>
                    <div class="text-center">
                        Invalid: <span class="badge badge-danger">{{ this.totalChecked - this.totalResult }}</span>
                    </div>
                    <div class="text-center">
                        Checked: <span class="badge badge-warning">{{ this.totalChecked }}</span>
                    </div>
                    <div class="text-center">
                        Efficiency(%): <span v-if="isNaN(this.totalEfficiency)" class="badge badge-info">0</span>
                                       <span v-if="!isNaN(this.totalEfficiency)" class="badge badge-info">{{ this.totalEfficiency }}</span>
                    </div>    
                </div>
                <table class="table table-striped table-dark">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">#</th>
                            <th scope="col" class="text-center">Date</th>
                            <th scope="col" class="text-center">Result</th>
                            <th scope="col" class="text-center">Checked</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(result, key) in currentSubTaskResults">
                            <th scope="row" class="text-center">{{ key + 1 }}</th>
                            <td class="text-center">{{ timeToISO(result.check_date) }}</td>
                            <td class="text-center">{{ result.quantity_of_valid }}</td>
                            <td class="text-center">{{ result.checked }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div v-if="this.currentSubTaskResults.length">
                    <div class="card-header header-chart">Chart: {{ this.currentTask }} {{ this.currentSubTask }}</div>
                    <div class="card-body body-chart">
                        <line-chart :chart-data="data" :height="120" :options="{responsive: true, maintainAspectRation: true}"></line-chart>
                    </div>    
                </div>
            </div>
        </div>
    </div>
</template>

<script>
     import LineChart from './LineChart.js'
     import swal from 'sweetalert2'
     import axios from 'axios'
     import moment from 'moment'
     import VueMomentLib from 'vue-moment-lib';
     import Vue from 'vue';
     import V2Datepicker from 'v2-datepicker';
     import EventBus from '../app'
export default {
     components: {
        LineChart
    },
    props:['aspirant'],
    data(){
        return{
            val: '',
            allTasks: '',
            currentTask: '',
            allSubtasks: '',
            currentSubTask: '',
            currentRaiting: [],
            res: {
                valid: 0,
                checked: 0
            },
            task_id: '',
            errors: {},
            result: '',
            checked: 10,
            currentSubTaskResults: '',
            moment: '',
            totalResult: 0,
            totalChecked: 0, 
            totalEfficiency: 0,
            data: ''
        }
    },
    methods:{
         saveResult(){
            var i
            for(i = 0; i < this.currentRaiting.length; i++){
                console.log(this.currentRaiting[i]);
                if(!isNaN(parseInt(this.currentRaiting[i][1]))){
                    this.res.valid += Number(this.currentRaiting[i][1]);
                    this.res.checked += Number(this.currentRaiting[i][2]);    
                } else {
                    swal('Error','Fill all "Result" input!','error');
                    var input = document.getElementById(i);
                    input.style.backgroundColor = "rgba(250, 0, 25, 0.4)";
                    this.res.valid = 0 
                    this.res.checked = 0
                }
            }
            
            axios.post('/saveResult', [this.res, {'date': this.val},
                                                 {'aspirant': this.aspirant.id}, 
                                                 {'task': this.currentTask}, 
                                                 {'sub_task': this.currentSubTask},
                                                 {'group': this.aspirant.group_id}]).then((response)=>{
                if(response.data == 1){
                    swal('Success', 'Result successfuly saved', 'success')
                    EventBus.$emit(this.getCurrentSubTaskResult(), this.currentSubTaskResults.data)
                    // this.currentRaiting.length = 0;
                }else if(response.data == 0){
                    swal('Error','Select all options: date, task, subtask or cells','error')
                    this.res.valid = 0 
                    this.res.checked = 0
                }
            }).catch((errors)=>{
                console.log(errors.response.data)
            })
            this.currentRaiting.length = 0;
        },
        timeToISO(timestamp){
            let date = new Date(timestamp*1000);
            return date.getDate() + '-' + (date.getMonth()+1) + '-' + date.getFullYear();
        },
        delArr(key){
           this.currentRaiting.splice(key, 1)
           this.res.valid = 0 
           this.res.checked = 0
        },
        addCells(){
            this.currentRaiting.push([this.number, this.result, this.checked])
        },
        getAllTask(){
            axios.get('/getAllTask').then((response)=>{
                this.allTasks = response.data
            }).catch((errors)=>{
                 console.log(errors.response.data)
            })
        },
        getAllSubtask(){
            axios.post('/getAllSubtask', {'task': this.currentTask}).then((response)=>{
                this.allSubtasks = response.data
            }).catch((errors)=>{
                console.log(errors.response.data);
            })
        },
        getCurrentSubTaskResult(){
            axios.post('/getCurrentSubTaskResult', [{'sub_task': this.currentSubTask}, {'aspirant': this.aspirant.id}]).then((response)=>{
                this.totalResult = 0
                this.totalChecked = 0
                this.currentSubTaskResults = response.data
                this.calculateResult(this.currentSubTaskResults)
                this.calculateChecked(this.currentSubTaskResults)
                this.calculateEfficiency()
                this.update()
            }).catch((errors)=>{
                console.log(errors.response.data);
            })
        },
        calculateResult(result){
            var x
            for(x = 0; x < result.length; x++){
                this.totalResult += result[x]['quantity_of_valid']
            }
        },
        calculateChecked(checked){
            var y
            for(y = 0; y < checked.length; y++){
                this.totalChecked += checked[y]['checked']
            }
        },
        calculateEfficiency(){
            this.totalEfficiency = Number(((this.totalResult / this.totalChecked) * 100).toFixed(2))
        },
        update(){
            axios.post('/update', {'progress': this.currentSubTaskResults}).then((response)=>{
                this.data = response.data
            }).catch((response)=>{
                console.log(errors.response.data);
            })
        }
    },
    mounted() {
        this.getAllTask()
        EventBus.$on(this.getCurrentSubTaskResult(),(payload)=>{               
            this.currentSubTaskResults = payload
        })
        // this.update()
    },
    // computed: {
    //     formatted(){
    //         return Vue.filter('date')(this.result.check_date)
    //     }
    // }
}

</script>
