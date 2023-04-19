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
                    <span v-for="i in ListOrder" :key="i.id">
                        <span class="img-product" v-if="list.id == i.id"> {{ i.order_amount }} </span>
                    </span>
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
                    <input type="text"  class="form-control" id="customer_name" v-model="customer_name" placeholder="ຊື່ລູກຄ້າ...">
                </div>
                <div class="mb-2">
                    <!-- <label for="customer_tel">ເບີໂທ</label> -->
                    <input type="text"  class="form-control" id="customer_tel" v-model="customer_tel" placeholder="ເບີໂທລູກຄ້າ...">
                </div>
                <div class=" d-flex justify-content-between fs-5 text-primary">
                    <span>ລວມຍອດເງິນ</span>
                    <span>{{formatPrice(TotalAmount)}} ກີບ</span>
                </div>
                <div>
                    <button type="button" class="btn btn-info w-100" @click="confirm_to_pay()" :disabled="!TotalAmount>0">ຊຳລະເງິນ</button>
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
            <td>{{formatPrice(list.price_sell)}} <br> <i class='bx bxs-minus-circle text-danger cursor' @click="remove_product(list.id)"></i> {{formatPrice(list.order_amount)}} <i class='bx bxs-plus-circle text-primary cursor' @click="add_product(list.id)"></i></td>
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
    <div class="modal fade" id="confirm_pay_modal" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalCenterTitle">ຊຳລະເງິນ</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="row text-primary">
                        <div class="col-md-6 text-start">ລວມຍອດເງິນ:</div>
                        <div class="col-md-6 text-end">{{formatPrice(TotalAmount)}} ກີບ</div>
                    </div>
                    <div class="row text-primary">
                        <div class="col-md-6 text-start">ຮັບເງິນນຳລູກຄ້າ:</div>
                        <div class="col-md-6 text-end"> {{ formatPrice(CashAmount) }} ກິບ </div>
                    </div>
                    <div class="row text-danger" v-if="CashAmount-TotalAmount>0" >
                        <div class="col-md-6 text-start">ເງິນທອນ:</div>
                        <div class="col-md-6 text-end">{{formatPrice(CashAmount-TotalAmount)}} ກີບ</div>
                    </div>
                    <div class=" d-flex justify-content-end">
                        <input type="text" style="width:150px; text-align:right;" v-model="CashAmount" class="form-control">
                    </div>

                    <div class=" d-flex justify-content-center">
                        <div class="row" style="width:250px;">
                                <div class="col-4 mt-4">
                                    <button type="button" style="width:60px" class="btn btn-primary" @click="AddNum(1)"> 1 </button>
                                </div>
                                <div class="col-4 mt-4">
                                    <button type="button" style="width:60px" class="btn btn-primary" @click="AddNum(2)"> 2 </button>
                                </div>
                                <div class="col-4 mt-4">
                                    <button type="button" style="width:60px" class="btn btn-primary" @click="AddNum(3)"> 3 </button>
                                </div>
                                <div class="col-4 mt-4">
                                    <button type="button" style="width:60px" class="btn btn-primary" @click="AddNum(4)"> 4 </button>
                                </div>
                                <div class="col-4 mt-4">
                                    <button type="button" style="width:60px" class="btn btn-primary" @click="AddNum(5)"> 5 </button>
                                </div>
                                <div class="col-4 mt-4">
                                    <button type="button" style="width:60px" class="btn btn-primary" @click="AddNum(6)"> 6 </button>
                                </div>
                                <div class="col-4 mt-4">
                                    <button type="button" style="width:60px" class="btn btn-primary" @click="AddNum(7)"> 7 </button>
                                </div>
                                <div class="col-4 mt-4">
                                    <button type="button" style="width:60px" class="btn btn-primary" @click="AddNum(8)"> 8 </button>
                                </div>
                                <div class="col-4 mt-4">
                                    <button type="button" style="width:60px" class="btn btn-primary" @click="AddNum(9)"> 9 </button>
                                </div>
                                <div class="col-4 mt-4">
                                    <button type="button" style="width:60px" class="btn btn-primary" @click="AddNum('00')"> 00 </button>
                                </div>
                                <div class="col-4 mt-4">
                                    <button type="button" style="width:60px" class="btn btn-primary" @click="AddNum(0)"> 0 </button>
                                </div>
                                <div class="col-4 mt-4">
                                    <button type="button" style="width:60px" class="btn btn-danger"  @click="AddNum('-')"> <i class='bx bx-left-arrow-alt'></i> </button>
                                </div>

                                <div class="col-12 text-center pt-4">
                                    <button class="btn btn-success" :disabled="!(CashAmount>=TotalAmount)" @click="Pay()" >ຍືນຍັນຊຳລ່ະເງິນ</button>
                                </div>
                        </div>
                    </div>
                  
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ປິດ</button>
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
            CashAmount:'',
            Search:'',
            customer_name:'',
            customer_tel:'',
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
        Pay(){
            if(this.CashAmount>=this.TotalAmount){
                 this.$axios.get("/sanctum/csrf-cookie").then((response)=>{
                    this.$axios.post("api/transection/add",{
                        acc_type: 'income',
                        listorder: this.ListOrder,
                        customer_name: this.customer_name,
                        customer_tel: this.customer_tel
                    }).then((response)=>{
                        // console.log(response.data)

                            if(response.data.success){

                            $('#confirm_pay_modal').modal('hide')
                            this.ListOrder = []
                            this.getStore();
                            this.CashAmount = ''
                            this.customer_name = ''
                            this.customer_tel = ''

                            // ເປີດແທບພິມໃບບິນ
                            window.open(window.location.origin+'/api/bill/'+response.data.number_bill)

                            this.$swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: response.data.message,
                                showConfirmButton: false,
                                timer: 2500
                                });

                            } else {

                            this.$swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'error',
                                title: response.data.message,
                                showConfirmButton: false,
                                timer: 2500
                                });

                            }
                    }).catch((error)=>{
                        console.log(error);
                    })
                })
            }
        },
        AddNum(num){
            // console.log(num)
            if(num == '-'){
                    this.CashAmount = this.CashAmount.slice(0,-1)
            } else {
                this.CashAmount += num
            }
        },
        confirm_to_pay(){
            $('#confirm_pay_modal').modal('show')
        },
        add_product(id){
            // console.log(id)
            
            let item = this.StoreData.data.find((i)=>i.id == id)
  
            // ກວດຊອບຈຳນວນສິນຄ້າ
            if(item.amount>0){
                 let list_order = this.ListOrder.find((i)=>i.id == id)

                if(list_order){
                    let old_order = list_order.order_amount
                    if(item.amount-old_order>0){
                        // ອັບເດດ
                        list_order.order_amount++
                    } else {
                         this.$swal('ສິນຄ້ານີ້','ໝົດແລ້ວ','error')
                    }
                    

                } else {
                    // ເພີ່ມໃໝ່
                     this.ListOrder.push({
                        id:item.id,
                        name: item.name,
                        price_sell: item.price_sell,
                        order_amount: 1
                    })
                }
            } else {
                this.$swal('ສິນຄ້ານີ້','ໝົດແລ້ວ','error')
            }

               

           
        },
        remove_product(id){
                let list_order = this.ListOrder.find((i)=>i.id == id)

                if(list_order){
                    list_order.order_amount--
                    if(list_order.order_amount<1){
                        this.ListOrder.splice(this.ListOrder.map((i)=>i.id).indexOf(id),1)
                    }
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
    .cursor{
        cursor: pointer;
    }
</style>