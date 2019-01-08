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
                                <select @change="bar" class="custom-select custom-select-lg mb-3" name="subtask" id="" v-model="currentSubTask">
                                    <option value="" disabled selected>Select subtask...</option>
                                    <option :value="k" v-for="(sg,k) in selectedGroup">{{ sg }}</option>
                                </select>
                            <div class="card-body">
                                <h5 class="text-center">Efficiency liders by tool (%)</h5>
                                <canvas id='lineChart' height="150" width="350"></canvas>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card-header">Current group</div>
                            <div class="card-body">
                                <div class="card-body current-group-box" v-for="(allGroup, key) in this.allGroups">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <a href="#" class="eye form-control group-name-btn btn btn-xs" @click.prevent="getCurrentGroupReport(parseInt(allGroup.id))">
                                                <i class="fas fa-search-plus">r</i>
                                            </a>
                                        </div>
                                        <div class="col-md-7">
                                            <div :id="key" class="card card-block p-2  badge-flex" @click.prevent="selectMainTask(key)">{{allGroup.name}}
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
                allGroups: {},
                selectedGroup:{},
                currentSubTask: '',
                chart: {},
                label: [],
                barChartData: [],
                backgroundColor: 'rgba(255, 99, 132, 0.6)',  
                errors: {},
                currentElement: '',
                barData: [],
                finalBarData: []
            }
        },
        methods:{
            selectMainTask(key){
                // this.currentElement = key
                let singleGroup = this.allGroups[key]
                let newprogresses = {}
                singleGroup.progress.forEach((element) => {
                    newprogresses[element.sub.id] = element.sub.name
                });
                this.selectedGroup = newprogresses
                if(this.currentElement != key)
                document.getElementById(this.currentElement).style.background = 'rgba(84, 255, 253, 0.6)';
                document.getElementById(key).style.background = 'rgba(253, 255, 70, 0.6)';
                this.currentElement = key
            },
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
                }).catch((errors)=>{
                    console.log(errors.response.data);
                })
            },
            getCurrentGroupReport(id){
                let url = 'http://localhost:3000/report/'+id
                axios.get(url).then((response)=>{
                    window.location.href = url
                }).catch((errors)=>{
                    console.log(errors.response.data);
                })
            },
            dataTranslate(){
                // if(this.finalBarData.length){
                    for (let i = 0; i < this.finalBarData.length; i++) {
                    console.log(this.finalBarData[i]);
                    }    
                // }                 
            },
            bar(){
                this.barChartData.length = 0;
                this.label.length = 0;
                axios.post('/bar', {'groupId': this.allGroups[this.currentElement].id, 'subTaskId': this.currentSubTask}).then((response)=>{
                    this.barData = response.data
                }).catch((response)=>{
                    console.log(errors.response.data);
                }) 
                // this.chart = document.getElementById('lineChart');        
            }
        },
        computed: {
            finak(){
                let check = 0;
                let valid = 0;
                let aspirant;
            for(let value in this.barData){
                this.label.push(Number(value));
                    for(let x in this.barData[value]){
                            if(value == this.barData[value][x].aspirant_id){
                            check += this.barData[value][x].checked;
                            valid += this.barData[value][x].quantity_of_valid;  
                            }
                        }
                        this.barChartData.push((valid/check)*100);
                        check = 0;
                        valid = 0;
                        aspirant = 0;
                    }
                return this.barChartData
            }
        },
        watch:{
            finak(value){
                var vm = this;
                vm.chart = document.getElementById('lineChart');

                let lineChart = new Chart(vm.chart, {
                    type: 'horizontalBar',
                    data: {
                        labels: vm.label,
                        datasets: [{
                            label: '# of Aspirants',
                            data: vm.barChartData,
                            backgroundColor: vm.backgroundColor, 
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    // beginAtZero: true
                                }
                            }],
                             xAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                             }]
                        }
                    }
                });
            } 
        },
        mounted() {
            EventBus.$on(this.getAllGroup(),(payload)=>{               
                this.allGroups = payload
            })
        }
    } 

   
</script>





