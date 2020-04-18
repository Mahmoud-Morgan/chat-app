
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
{{--   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> --}}
  <script src="{{ asset('js/app.js') }}"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="{{ asset('css/chat_form.css') }}" rel="stylesheet">
{{--   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> --}}
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
<!--     <div class="chat_list active_chat">
      <div class="chat_people">
      <div class="chat_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
      <div class="chat_ib">
        <h5>Sunil Rajput <span class="chat_date">Dec 25</span></h5>
        <p>Test, which is a new approach to have all solutions 
        astrology under one roof.</p>
      </div>
      </div>
    </div> -->
  
  @foreach($users as $user)
    <div class="chat_list">
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
    <div class="msg_history" id="mesgs" >
      <div id ="mesgs" v-for="message  in messages">
      <div v-if="message.user_sender_id != user.id">
         <div class="incoming_msg">
         <div class="incoming_msg_img"> {{-- <img src= "@{{other_user.photo}}" --}} alt="sunil"> </div>
        <div class="received_msg">
        <div class="received_withd_msg">
          <p>body @{{message.body}}</p>
          <span class="time_date"> @{{message.created_at}}</span></div>
        </div>
      </div>
    </div>

      <div v-else>
        <div class="outgoing_msg">
          <div class="sent_msg">
          <p>@{{message.body}}</p>
          <span class="time_date">@{{message.created_at}}</span> </div>
        </div>
        </div>
     </div>
    </div>

     {{-- typing message area --}}
    <div class="type_msg">
    <div class="input_msg_write">
      <input type="text" class="write_msg" placeholder="Type a message" />
      <button class="msg_send_btn" type="button"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
    </div>
    </div>
  </div>
  </div>
</div>

</body>
</html>


<script type="text/javascript">


    const app = new Vue({
      el: '#mesgs',

      data () { 
        return{
        messages:{},
        newMessage: '',
        user: {!! Auth::check() ? Auth::user()->toJson() : 'null' !!},
      }
      },
      mounted() {
        // this.getMessages();
        //this.listen();
        //console.log(this.user.api_token);
      },
      methods: {
        getMessages: function (other_user_id) {
          axios.get('/api/messages/'+this.user.id+'/'+other_user_id,{
            headers: { 'Authorization' : 'Bearer '+ this.user.api_token}
                 })
                .then((response) => {
                  this.messages=response.data.messages;
                  console.log(this.messages);
                // .catch(function (error) {
                //   console.log(error);  });   
                });
        },

        check(id){
          console.log(id);
        }

      },
    });

  // const select_user= document.getElementsByClassName('chat_people').getAttribute('value');
  // console.log(select_user);
  //select_user.forEach(div =>{div.addEventListener('click',()=>{ alert("ok")})});
  // select_user.forEach(div =>{div.addEventListener('click',()=>{ alert( var id2= div.getAttribute('value'))})}) 
  //app.getMessages(item.getAttribute('value')
document.querySelectorAll('.chat_people').forEach(item => {
  item.addEventListener('click', event => {
    app.getMessages(item.getAttribute('value'));
  });});

</script>