<template>
    <div>
        <div class="row g-4 mb-4">
  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>ລາຍຮັບ</span>
          </div>
          <span class="badge bg-label-primary rounded p-2">
            <i class='bx bxs-bar-chart-alt-2 bx-sm'></i>
          </span>
        </div>
        <h4 class="mb-0 me-2">{{formatPrice(data_income)}} ກີບ</h4>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>ລາຍຈ່າຍ</span>
           
          </div>
          <span class="badge bg-label-danger rounded p-2">
            <i class='bx bx-notepad bx-sm'></i>
          </span>
        </div>
        <h4 class="mb-0 me-2">{{formatPrice(data_expense)}} ກີບ</h4>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>ກຳໄລ</span>
          </div>
          <span class="badge bg-label-success rounded p-2">
            <i class='bx bxs-wallet-alt bx-sm'></i>
          </span>
        </div>
        <h4 class="mb-0 me-2">{{formatPrice(data_income-data_expense)}} ກີບ</h4>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>ສະຕ໋ອກສິນຄ້າ</span>
            
          </div>
          <span class="badge bg-label-warning rounded p-2">
            <i class='bx bxs-component bx-sm'></i>
          </span>
        </div>
         <h4 class="mb-0 me-2">{{formatPrice(data_store)}}</h4>
      </div>
    </div>
  </div>
</div>
    </div>
</template>

<script>
export default {
    name: 'Minipos8Grapdashboard',

    data() {
        return {
            data_income:[],
            data_expense:[],
            data_store:[],
        };
    },

    computed:{
        // sum_income(){
        //     return this.data_income.reduce((num,item)=> num+item.price,0);
        // },
        // sum_expense(){
        //     return this.data_expense.reduce((num,item)=> num+item.price,0);
        // },
        // sum_profit(){
        //     return this.sum_income-this.sum_expense;
        // },
        // sum_store(){
        //     return this.data_store.reduce((num,item)=> num+item.amount,0);
        // }
    },

    mounted() {
        
    },

    methods: {
        formatPrice(value) {
        let val = (value / 1).toFixed(0).replace(",", ".")
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
      },
        GetData(){
             this.$axios.get("/sanctum/csrf-cookie").then((response)=>{
                    this.$axios.get(`api/report/grapdashboard`).then((response)=>{
                    this.data_income = response.data.income;
                    this.data_expense = response.data.expense;
                    this.data_store = response.data.store;
            
                    }).catch((error)=>{
                    console.log(error);
                    });
            
                }).catch((error)=>{
                console.log(error.response.status)
            });

        }
    },
    created(){
        this.GetData()
    }
};
</script>

<style lang="scss" scoped>

</style>