<template>
    <div class="row">

        <div class="col-8">
            <div class="card card-default">
                <div class="card-header" style="background-color:green;">Messages</div>
                <div class="card-body p-0">
                     <ul class="list-instyled" style="height : 300px;overflow-y:scroll;">
                        <li class="p-2" v-for="(message , index) in messages" :key="index">
                            <b>{{message.user.name}}</b> :
                            {{message.message}}
                            </li>
                    </ul>
                </div>

            </div>
            <input name="message" v-model="newMessage" @keyup.enter="sendMessage" class="form-control" type="text" placeholder="Enter your message...">
            <input name="user_id" type="hidden" :value="id">
            <span class="text-muted">User is typing...</span>
        </div>
        <div class="col-4">
            <div class="card card-default" >
                <div class="card-header" style="background-color:green;">User Active</div>
                <div class="card-body p-0">

                </div>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        props :['user'],
        data : function (){
            return {
                id : this.user.id,
                messages : [] ,
                newMessage : ''
            };
        },
        created : function (){
            this.fetchMessages();
        },
        methods : {
            fetchMessages(){
                axios.get('api/messages').then(response => {
                     this.messages = response.data;
                });
            },
            sendMessage(){
                this.messages.push({
                    user : this.user,
                    message : this.newMessage,
                });
                axios.post('api/messages' , {user_id : this.id ,message : this.newMessage , });
                this.newMessage ='';
            }
        }
    }
</script>
