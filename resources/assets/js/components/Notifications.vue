<template>
    <div class="dropdown-menu">
        <a :href="'/users/'+ notification.data.follower.username" class="dropdown-item" v-for="notification in notifications">
            @{{ notification.data.follower.username }} te ha seguido
        </a>
    </div>
</template>

<script>
export default {
    props: ['user'],
    data(){
        return{
            notifications: [],
        }
    },
    mounted(){
        ;
        axios.get('/api/notifications')
            .then((response) => {
                this.notifications = response.data;
            });
            var socketId = Echo.socketId();
            
            Echo.private('App.User.' + this.user)
            .notification((notification) => {
            console.log(notification);
            })
    }
}
</script>

