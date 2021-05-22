var vm_liquidation = new Vue({
    el: '#settlement',
    data: function(){
        return{
            seleAllComision: false,
            StatusProcess: '', 
            CommissionsDetails: []
        }
    },
    methods: {
        /**
         * Permite obtener la informacion de las comisiones de un usuario
         * @param {integer} user_id  
         */
        getDetailComision: function(user_id){
            this.seleAllComision = false
            axios.get('show/' + user_id).then((response) => {
                this.CommissionsDetails = response.data
                $('#modalModalDetalles').modal('show')
            }).catch(function (error) {
                console.log(error)
            }) 
        }, 

        /**
         * Permite obtener la informacion de las comisiones de las liquidaciones
         * @param {integer}  user_id 
         */
         getDetailComisionLiquidation: function(user_id){
            this.seleAllComision = false
            axios.get('edit/' + user_id).then((response) => {
                this.CommissionsDetails = response.data 
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
            this.seleAllComision = false
            axios.get('edit/' + user_id).then((response) => {
                this.CommissionsDetails = response.data
                $('#modalModalAccion').modal('show')
            }).catch(function (error) {
                console.log(error)
            })
        }
    }
})