

<p>welcome <strong>{{$current_user->name}}</strong></p> 

<form>
	<label>Choose User to chat:</label>

<select >
	@foreach($users as $user)
  <option value="{{$user->id}}">{{$user->name}}</option>
  @endforeach
</select>
	

	
</form>






.................




<div class ="container-fluid">
	
	<div name="chat-view">
		
		<divn name="previous-messages">
			@foreach($messages as $message)
			<p>{{$message->message}}</p> 
			@endforeach
		</div>

		<form action="{{ route('chat.store') }}" method="POST" >
		 {{ csrf_field() }}

		 <input type="hidden"  name="user_sender_id" value="{{$message->user_sender_id}}">

		  <input type="hidden"  name="user_reciver_id" value="{{$message->user_reciver_id}}">

		  <div class="col-md-12">
         <div class="form-group">
            <strong>Message</strong>
            <textarea class="form-control" col="4" name="message" placeholder="Enter Message"></textarea>
            <span class="text-danger">{{ $errors->first('message') }}</span>
          </div>
          </div>


            <div class="col-md-12">
           <button type="submit" class="btn btn-success mb-2">Send</button>
           </div>
       </form>
	</div>
</div>