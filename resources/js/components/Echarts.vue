<template>
    <div class="Echarts">
        <!--<div id="main" style="width: 600px;height:400px;"></div>-->
        <div id="main"  style="width: 600px; height: 400px"></div>

    </div>
</template>

<script>
    let moment = require('moment');
    let echarts = require('echarts');
    export default {
        name: "Echarts",
        methods:{
            myEcharts(){
                this.chart =  echarts.init(document.getElementById("main"));

                var option = {
                    background:"#2c3e50",
                    title: {
                        text: 'burndown chart',
                        top:20,
                        left:"5%",
                        textStyle:{color:"#e3342f",}

                    },
                    tooltip: {
                        trigger:"axis",
                        axisPointer:{
                            lineStyle:{color:"#57617b"}
                        }
                    },
                    legend: {
                        data:['task'],
                        icon:'circle',
                        top:'12%',
                        right:"12%"

                    },
                    grid:{
                        top:100,
                        left:'2%',
                        right:'2%',
                        bottom:'2%',
                        containLabel:true
                    },

                    xAxis: {
                        // data: ["2019-11-1 08:10:20","2019-11-1 08:20:20","2019-11-1 08:30:20",
                        //     "2019-11-1 08:40:20","2019-11-1 08:50:20","2019-11-1 09:00:20"]
                        data: this.xAxis,
                        // data: this.timeArray,
                    },

                    yAxis: [{
                        type:'value',
                        name:'tasks amount',
                        axisTick:{show:true},
                        axisLine:{
                            color:"black"
                        },
                        axisLabel:{margin:10,textStyle:{fontSize:14}},
                        splitLine:{show:true, lineStyle:{color:"#47617b"}},
                        // data:10
                    }],
                    series: [{
                        name: 'task',
                        type: 'line',
                        smooth:true,
                        symbol:'circle',
                        symbolSize:5,
                        showSymbol:true,
                        lineStyle:{normal:{with:2}},
                        // areaStyle:{
                        //
                        // },

                        data: this.amountArray
                    }]
                };

                this.chart.setOption(option);
            },

        },


        data(){
          return{
              tasks:[],
              chartData:[],
              timeArray:[],
              amountArray:[],
              xAxisObjArr:[],
              xAxis:[]


          }
        },
        computed:{
            getChartData:function(){
                // this.characterData = [task.]
            },
        },
        mounted() {
            axios.get('/task').then((res)=>{
                this.tasks = res.data
                // console.log(res.data)


                this.tasks.map( (item,index)=> {
                    if(item.completed==0){

                        this.timeArray.push(item)

                        // this.amountArray.push(item.updated_at)
                    }
                })
                this.timeArray.sort((a,b)=>{
                    let  dateA = Date.parse(a.updated_at)
                    let  dateB = Date.parse(b.updated_at)
                    return dateA-dateB;
                })

                // let curDate = new Date();
                // let curDate = moment().format('yyyy-MM-DD HH:mm:ss')
                // curDate = curDate.dateFormat("yyyy-MM-dd HH:mm:ss")
                // console.log(curDate)

                // let oneHourBefore = moment().subtract(1,'hours').format('yyyy-MM-DD HH:mm:ss');
                // console.log(oneHourBefore)

                // let timeMap= new Map();
                for (let i = 0; i<60; i++){
                    let oneHourBefore = moment().subtract(i*60,'seconds').format('yyyy-MM-DD HH:mm');

                    this.xAxisObjArr.push({"time":oneHourBefore,"count":this.tasks.length})
                }
                console.log("this.tasks.length-1:", this.tasks.length-1)

                let count = this.tasks.length-1
                this.timeArray.forEach((item)=>{
                    // console.log("aaaaaa",moment(item.updated_at).format('yyyy-MM-DD HH:mm'))
                    let  time_key = moment(item.updated_at).format('yyyy-MM-DD HH:mm')
                    for(let i =0 ; i < this.xAxisObjArr.length; i++){
                        console.log(this.xAxisObjArr[i].time ,time_key)
                        this.xAxisObjArr[i].count=count;
                        console.log("this.xAxisObjArr[i].count",this.xAxisObjArr[i].count)
                        if(this.xAxisObjArr[i].time == time_key){
                            count--;
                            // this.AxisObjArr[i].count=cout;
                        }
                        // count = this.xAxisObjArr[i].count
                        console.log("count",count)
                        this.xAxisObjArr[i].count=count;
                        // console.log("1111this.xAxisObjArr[i].count:",this.xAxisObjArr[i].count)

                        // this.xAxisObjArr[i].count=this.xAxisObjArr[i].count- count;
                        console.log("this.xAxisObjArr[i].count:",this.xAxisObjArr[i].count)
                    }

                })

                console.log('===========')

                console.log(this.xAxisObjArr)
                this.xAxisObjArr.forEach((item)=>{
                    // console.log(item)

                    this.xAxis.unshift(item.time)
                    this.amountArray.unshift(this.tasks.length-item.count)

                })
                console.log(this.tasks.length)
                console.log(this.amountArray)


                this.myEcharts();
            })

        }
    }
</script>

<style scoped>

</style>