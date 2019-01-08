<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <line-chart :chart-data="data" :height="120" :options="{responsive: true, maintainAspectRation: true}"></line-chart>
            </div>
        </div>
    </div>
</template>

<script>
    import LineChart from './LineChart.js'
    import axios from 'axios'
    import EventBus from '../app'
export default {
    props:['progress'],
    components: {
        LineChart
    },
    data(){
        return{
            data: []
        }
    },
    methods:{
        // update(){
        //     axios.post('/update', {'progress': this.currentSubTaskResults}).then((response)=>{

        //     }).catch((response)=>{
        //         console.log(errors.response.data);
        //     })
        // }
        update(){
            axios.post('/update').then((response)=>{
                this.data = response.data
            })
        }
    },
    mounted() {
        this.update()
    }
}
</script>

