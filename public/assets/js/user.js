var vm_user = new Vue({
    el: '#user',
    created: function(){
        $(document).ready(function(){
            $("#emojioneareaNew").emojioneArea({
                pickerPosition: "bottom",
                tonesStyle: "radio"
            });

            $("#emojioneareaEdit").emojioneArea({
                pickerPosition: "bottom",
                tonesStyle: "radio"
            });
        })
    },
    data: function(){
        return{
            Service: [],
            Route: '',
            Option:{
                service_type: '',
                type: '' 
            },
            Description: ''
        }
    },
    methods:{
        /**
         * Permite obtener la informacion de un servicio
         * @param {integer} id 
         */
        getEditData: function (id) {
            let url = route('record_order.edit', id)
            axios.get(url).then((response) => {
                this.Service = response.data
                this.Route = route('record_order.update-admin', this.Service.id)
                if (this.Service.description != null) {
                    $('#summernoteEdit').summernote('pasteHTML', this.Service.description)
                }
                $('#modalEditrecord_order').modal('show')
            }).catch(function (error) {
                console.log(error)
            })
        },
        /**
         * Permite borrar un servicio
         * @param {integer} id 
         */
        deleteData: function(id){
            Swal.fire({
                title: "Advertencia",
                text: "Esta seguro que quieres eliminar la Orden "+id,
                type: "warning",
                confirmButtonClass: 'btn btn-primary',
                buttonsStyling: false,
            }).then(function(result){
                if (result.value) {
                    $('#delete'+id).submit()
                }
            });
        },

        getDescription: function(id){
            let url = route('record_order.show-admin', id)
            axios.get(url).then((response) => {
                console.log(response.data);
                this.Description = response.data
                $('#modalDescriptionrecord_order').modal('show')
            }).catch((error) => {
                console.log(error)
            })
        },

        /**
         * Permite aplicar el filtro selecionado
         */
        aplicFiltro: function(){
            console.log('entre');
            $('#filtro').submit();
        }

    }
})