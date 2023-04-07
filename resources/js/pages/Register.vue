<template>
    <div class=" d-flex justify-content-center ">
        <div class="col-md-6 col-sm-6 col-lg-3">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner">
      <!-- Register -->
      <div class="card">
        <div class="card-body">
          <!-- Logo -->
          <div class="app-brand justify-content-center">
          
              <span class="app-brand-logo demo">



</span>
              <span class="app-brand-text demo text-body fw-bolder">ລົງທະບຽນໃໝ່</span>
          
          </div>
          <!-- /Logo -->
   

     
            <div class="mb-3">
              <label for="email" class="form-label">ຊື່ຜູ້ໃຊ້</label>
              <input type="text" class="form-control" v-model="name" id="email" name="email-username" placeholder="ປ້ອນ ຊື່ຜູ້ໃຊ້ ..." autofocus="">
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">ອີເມວລ໌</label>
              <input type="text" class="form-control" v-model="email" id="email" name="email-username" placeholder="ປ້ອນ email ..." autofocus="">
            </div>
            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label" for="password">ລະຫັດຜ່ານ</label>
       
              </div>
              <div class="input-group input-group-merge">
                <input type="password" id="password" v-model="password" class="form-control" name="password" placeholder="ປ້ອນ password ..." aria-describedby="password">
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>
            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label" for="password">ຍືນຍັນລະຫັດຜ່ານ</label>
       
              </div>
              <div class="input-group input-group-merge">
                <input type="password" id="password" v-model="confirm_password" class="form-control" name="password" placeholder="ປ້ອນ password ..." aria-describedby="password">
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>

            <div class="alert alert-danger" role="alert" v-if="show_error">
                {{ error_mgs }}
            </div>
      
            <div class="mb-3">
              <button class="btn btn-primary d-grid w-100"  @click="register()" :disabled="check_bt_register">ລົງທະບຽນ</button>
            </div>
    

          <p class="text-center">
            <span>ມີບັນຊີແລ້ວ!</span>
            <router-link to="/login">
              <span>ເຂົ້າສູ່ລະບົບ</span>
            </router-link>
          </p>
        </div>
      </div>
      <!-- /Register -->
    </div>
  </div>
</div>
    </div>
</template>

<script>
export default {
    name: 'Minipos8Register',

    data() {
        return {
            show_error:false,
            error_mgs:'',
            name:'',
           email:'',
           password:'',
           confirm_password:''
        };
    },
    computed:{
        check_bt_register(){
            if(this.name == '' || this.email == '' || this.password == '' || this.confirm_password ==''){
                return true
            } else {
                return false
            }
        }
    },

    mounted() {
        
    },

    methods: {
        register(){
            if(this.password == this.confirm_password){
                this.show_error = false
                this.error_mgs = ''

                this.$axios.post("api/register",{
                    name: this.name,
                    email: this.email,
                    password: this.password
                }).then((response) => {
                    // console.log(response.data)
                    if(response.data.success){
                        this.$swal.fire({
                          toast: true,
                          position: 'top-end',
                          icon: 'success',
                          title: response.data.message,
                          showConfirmButton: false,
                          timer: 2500
                        });

                        // ໄປທີ່ໜ້າ Login
                        this.$router.push('login');

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
                }).catch((error) => {
                    console.log(error)
                });

            } else {
                this.show_error = true
                this.error_mgs = 'ລະຫັດຜ່ານບໍ່ກົງກັນ!'
            }
        }
    },
};
</script>

<style lang="scss" scoped>

</style>