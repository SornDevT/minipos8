<template>
   <div class="card">
    <div class="d-flex justify-content-between">
        <h5 class="card-header">ລາຍການສະຕ໋ອກສິນຄ້າ</h5>
        <div class=" pt-3 pe-3">
            <button type="button" class="btn rounded-pill btn-success me-2" v-if="FormShow">ບັນທຶກຂໍ້ມູນ</button>
            <button type="button" class="btn rounded-pill btn-danger" v-if="FormShow" @click="cancel()">ຍົກເລີກ</button>
            <button type="button" class="btn rounded-pill btn-info" @click="add()" v-if="!FormShow">ເພີ່ມ</button>
        </div>
    </div>
        FormShow: {{ FormShow }}
  <div class="card-body">

    <div class="row" v-if="FormShow">
            <div class="col-md-4">image</div>
            <div class="col-md-8">
                <label for="">ຊື່ສິນຄ້າ</label>
                <input type="text" class="form-control mb-2"  placeholder="ປ້ອນຊື່ສິນຄ້າ...." >
                <label for="">ຈຳນວນ</label>
                <input type="text" class="form-control mb-2"  placeholder="ປ້ອນຈຳນວນ...." >

                <div class="row">
                        <div class="col-md-6">
                            <label for="">ລາຄາຊື້</label>
                <input type="text" class="form-control"  placeholder="ປ້ອນລາຄາຊື້...." >
                        </div>
                        <div class="col-md-6">
                            <label for="">ລາຄາຂາຍ</label>
                <input type="text" class="form-control"  placeholder="ປ້ອນລາຄາຂາຍ...." >
                        </div>
                </div>

            </div>
    </div>

    <div class="table-responsive text-nowrap" v-if="!FormShow">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>#</th>
            <th>ຮູບ</th>
            <th>ຊື່ສິນຄ້າ</th>
            <th>ຈຳນວນ</th>
            <th>ລາຄາຊື້</th>
            <th>ຈັດການ</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                  <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>
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
            FormShow:false,
        };
    },

    mounted() {
        
    },

    methods: {
        add(){
            this.FormShow = true
        },
        cancel(){
            this.FormShow = false
        }
    },
};
</script>

<style lang="scss" scoped>

</style>