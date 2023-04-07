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
            <a href="index.html" class="app-brand-link gap-2">
              <span class="app-brand-logo demo">



</span>
              <span class="app-brand-text demo text-body fw-bolder">ສະບາຍດີ</span>
            </a>
          </div>
          <!-- /Logo -->
          <p class="mb-4">ຍິນດີຕ້ອນຮັບ</p>


            <div class="mb-3">
              <label for="email" class="form-label">ອີເມວລ໌</label>
              <input type="text" class="form-control" v-model="email" id="email" name="email-username" placeholder="ປ້ອນ email ..." autofocus="">
            </div>
            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label" for="password">ລະຫັດຜ່ານ</label>
                <!-- <a href="auth-forgot-password-basic.html">
                  <small>Forgot Password?</small>
                </a> -->
              </div>
              <div class="input-group input-group-merge">
                <input :type="vpass" id="password" v-model="password" class="form-control" name="password" placeholder="ປ້ອນ password ..." aria-describedby="password">
                <span class="input-group-text cursor-pointer" @click="shpass()" ><i class="bx bx-hide" v-if="vpass=='password'" ></i> <i class="bx bx-show" v-if="vpass=='text'" ></i> </span>
              </div>
            </div>
            <!-- <div class="mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="remember-me">
                <label class="form-check-label" for="remember-me">
                  Remember Me
                </label>
              </div>
            </div> -->
            <div class="alert alert-danger" role="alert" v-if="show_error">
                {{ error_mgs }}
                </div>

            <div class="mb-3">
              <button class="btn btn-primary d-grid w-100" @click="login()" :disabled="check_bt_login" >ເຂົ້າສູ່ລະບົບ</button>
            </div>
 

          <p class="text-center">
            <span>ບໍ່ມີບັນຊີ?</span>
            <router-link to="/register">
              <span>ຄຼິກລົງທະບຽນ</span>
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
    name: 'Minipos8Login',

    data() {
        return {
          show_error:false,
          error_mgs:'',
          vpass:'password',
          email:'',
          password:''
        };
    },
    computed:{
        check_bt_login(){
            if(this.email == '' || this.password == ''){
                return true
            } else {
                return false
            }
        }
    },

    mounted() {
        
    },

    methods: {
       shpass(){
            if(this.vpass=='password'){
                this.vpass = 'text'
            } else {
                this.vpass = 'password'
            }
       },
       login(){

            this.$axios.post("api/login",{
                    email: this.email,
                    password: this.password
                }).then((response) => {
                    // console.log(response.data)
                    if(response.data.success){
                        this.show_error = false
                        this.error_mgs = ''
                        // this.$swal.fire({
                        //   toast: true,
                        //   position: 'top-end',
                        //   icon: 'success',
                        //   title: response.data.message,
                        //   showConfirmButton: false,
                        //   timer: 2500
                        // });

                        this.$storage.setStorageSync("vue-isLoggin",true)
                        // this.$router.push('store');
                        window.location.reload()

                    } else {

                        this.show_error = true
                        this.error_mgs = response.data.message

                        // this.$swal.fire({
                        //   toast: true,
                        //   position: 'top-end',
                        //   icon: 'error',
                        //   title: response.data.message,
                        //   showConfirmButton: false,
                        //   timer: 2500
                        // });
                    }
                }).catch((error) => {
                    console.log(error)
                });
       }
    },
};
</script>

<style lang="scss" scoped>

</style>