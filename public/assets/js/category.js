var vm_category = new Vue({
    el: '#category',
    data: function(){
        return{
            Category: [],
            Route: ''
        }
    },
    methods:{
        /**
         * Permite obtener la informacion de una categoria
         * @param {integer} id 
         */
        getEditData: function (id) {
            let url = route('category.edit', id)
            axios.get(url).then((response) => {
                this.Category = response.data
                this.Route = route('category.update', this.Category.id)
                if (this.Category.description != null) {
                    $('#summernoteEdit').summernote('pasteHTML', this.Category.description)
                }
                $('#modalEditCategories').modal('show')
            }).catch(function (error) {
                console.log(error)
            })
        },
        /**
         * Permite borrar una categoria
         * @param {integer} id 
         */
        deleteData: function(id){
            Swal.fire({
                title: "Advertencia",
                text: "Esta seguro que quieres eliminar la categoria "+id,
                type: "warning",
                confirmButtonClass: 'btn btn-primary',
                buttonsStyling: false,
            }).then(function(result){
                if (result.value) {
                    $('#delete'+id).submit()
                }
            });
        }
    }
})