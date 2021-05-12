var vm_ordenComunity = new Vue({
    el: '#admincomunity',
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
            let url = route('comunity.edit', id)
            axios.get(url).then((response) => {
                this.Service = response.data
                this.Route = route('comunity.update', this.Service.id)
                if (this.Service.description != null) {
                    $('#summernoteEdit').summernote('pasteHTML', this.Service.description)
                }
                $('#modalEditcomunity').modal('show')
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
            let url = route('comunity.show', id)
            axios.get(url).then((response) => {
                console.log(response.data);
                this.Description = response.data
                $('#modalDescriptioncomunity').modal('show')
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