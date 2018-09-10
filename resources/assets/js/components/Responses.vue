<template>
    <div class="row">
        <div class="col col-12 col-md-12">
            <a href="#" class="btn btn-outline-primary" v-on:click="load">Ver Respuestas</a>

            <div class="card m-1" v-for="response in responses">
                <div class="card-body">
                    {{ response.message }}
                </div>

                <div class="card-footer text-muted">
                    {{ response.user.name }}
                    
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    /* propiedad message viene desde la vista */
    props: ['message'],

    data(){
        return {
            responses: [],
        }
    },
    methods: {
        load(){
            axios.get('/api/messages/'+ this.message +'/responses')
                .then(res => {
                    this.responses = res.data;
                });
        }
    }
}
</script>
