<template>
    <div class="row">
       <div class="col-md-8">
        <div class="card">
            <div class=" card-body">
                <input type="text" class=" form-control" placeholder="ຄົ້ນຫາຂໍ້ມູນ..." v-model="Search">
            </div>
        </div>

        <div class="row mt-4" style="height:65vh; overflow:auto;">
            <div class="col-md-3 mb-4" v-for="list in StoreData.data" :key="list.id" style="position: relative; "> 
                <div class="card h-100" @click="add_product(list.id)" style=" cursor: pointer;">
                    <span class="img-product">10</span>
                    <img class="card-img-top img-cover" :src="'assets/img/'+ list.image" v-if="list.image" alt="Card image cap">
                    <img class="card-img-top img-cover" :src="'assets/img/no-image.png'" v-if="!list.image" alt="Card image cap">
                    <div class="card-body p-1 text-center">
                      <strong>{{ list.name }}</strong>  
                      <p>{{formatPrice(list.price_sell)}} ກີບ</p>
                    </div>
                    </div>
            </div>
        </div>

       </div>
       <div class="col-md-4">
        
        <div class="card" style="height:80vh; overflow:auto;">
            <div class=" card-body">
                <div class="mb-2">
                    <!-- <label for="customer_name">ຊື່ລູກຄ້າ</label> -->
                    <input type="text"  class="form-control" id="customer_name" placeholder="ຊື່ລູກຄ້າ...">
                </div>
                <div class="mb-2">
                    <!-- <label for="customer_tel">ເບີໂທ</label> -->
                    <input type="text"  class="form-control" id="customer_tel" placeholder="ເບີໂທລູກຄ້າ...">
                </div>
                <div class=" d-flex justify-content-between fs-5 text-primary">
                    <span>ລວມຍອດເງິນ</span>
                    <span>{{formatPrice(TotalAmount)}} ກີບ</span>
                </div>
                <div>
                    <button type="button" class="btn btn-info w-100">ຊຳລະເງິນ</button>
                </div>
<!-- {{ListOrder}} -->
                <div class=" table-responsive text-nowrap">

                
    <table class="table table-bordered mt-2">
        <thead>
          <tr>
            <th>ລາຍການ</th>
            <th>ລາຄາ</th>
            <th>ລວມຍອດ</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="list in ListOrder" :key="list.id">
            <td>{{list.name}} </td>
            <td>{{formatPrice(list.price_sell)}} <br> {{formatPrice(list.order_amount)}}</td>
            <td>
              {{formatPrice(list.price_sell*list.order_amount)}}
            </td>
          </tr>
        </tbody>
      </table>
      </div>
            </div>
        </div>
       </div>
    </div>
</template>

<script>
export default {
    name: 'Minipos8Pos',

    data() {
        return {
            Search:'',
            StoreData:[],
            ListOrder:[],
        };
    },
    computed:{
        TotalAmount(){
           return this.ListOrder.reduce((num,item)=> num + item.price_sell*item.order_amount,0) 
        }
    },

    mounted() {
        
    },

    methods: {
        add_product(id){
            // console.log(id)
            
            let item = this.StoreData.data.find((i)=>i.id == id)

                let list_order = this.ListOrder.find((i)=>i.id == id)

                if(list_order){
                    // ອັບເດດ

                    list_order.order_amount++

                } else {
                    // ເພີ່ມໃໝ່
                     this.ListOrder.push({
                        id:item.id,
                        name: item.name,
                        price_sell: item.price_sell,
                        order_amount: 1
                    })
                }

           
        },
        formatPrice(value) {
        let val = (value / 1).toFixed(0).replace(",", ".")
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
      },
        getStore(page){
          this.$axios.get("/sanctum/csrf-cookie").then((response)=>{
              this.$axios.get(`api/store?page=${page}&s=${this.Search}`).then((response)=>{
                  this.StoreData = response.data;
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
        this.getStore()
    }
};
</script>

<style scoped>
    .img-cover{
      width: 100%;
      height: 120px;
      object-fit: cover;
      object-position: center;
    }
    .img-product{
    border-radius: 0px 10px 0px 10px;
    position: absolute;
    right: 0px;
    background: blue;
    color: white;
    padding: 5px;
   
    }
</style>