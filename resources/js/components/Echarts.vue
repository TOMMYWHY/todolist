<template>
    <div class="Echarts">
        <div v-if="this.tasks.length" id="main" class="col-md-12" style=" height: 400px"></div>

    </div>
</template>

<script>
    let moment = require('moment');
    let echarts = require('echarts');
    export default {
        name: "Echarts",
        methods: {
            myEcharts() {
                this.chart = echarts.init(document.getElementById("main"));

                var option = {
                    background: "#2c3e50",
                    title: {
                        text: 'burndown chart',
                        top: 20,
                        left: "5%",
                        textStyle: {color: "#e3342f",}

                    },
                    tooltip: {
                        trigger: "axis",
                        axisPointer: {
                            lineStyle: {color: "#57617b"}
                        }
                    },
                    legend: {
                        data: ['task'],
                        icon: 'circle',
                        top: '12%',
                        right: "12%"

                    },
                    grid: {
                        top: 100,
                        left: '2%',
                        right: '2%',
                        bottom: '2%',
                        containLabel: true
                    },

                    xAxis: {
                        data: this.xAxis,
                    },

                    yAxis: [{
                        type: 'value',
                        name: 'tasks amount',
                        max: this.tasks.length + 1,
                        min: 0,
                        interval: 5,
                        axisTick: {show: true},
                        axisLine: {
                            color: "black"
                        },
                        axisLabel: {margin: 10, textStyle: {fontSize: 14}},
                        splitLine: {show: true, lineStyle: {color: "#47617b"}},
                    }],
                    series: [{
                        type: 'line',
                        smooth: true,
                        symbol: 'circle',
                        symbolSize: 5,
                        showSymbol: true,
                        lineStyle: {normal: {with: 2}},
                        data: this.amountArray
                    }]
                };

                this.chart.setOption(option);
            },

        },

        data() {
            return {
                tasks: [],
                chartData: [],
                timeArray: [],
                amountArray: [],
                xAxisObjArr: [],
                xAxis: []
            }
        },

        mounted() {
            axios.get('/task').then((res) => {
                this.tasks = res.data
                this.tasks.map((item, index) => {
                    if (item.completed == 0) {
                        this.timeArray.push(item)
                    }
                })
                this.timeArray.sort((a, b) => {
                    let dateA = Date.parse(a.updated_at)
                    let dateB = Date.parse(b.updated_at)
                    return dateA - dateB;
                })

                this.xAxisObjArr.push({"time": moment().format('yyyy-MM-DD HH:mm'), "count": this.tasks.length})

                for (let i = 0; i < 59; i++) {
                    let oneHourBefore = moment().subtract(i * 60, 'seconds').format('yyyy-MM-DD HH:mm');
                    this.xAxisObjArr.push({"time": oneHourBefore, "count": this.tasks.length})
                }
                console.log('------')
                this.xAxisObjArr.forEach((item) => {
                    item.count=100
                })
                console.log(this.xAxisObjArr)
                let count = this.tasks.length - 1
                this.timeArray.forEach((item) => {
                    let time_key = moment(item.updated_at).format('yyyy-MM-DD HH:mm')
                    for (let i = 0; i < this.xAxisObjArr.length; i++) {
                        this.xAxisObjArr[i].count = count;
                        if (this.xAxisObjArr[i].time == time_key) {
                            count--;
                        }
                        this.xAxisObjArr[i].count = count;
                    }
                })
                this.xAxisObjArr.forEach((item) => {
                    this.xAxis.unshift(item.time)
                    this.amountArray.unshift(this.tasks.length - item.count)
                })
                this.myEcharts();
            })

        }
    }
</script>

<style scoped>

</style>