
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script src="{{ asset('js/app.js') }}"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="{{ asset('css/chat_form.css') }}" rel="stylesheet">

</head>
<body>

<div class="messaging" id="app">
  <div class="inbox_msg">
    <!-- {{-- left section --}} -->
  <div class="inbox_people">
    <h3></h3><p>welcome <strong>{{$current_user->name}}</strong></p> </h3>
    <div class="headind_srch">
    <div class="recent_heading">
      <h4>Recent</h4>
    </div>
    <div class="srch_bar">
      <div class="stylish-input-group">
      <input type="text" class="search-bar"  placeholder="Search" >
      </div>
    </div>
    </div>
    
    <div class="inbox_chat scroll">
  
  @foreach($users as $user)
    <div class="chat_list ">
      <div class="chat_people" value="{{$user->id}}">
      <div class="chat_img"> <img src="{{$user->photo}}" alt="sunil"> </div>
      <div class="chat_ib">
        <h5>{{$user->name}} <span class="chat_date">Dec 25</span></h5>
        <p>Test, which is a new approach to have all solutions 
        astrology under one roof.</p>
      </div>
      </div>
    </div> 
  @endforeach
    </div>
  </div>


  <!-- {{-- right section --}} -->
  <div class="mesgs" >
    <div class="media" style="border-bottom: 1px solid #B7BFBC;height: 50px;margin-bottom: 15px;" >
      <span class="media-left">
      <img width="45" v-bind:src= "other_user.photo" alt="Select user">
      </span>
      <div class="media-body" style="padding: 10px ;">
      <h2  >@{{other_user.name}}</h2>
    </div>
    </div>
    <div class="msg_history" id="mesgs" >
      <div id ="mesgs" v-for="message  in messages">
      <div v-if="message.user_sender_id != user.id">
         <div class="incoming_msg">
         <div class="incoming_msg_img"> <img v-bind:src= "other_user.photo" alt="sunil"> </div>
        <div class="received_msg">
        <div class="received_withd_msg">
          <p>@{{message.body}}</p>
          <span class="time_date"> @{{message.created_at | formatDate }}</span></div>
        </div>
      </div>
    </div>

      <div v-else>
        <div class="outgoing_msg">
          <div class="sent_msg">
          <p>@{{message.body}}</p>
          <span class="time_date">@{{message.created_at| formatDate }}</span> </div>
        </div>
        </div>
     </div>
    </div>

     {{-- typing message area --}}
    <div class="type_msg">
    <div class="input_msg_write">
      <input type="text" class="write_msg" v-model="newMessage" placeholder="Type a message" />
      <button class="msg_send_btn" type="button" @click.prevent="sendMessage"><i class="fa fa-send-o" aria-hidden="true"></i></button>
    </div>
    </div>
  </div>
  </div>
</div>




<script type="text/javascript">


    const app = new Vue({
      el: '#app',

      data () { 
        return{
        messages:{},
        newMessage: '',
        other_user: '',
        channel_id:'',
        user: {!! Auth::check() ? Auth::user()->toJson() : 'null' !!},
      }
      },
      mounted() {
        // this.getMessages();
        //this.listen();
        //console.log(this.user.api_token);
        //this.sendMessage();
      },
      methods: {
        getMessages: function (other_user_id,item) {
          axios.get('/api/messages/'+this.user.id+'/'+other_user_id,{
            headers: { 'Authorization' : 'Bearer '+ this.user.api_token}
                 })
                .then((response) => {
                  this.messages=response.data.messages;
                  this.other_user=response.data.other_user;
                  this.channel_id=response.data.channel_id;
                  console.log(this.channel_id);
                  this.listen();
                // .catch(function (error) {
                //   console.log(error);  });   
                });
          document.querySelectorAll('.chat_people').forEach(div => {
          div.parentElement.setAttribute('class','chat_list')})
          item.parentElement.setAttribute('class','chat_list active_chat');
        },
        sendMessage(){
          axios.post('/api/messages/newmessage',{  
            api_token:this.user.api_token,
            body :this.newMessage,
            user_sender_id : this.user.id,
            user_reciver_id :this.other_user.id,
                 })
          .then((response) => {
            this.messages.push(response.data);
            this.newMessage='';
          });
        },

        listen() {
        Echo.private('chat.'+this.channel_id)
            .listen('NewMessage', (e) => {
              //this.messages.push(message);
              console.log(e.message);
              this.messages.push(e.message);
            });
         },

        check(id){
          console.log(id);
        }

      },
    });


document.querySelectorAll('.chat_people').forEach(item => {
  item.addEventListener('click', event => {
    app.getMessages(item.getAttribute('value'),item);

  });});

</script>
</body>
</html>