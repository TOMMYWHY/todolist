<template>
    <div class="Echarts">
        <!--<div id="main" style="width: 600px;height:400px;"></div>-->
        <div id="main"  style="width: 600px; height: 400px"></div>

    </div>
</template>

<script>

    export default {
        name: "Echarts",
        methods:{
            myEcharts(){
                console.log(echarts)
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
                        data: ["2019-11-1 08:10:20","2019-11-1 08:20:20","2019-11-1 08:30:20",
                            "2019-11-1 08:40:20","2019-11-1 08:50:20","2019-11-1 09:00:20"]
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
                    }],
                    series: [{
                        name: 'task',
                        type: 'line',
                        smooth:true,
                        symbol:'circle',
                        symbolSize:5,
                        showSymbol:true,
                        lineStyle:{normal:{with:2}},
                        areaStyle:{

                        },
                        data: [2, 1, 5, 1, 10, 3]
                    }]
                };

                this.chart.setOption(option);
            },

        },


        data(){
          return{
              tasks:[],
          }
        },
        mounted() {

            this.myEcharts();
        }
    }
</script>

<style scoped>

</style>