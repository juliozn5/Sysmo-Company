var vm_news = new Vue({
    el: '#news',
    created: function(){
        $(document).ready(function(){
            $('#modalNew').modal({backdrop: 'static', keyboard: false, show:true})
        })
        this.getDataService();
    },

    methods: {
        /**
         * Permite cerrar la modal del aviso
         */
        closeModal: function(){
            if (this.checkServicio) {
                $('#modalNew').modal('hide')
                this.showAlert = false
            }else{
                this.showAlert = true
            }
        },

          /**
         * Permite borrar un servicio
         * @param {integer} id 
         */
           deleteData: function(id){
            Swal.fire({
                title: "Advertencia",
                text: "Esta seguro que quieres eliminar la Noticia "+id,
                type: "warning",
                confirmButtonClass: 'btn btn-primary',
                buttonsStyling: false,
            }).then(function(result){
                if (result.value) {
                    $('#delete'+id).submit()
                }
            });
        },

    }
})

