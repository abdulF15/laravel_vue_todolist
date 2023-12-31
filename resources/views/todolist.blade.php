<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Todo List</title>
    {{-- jquery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    {{-- Bootstrap --}}
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
    {{-- VueJs --}}
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    {{-- axios --}}
    <script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>
    <style>
        .todolist-wrapper{
            border: 1px solid #ccc;
            min-height: 100px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div id="app">
            
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="exampleModalLabel">Todo List</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form>
                        <div class="mb-3">
                          <label for="message-text" class="col-form-label">Todolist:</label>
                          <textarea class="form-control" v-model="content" id="message-text"></textarea>
                        </div>
                      </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="button" @click="saveTodoList" class="btn btn-primary">Save</button>
                    </div>
                  </div>
                </div>
              </div>

            <div class="row">
                <div class="col-sm-1"></div>
                <div class="col-sm-12">
                    <div class="text-end my-3">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">Tambah Todolist</button>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" @change="findData" v-model="search" name="search" placeholder="Cari"  aria-describedby="button-addon2">
                        <button class="btn btn-outline-secondary" type="button" id="button-addon2">Button</button>
                    </div>
                    {{-- <div class="text-center mb-3">
                        <input type="text" v-model="search" placeholder="Cari" @change="findData" class="form-control">
                    </div> --}}
                    <div class="todolist-wrapper">
                        <table class="table table-striped table-bordered">
                            <tbody>
                                <tr v-for="item in data_list">
                                    <td>@{{ item.content }} 
                                        <button class="btn btn-warning" @click="editData(item.id)">Edit</button> 
                                        <button class="btn btn-danger" @click="deleteData(item.id)">Hapus</button> 
                                    </td>
                                </tr>
                                <tr v-if="!data_list.length">
                                    <td>Data Masih Kosong</td>
                                </tr>
                            </tbody>
                        </table>
                    </div >
                </div>
                <div class="col-sm-1"></div>
            </div>
        </div>
    </div>

    <script>
        let vue = new Vue({
            el:"#app",
            data: {
                data_list:[],
                content:"",
                id:"",
                search:""
            },
            mounted(){
                this.getDataList();
            },
            methods: {
                findData : function(){
                    this.getDataList();
                },
                saveTodoList : function(){
                    let form_data = new FormData();
                    form_data.append("content",this.content);

                    if(this.id){
                        // update data
                        axios.post("{{ url('api/todolist/update')}}/"+this.id,form_data)
                            .then(response=>{
                                alert(response.data.message);
                                this.getDataList();
                            })
                            .catch( err =>{
                                alert("terjadi kesalahan pada sistem");
                            })
                            .finally(()=>{
                                $('.modal').modal('hide');
                            })
                    }else{
                        // create
                        axios.post("{{ url('api/todolist/create') }}",form_data)
                            .then(response=>{
                                alert(response.data.message);
                                this.getDataList();
                            })
                            .catch( err =>{
                                alert("terjadi kesalahan pada sistem");
                            })
                            .finally(()=>{
                                $('.modal').modal('hide');
                            })
                    }

                },
                getDataList : function() {
                    axios.get("{{ url('api/todolist/list') }}?search="+this.search)
                    .then(res=>{
                        this.data_list = res.data;
                    })
                    .catch( err =>{
                        alert("terjadi kesalahan pada sistem");
                    })
                },
                editData : function (id) {
                    this.id = id;
                    axios.get("{{ url('api/todolist/show') }}/" + this.id)
                        .then(res=>{
                            let item = res.data;
                            this.content = item.content;

                            $('.modal').modal('show');
                        })
                        .catch(err=>{
                            alert("terjadi kesalahan pada sistem");
                        })
                },
                deleteData : function(id){
                    if(confirm('apakah data ini akan dihapus'))
                    {
                        axios.post("{{ url('api/todolist/delete')}}/"+ id)
                            .then(res=>{
                                alert(res.data.message);
                                this.getDataList();
                            })
                            .catch(err=>{
                                alert(err);
                            })
                    }
                }

            }
        });
    </script>
</body>
</html>