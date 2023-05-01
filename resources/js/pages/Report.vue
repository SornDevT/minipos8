<template>
    <div class="row">
        <div class="col-md-8">
                 <div class="card">
        <div class="row">
            <div class="col-md-4">
                <h5 class="card-header">ລາຍງານ</h5>
            </div>
            <div class="col-md-8">
                <div class=" d-flex justify-content-end pt-4 pe-4 ">
                            <div class="btn-group me-2" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-secondary" @click="month_type='m'"> <i class='bx bx-chevron-right' v-if="month_type=='m'"></i> ເດືອນ</button>
                                <button type="button" class="btn btn-secondary" @click="month_type='y'"> <i class='bx bx-chevron-right' v-if="month_type=='y'"></i> ປີ</button>
                            </div>

                            <input type="date" class="form-control me-2" style="width:150px" v-model="date">
                            
                            <button type="button" class="btn rounded-pill btn-dark" @click="CreatedReport()">ສະແດງຂໍ້ມູນ</button>
                    
                        
                        </div>
            </div>

        </div>
        
        
  
  <div class="card-body">
    <div class="table-responsive text-nowrap">
    
   <LineChart :chartData="chdata" :chartOption="choption" />

    </div>
  </div>
</div>
        </div>
        <div class="col-md-4">
             <div class="card mb-4">
                    <div class="card-body">
                            <div class=" d-flex justify-content-between">
                                <span><i class='bx bxs-wallet-alt' ></i> <br> ລາຍຮັບ</span> 
                                <span>{{formatPrice(sum_income)}} ກີບ</span>
                            </div>
                </div>
            </div>
            <div class="card mb-4">
                    <div class="card-body">
                            <div class=" d-flex justify-content-between">
                                <span><i class='bx bxs-wallet-alt' ></i> <br> ລາຍຈ່າຍ</span>
                                <span>{{formatPrice(sum_expense)}} ກີບ</span>
                            </div>
                </div>
            </div>
            <div class="card">
                    <div class="card-body">
                            <div class=" d-flex justify-content-between">
                                <span><i class='bx bxs-wallet-alt' ></i> <br> ກຳໄລ</span>
                                <span> {{formatPrice(sum_profit)}} ກີບ</span>
                            </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import moment from "moment";

import { LineChart } from 'vue-chart-3';
import { Chart, registerables } from "chart.js";

Chart.register(...registerables);

export default {
    name: 'Minipos8Report',

    data() {
        return {
       
            month_type:'m',
            date:new Date().toISOString().slice(0,10),
            chdata:[],
            data_income:[],
            data_expense:[]
        };
    },

    mounted() {
    
        
    },
    components:{
        LineChart
    },
    computed:{
        sum_income(){
            return this.data_income.reduce((num,item)=> parseInt(num) + parseInt(item.price),0)
        },
        sum_expense(){
            return this.data_expense.reduce((num,item)=> parseInt(num) + parseInt(item.price),0)
        },
        sum_profit(){
            return this.sum_income-this.sum_expense
        }
    },

    methods: {
        formatPrice(value) {
        let val = (value / 1).toFixed(0).replace(",", ".")
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
      },
        CreatedReport(){
            this.$axios.get("/sanctum/csrf-cookie").then((response)=>{
                this.$axios.post(`api/report`,{
                  month_type: this.month_type,
                  date: this.date
                }).then((response)=>{
                
                this.data_income = response.data.income
                this.data_expense = response.data.expense
                this.GenGrap()

              }).catch((error)=>{
                    console.log(error)
                    // console.log(error.response.status)
                    if(error.response.status==401){
                      this.$storage.setStorageSync("vue-isLoggin",false);
                      location.reload()
                    }
              })
          })
        },
        GenGrap(){

            if(this.month_type =='m'){

            // this.key++

            let re_income = []
            let re_expense = []
            let m = this.date.split("-")[1]
            let y = this.date.split("-")[0]

            let chart_label = []

            let lastday = this.Getlastday(y,m)

            for (let i = 0; i < lastday; i++) {
                chart_label.push("ວັນທີ່ "+(i+1))
            }

            // console.log(chart_label)

            re_income = this.Get_data_chart(lastday,this.data_income) || 0;
            re_expense = this.Get_data_chart(lastday, this.data_expense) || 0;

            this.chdata = {
                labels: chart_label,
                datasets: [
                    {
                        label: 'ລາຍຮັບ',
                        fill: false,
                        borderColor: "#330011",
                        data: re_income
                    },
                    {
                        label: 'ລາຍຈ່າຍ',
                        fill: false,
                        borderColor: "#DC3912",
                        data: re_expense
                    },
                    // {
                    //     label: 'ສິນຄ້າ',
                    //     fill: false,
                    //     borderColor: "#339911",
                    //     data: re_income
                    // },
                ]
            }

            // this.update_chart = Math.floor(Math.random() * 100)

            } else {


                let re_income = []
                let re_expense = []
                let m = this.date.split("-")[1]
                let y = this.date.split("-")[0]
                let chart_label = ["ເດືອນ 1","ເດືອນ 2","ເດືອນ 3","ເດືອນ 4","ເດືອນ 5","ເດືອນ 6","ເດືອນ 7","ເດືອນ 8","ເດືອນ 9","ເດືອນ 10","ເດືອນ 11","ເດືອນ 12"]

                // let lastday = this.Getlastday(y,m)

                // for (let i = 0; i < lastday; i++) {
                //     chart_label.push("ວັນທີ່ "+(i+1))
                // }

                // console.log(chart_label)

                re_income = this.Get_data_chart_y(12,this.data_income) || 0;
                re_expense = this.Get_data_chart_y(12, this.data_expense) || 0;

                this.chdata = {
                    labels: chart_label,
                    datasets: [
                        {
                            label: 'ລາຍຮັບ',
                            fill: false,
                            borderColor: "#330011",
                            data: re_income
                        },
                        {
                            label: 'ລາຍຈ່າຍ',
                            fill: false,
                            borderColor: "#DC3912",
                            data: re_expense
                        },
                    ]
                }

                // this.update_chart = Math.floor(Math.random() * 100)

            } 

        },
        Getlastday(y,m){
			let dd = new Date(y, m , 0).getDate();
            // console.log('ວັນທີ່ສຸດທ້າຍ ຂອງເດືອນ:'+ dd)
            return dd;
        },
         Getday(value){
          return moment(value).format("DD");
        },
        Getmonth(value){
          return moment(value).format("MM");
        },
        Get_data_chart(date, data){
           //console.log(data)
          let new_db_in = [];
          let databack = [];
          for (let y = 0; y < data.length; y++) {
            if (data[y] != "") {
            let day = this.Getday(data[y].created_at);
            new_db_in.push({ price: data[y].price, day: day });
            }
          }
            //  console.log(new_db_in)
          
            let update_db_in = new_db_in.reduce((a, c) => {
              let filtered = a.filter((el) => el.day === c.day);
              if (filtered.length > 0) {
              a[a.indexOf(filtered[0])].price =
                parseInt(a[a.indexOf(filtered[0])].price) + parseInt(c.price);
              } else {
              a.push(c);
              }
              return a;
            }, []);

        //    console.log(update_db_in)

            for (let i = 0; i < date; i++) {
              let type = true;
              for (let k = 0; k < update_db_in.length; k++) {
              if (update_db_in[k].day == i + 1) {
                if (type) {
                databack.push(update_db_in[k].price);
                type = false;
                }
              }
              }
              if (type) {
              databack.push(0);
              type = false;
              }
            }

            // console.log(databack)

          return databack;
        },
         Get_data_chart_y(monthchart, data){

          let new_db_in = [];
          let databack = [];
          for (let y = 0; y < data.length; y++) {
            if (data[y] != "") {
            let month = this.Getmonth(data[y].created_at);
            new_db_in.push({ price: data[y].price, month: month });
            }
          }

          let update_db_in = new_db_in.reduce((a, c) => {
            let filtered = a.filter((el) => el.month == c.month);
            if (filtered.length > 0) {
            a[a.indexOf(filtered[0])].price =
              parseInt(a[a.indexOf(filtered[0])].price) + parseInt(c.price);
            } else {
            a.push(c);
            }
            return a;
          }, []);

          for (let i = 0; i < monthchart; i++) {
            let type = true;
            for (let k = 0; k < update_db_in.length; k++) {
            if (update_db_in[k].month == i + 1) {
              if (type) {
              databack.push(update_db_in[k].price);
              type = false;
              }
            }
            }
            if (type) {
            databack.push(0);
            type = false;
            }
          }

        //   console.log(databack)

          return databack;
          

        },
    },
    created(){
        this.CreatedReport()
    }
   
};
</script>

<style lang="scss" scoped>

</style>