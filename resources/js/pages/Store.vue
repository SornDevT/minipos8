<template>
   <div class="card">
    <div class="d-flex justify-content-between">
        <h5 class="card-header">ລາຍການສະຕ໋ອກສິນຄ້າ</h5>
        <div class=" pt-3 pe-3">
            <button type="button" class="btn rounded-pill btn-success me-2" :disabled="check_buttom" @click="save_store()" v-if="FormShow">ບັນທຶກຂໍ້ມູນ</button>
            <button type="button" class="btn rounded-pill btn-danger" v-if="FormShow" @click="cancel()">ຍົກເລີກ</button>
            <button type="button" class="btn rounded-pill btn-info" @click="add()" v-if="!FormShow">ເພີ່ມ</button>
        </div>
    </div>
        FormShow: {{ FormShow }}
  <div class="card-body">
      
    <div class="row" v-if="FormShow">
            
            <div class="col-md-4">image</div>
            <div class="col-md-8">
              {{ FormStore }} | check_buttom: {{check_buttom}} <hr> 
              
                <label for="">ຊື່ສິນຄ້າ</label>
                <input type="text" class="form-control mb-2"  placeholder="ປ້ອນຊື່ສິນຄ້າ...." v-model="FormStore.name" >
                <label for="">ຈຳນວນ</label>
                <input type="text" class="form-control mb-2"  placeholder="ປ້ອນຈຳນວນ...." v-model="FormStore.amount" >

                <div class="row">
                        <div class="col-md-6">
                            <label for="">ລາຄາຊື້</label>
                <input type="text" class="form-control"  placeholder="ປ້ອນລາຄາຊື້...." v-model="FormStore.price_buy" >
                        </div>
                        <div class="col-md-6">
                            <label for="">ລາຄາຂາຍ</label>
                <input type="text" class="form-control"  placeholder="ປ້ອນລາຄາຂາຍ...." v-model="FormStore.price_sell" >
                        </div>
                </div>

            </div>
    </div>

    <div class="table-responsive text-nowrap" v-if="!FormShow">
      <!-- {{ StoreData }} <hr> -->
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>#</th>
            <th>ຮູບ</th>
            <th>ຊື່ສິນຄ້າ</th>
            <th>ຈຳນວນ</th>
            <th>ລາຄາຊື້</th>
            <th width="80" class=" text-center">ຈັດການ</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="list in StoreData" :key="list.id">
            <td> {{ list.id }} </td>
            <td></td>
            <td>{{ list.name }}</td>
            <td>{{ list.amount }}</td>
            <td> {{ list.price_buy }} </td>
            <td class=" text-center">
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="javascript:void(0);" @click="edit_store(list.id)"><i class="bx bx-edit-alt me-1"></i> ແກ້ໄຂ</a>
                  <a class="dropdown-item" href="javascript:void(0);" @click="del_store(list.id)"><i class="bx bx-trash me-1"></i> ລຶບ</a>
                </div>
              </div>
            </td>
          </tr>
          
         
       
        </tbody>
      </table>
    </div>
  </div>
</div>
</template>

<script>
export default {
    name: 'Minipos8Store',

    data() {
        return {
            editID:'',
            FormType:false,
            FormShow:false,
            FormStore:{
              name:'',
              amount:'',
              price_buy:'',
              price_sell:''
            },
            StoreData:[],
        };
    },

    mounted() {
        
    },
    computed:{
      check_buttom(){
        if(this.FormStore.name == '' || this.FormStore.amount == '' || this.FormStore.price_buy == '' || this.FormStore.price_sell == ''){
          return true;
        } else {
          return false;
        }
      }
    },
    methods: {
        add(){
            this.FormShow = true
            this.FormType = false
        },
        cancel(){
            this.FormShow = false
        },
        save_store(){


          // ກວດຊອບ
          if(this.FormType){

            /// ອັບເດດຂໍ້ມູນ

            let formDataStore = new FormData();
              formDataStore.append("name", this.FormStore.name);
              formDataStore.append("amount", this.FormStore.amount);
              formDataStore.append("price_buy", this.FormStore.price_buy);
              formDataStore.append("price_sell", this.FormStore.price_sell);

              this.$axios.post(`api/store/update/${this.editID}`,formDataStore).then((response)=>{
                  console.log(response.data);
                    if(response.data.success){

                      this.FormStore.name = '';
                      this.FormStore.amount = '';
                      this.FormStore.price_buy = '';
                      this.FormStore.price_sell = '';

                      this.FormShow = false

                      this.getStore();

                    } else {

                    }
              }).catch((error)=>{
                console.log(error);
              });


          } else {
            /// ເພີ່ມຂໍ້ມູນໃໝ່
            
              let formDataStore = new FormData();
              formDataStore.append("name", this.FormStore.name);
              formDataStore.append("amount", this.FormStore.amount);
              formDataStore.append("price_buy", this.FormStore.price_buy);
              formDataStore.append("price_sell", this.FormStore.price_sell);

              this.$axios.post("api/store/add",formDataStore).then((response)=>{
                  console.log(response.data);
                    if(response.data.success){

                      this.FormStore.name = '';
                      this.FormStore.amount = '';
                      this.FormStore.price_buy = '';
                      this.FormStore.price_sell = '';

                      this.FormShow = false

                      this.getStore();

                    } else {

                    }
              }).catch((error)=>{
                console.log(error);
              });

          }


        },
        edit_store(id){
            console.log(id)

            // ກຳນົດປະເພດຟອມເປັນ ການອັບເດດ
            this.FormType = true

            // ເກັບ id ສົ່ງໄປອັບເດດ
            this.editID = id

            this.$axios.get(`api/store/edit/${id}`).then((response)=>{

              console.log(response.data)

              /// ເປີດຟອມ
              this.FormShow = true

              // ເອົາຂໍ້ມູນ ເຂົ້າຟອມ
                this.FormStore.name = response.data.name;
                this.FormStore.amount = response.data.amount;
                this.FormStore.price_buy = response.data.price_buy;
                this.FormStore.price_sell = response.data.price_sell;


            }).catch((error)=>{
              console.log(error);
            });
        },
        del_store(id){


          
            this.$axios.delete(`api/store/delete/${id}`).then((response)=>{

              if(response.data.success){
                this.getStore();
              }

              

            }).catch((error)=>{
              console.log(error);
            });

        },
        getStore(){
          this.$axios.get('api/store').then((response)=>{
              this.StoreData = response.data;
          }).catch((error)=>{
            console.log(error);
          });
        }
    },
    created(){
      this.getStore();
    }
};
</script>

<style lang="scss" scoped>

</style>