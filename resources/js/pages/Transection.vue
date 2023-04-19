<template>
    <div class="card">
        <div class="row">
            <div class="col-md-6">
                <h5 class="card-header">ການເຄື່ອນໄຫວ ທຸລະກຳ</h5>
            </div>
            <div class="col-md-6">
                <div class=" d-flex justify-content-end pt-4 pe-4 ">
                                <!-- {{date}} -->
                                <!-- {{month_type}} -->
                            <div class="btn-group me-2" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-secondary" @click="month_type='m'"> <i class='bx bx-chevron-right' v-if="month_type=='m'"></i> ເດືອນ</button>
                                <button type="button" class="btn btn-secondary" @click="month_type='y'"> <i class='bx bx-chevron-right' v-if="month_type=='y'"></i> ປີ</button>
                            </div>

                            <input type="date" class="form-control me-2" style="width:150px" v-model="date">
                            
                            <button type="button" class="btn rounded-pill btn-dark" @click="getTran()">ສະແດງຂໍ້ມູນ</button>
                    
                        
                        </div>
            </div>

        </div>
        
        
  
  <div class="card-body">
    <div class="table-responsive text-nowrap">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th width="122" class="text-center">ວັນທີ່</th>
            <th width="122" class="text-center">ເລກທີ່ທຸລະກຳ</th>
            <th width="122" class="text-center">ປະເພດທຸລະກຳ</th>
            <th class="text-center">ລາຍລະອຽດ</th>
            <th width="180" class="text-center">ມູນຄ່າ</th>
          </tr>
        </thead>
        <tbody>
            <tr v-for="list in Transection.data" :key="list.id">
                <td>{{ date_format(list.created_at) }}</td>
                <td>{{ list.tran_id }}</td>
                <td>{{ list.tran_type }}</td>
                <td>{{ list.tran_detail }}</td>
                <td  class="text-end">{{ formatPrice(list.price) }} ກີບ</td>
            </tr>
         
          
        </tbody>
      </table>
      <pagination :pagination="Transection" :offset="4" @paginate="getTran($event)" /> 
    </div>
  </div>
</div>
</template>

<script>

import moment from "moment"

export default {
    name: 'Minipos8Transection',

    data() {
        return {
            Transection:[],
            month_type:'m',
            date:new Date().toISOString().slice(0,10),
        };
    },

    mounted() {
        
    },

    methods: {
        formatPrice(value) {
        let val = (value / 1).toFixed(0).replace(",", ".")
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
      },
        date_format(value){
            return moment(value).format("DD/MM/YYYY")
        },
         getTran(page){
          this.$axios.get("/sanctum/csrf-cookie").then((response)=>{
              this.$axios.post(`api/transection?page=${page}`,{
                month_type: this.month_type,
                date: this.date
              }).then((response)=>{
                  this.Transection = response.data;
              }).catch((error)=>{
                console.log(error)
                // console.log(error.response.status)
                if(error.response.status==401){
                   this.$storage.setStorageSync("vue-isLoggin",false)
                  window.location.reload()
                }
              })
           })

        }
    },
    created(){
        this.getTran()
    }
  
};
</script>

<style lang="scss" scoped>

</style>