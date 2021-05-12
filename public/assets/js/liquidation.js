var vm_liquidation = new Vue({
    el: '#settlement',
    data: function(){
        return{
            seleAllComision: false,
            StatusProcess: '',
            ComisionesDetalles: []
        }
    },
    methods: {
        /**
         * Permite obtener la informacion de las comisiones de un usuario
         * @param {integer}  user_id 
         */
        getDetailComision: function( user_id){
            let url = route('liquidation.show',  user_id)
            this.seleAllComision = false
            axios.get(url).then((response) => {
                this.ComisionesDetalles = response.data
                $('#modalModalDetalles').modal('show')
            }).catch(function (error) {
                console.log(error)
            })
        },

        /**
         * Permite obtener la informacion de las comisiones de las liquidaciones
         * @param {integer}  user_id 
         */
         getDetailComisionLiquidation: function( user_id){
            let url = route('liquidation.edit',  user_id)
            this.seleAllComision = false
            axios.get(url).then((response) => {
                this.ComisionesDetalles = response.data
                $('#modalModalDetalles').modal('show')
            }).catch(function (error) {
                console.log(error)
            })
        },

        /**
         * Permite obtener la informacion de las comisiones de las liquidaciones para aprobar o reversar
         * @param {integer}  user_id
         * @param {string} status
         */
         getDetailComisionLiquidationStatus: function( user_id, status){
            this.StatusProcess = status
            let url = route('liquidation.edit',  user_id)
            this.seleAllComision = false
            axios.get(url).then((response) => {
                this.ComisionesDetalles = response.data
                $('#modalModalAccion').modal('show')
            }).catch(function (error) {
                console.log(error)
            })
        }
    }
})