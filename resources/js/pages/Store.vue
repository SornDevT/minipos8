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
        <!-- FormShow: {{ FormShow }} -->
  <div class="card-body">
      <!-- <button @click="showAlert">Hello world</button> -->
    <div class="row" v-if="FormShow">
            
            <div class="col-md-4 text-center" style="position: relative;"> 
              <div style="position: absolute;top: 0px;right: 10px;">
                <button type="button" class="btn rounded-pill btn-icon btn-danger fs-4" @click="remove_img()">
                <i class='bx bx-x-circle'></i>
              </button>
              </div>
              <img :src="imagePreview" style="width:80%" alt="" srcset="">
              <input type="file" class="form-control mt-2" @change="onSelected">
            </div>
            <div class="col-md-8">
              <!-- {{ FormStore }} | check_buttom: {{check_buttom}} <hr>  -->
              
                <label for="">ຊື່ສິນຄ້າ</label>
                <input type="text" class="form-control mb-2"  placeholder="ປ້ອນຊື່ສິນຄ້າ...." v-model="FormStore.name" >
                <label for="">ຈຳນວນ</label>
                <cleave  class="form-control mb-2" :options="options"  placeholder="ປ້ອນຈຳນວນ...." v-model="FormStore.amount" />

                <div class="row">
                        <div class="col-md-6">
                            <label for="">ລາຄາຊື້</label>
                <cleave :options="options" class="form-control"  placeholder="ປ້ອນລາຄາຊື້...." v-model="FormStore.price_buy" />
                        </div>
                        <div class="col-md-6">
                            <label for="">ລາຄາຂາຍ</label>
                <cleave  class="form-control"  placeholder="ປ້ອນລາຄາຂາຍ...." v-model="FormStore.price_sell" :options="options" />
                        </div>
                </div>

            </div>
    </div>

    <div class="table-responsive text-nowrap" v-if="!FormShow">
      <!-- {{ StoreData }} <hr> -->
      <div class=" d-flex justify-content-end ">
            <input type="text" class="form-control mb-2" style=" width:350px;"  placeholder="ຄົ້ນຫາ...." v-model="Search" @keyup.enter="getStore()"  >
      </div>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th width="60">#</th>
            <th width="120">ຮູບ</th>
            <th>ຊື່ສິນຄ້າ</th>
            <th width="80">ຈຳນວນ</th>
            <th width="140">ລາຄາຊື້</th>
            <th width="80" class=" text-center">ຈັດການ</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="list in StoreData.data" :key="list.id">
            <td> {{ list.id }} </td>
            <td> 
              <img :src="'assets/img/'+list.image" v-if="list.image" class="img-cover" alt="">
              <img :src="'assets/img/no-image.png'" v-if="!list.image" class="img-cover" alt="">
               </td>
            <td>{{ list.name }}</td>
            <td>{{ formatPrice(list.amount) }}</td>
            <td> {{ formatPrice(list.price_buy) }} </td>
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
      <pagination :pagination="StoreData" :offset="4" @paginate="getStore($event)" /> 
    </div>
  </div>
</div>
</template>

<script>
export default {
    name: 'Minipos8Store',

    data() {
        return {
          imagePreview: window.location.origin+'/assets/img/no-image.png',
          image_Product:'',
            Search:'',
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
            options:{
              // prefix: '₭ ',
              numeral: true,
              numeralPositiveOnly: true,
              noImmediatePrefix: true,
              rawValueTrimPrefix: true,
              numeralIntegerScale: 10,
              numeralDecimalScale: 2,
              numeralDecimalMark: '.',
              delimiter: ','
            }
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

      //   showAlert() {
      //   // Use sweetalert2
      //   // this.$swal('Hello Vue world!!!');

      //   this.$swal.fire({
      //     toast: true,
      //     position: 'top-end',
      //     icon: 'success',
      //     title: 'Your work has been saved',
      //     showConfirmButton: false,
      //     timer: 2500
      //   })
      // },
      remove_img(){
          this.image_Product = ''
          this.imagePreview = window.location.origin+'/assets/img/no-image.png'
      },
      onSelected(event){

         this.image_Product = event.target.files[0]
          let reader = new FileReader();
          reader.readAsDataURL(this.image_Product);
          reader.addEventListener("load", function(){
            this.imagePreview = reader.result;
          }.bind(this), false);

      },

      formatPrice(value) {
        let val = (value / 1).toFixed(0).replace(",", ".")
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
      },
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

            let formDataStore = new FormData()
              formDataStore.append("name", this.FormStore.name)
              formDataStore.append("amount", this.FormStore.amount)
              formDataStore.append("price_buy", this.FormStore.price_buy)
              formDataStore.append("price_sell", this.FormStore.price_sell)
              formDataStore.append("file", this.image_Product);

            this.$axios.get("/sanctum/csrf-cookie").then((response)=>{
              this.$axios.post(`api/store/update/${this.editID}`,formDataStore).then((response)=>{
                  console.log(response.data)
                    if(response.data.success){

                      this.FormStore.name = ''
                      this.FormStore.amount = ''
                      this.FormStore.price_buy = ''
                      this.FormStore.price_sell = ''
                      this.image_Product = ''
                      this.imagePreview = window.location.origin+'/assets/img/no-image.png'

                      this.FormShow = false

                      this.getStore()

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
                        })
                    }
              }).catch((error)=>{
                console.log(error)
              })
          })


          } else {
            /// ເພີ່ມຂໍ້ມູນໃໝ່
            
              let formDataStore = new FormData();
              formDataStore.append("name", this.FormStore.name);
              formDataStore.append("amount", this.FormStore.amount);
              formDataStore.append("price_buy", this.FormStore.price_buy);
              formDataStore.append("price_sell", this.FormStore.price_sell);
              formDataStore.append("file", this.image_Product);

            this.$axios.get("/sanctum/csrf-cookie").then((response)=>{
              this.$axios.post("api/store/add",formDataStore).then((response)=>{
                  console.log(response.data)
                    if(response.data.success){

                      this.FormStore.name = ''
                      this.FormStore.amount = ''
                      this.FormStore.price_buy = ''
                      this.FormStore.price_sell = ''
                      this.image_Product = ''
                      this.imagePreview = window.location.origin+'/assets/img/no-image.png'

                      this.FormShow = false

                      this.getStore();

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
        edit_store(id){
            console.log(id)

            // ກຳນົດປະເພດຟອມເປັນ ການອັບເດດ
            this.FormType = true

            // ເກັບ id ສົ່ງໄປອັບເດດ
            this.editID = id
          this.$axios.get("/sanctum/csrf-cookie").then((response)=>{
              this.$axios.get(`api/store/edit/${id}`).then((response)=>{

                console.log(response.data)

                /// ເປີດຟອມ
                this.FormShow = true

                // ເອົາຂໍ້ມູນ ເຂົ້າຟອມ
                  this.FormStore.name = response.data.name;
                  this.FormStore.amount = response.data.amount;
                  this.FormStore.price_buy = response.data.price_buy;
                  this.FormStore.price_sell = response.data.price_sell;

                  this.image_Product = response.data.image;

                  if(response.data.image){
                    this.imagePreview = window.location.origin+'/assets/img/'+response.data.image
                  } else {
                    this.imagePreview = window.location.origin+'/assets/img/no-image.png'
                  }


              }).catch((error)=>{
                console.log(error);
              })
          })
        },
        del_store(id){

          this.$swal.fire({
              title: 'ທ່ານແນ່ໃຈບໍ່?',
              text: "ທີ່ຈະລຶບຂໍ້ມູນນີ້!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'ຕົກລົງ!',
              cancelButtonText:'ຍົກເລີກ'
            }).then((result) => {
              if (result.isConfirmed) {

            this.$axios.get("/sanctum/csrf-cookie").then((response)=>{ 
                  this.$axios.delete(`api/store/delete/${id}`).then((response)=>{
                    if(response.data.success){
                      this.getStore()

                      //   this.$swal.fire(
                      //   'ການລຶບຂໍ້ມູນ!',
                      //   response.data.message,
                      //   'success'
                      // )

                      this.$swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: response.data.message,
                                showConfirmButton: false,
                                timer: 2500
                              })

                    }
                  }).catch((error)=>{
                    console.log(error)
                  })
              })
              }
            })


          

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
    watch:{
      'Search'(){
        if(this.Search == ''){
          this.getStore();
        }
      }
    },
    created(){
      this.getStore();
    }
};
</script>

<style  scoped>
    .img-cover{
      width: 80px;
      height: 80px;
      object-fit: cover;
      object-position: center;
    }
</style>