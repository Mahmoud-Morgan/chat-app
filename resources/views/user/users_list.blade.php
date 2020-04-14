

<p>welcome <strong>{{$current_user->name}}</strong></p> 

<form>
	<label>Choose User to chat:</label>

<select >
	@foreach($users as $user)
  <option value="{{$user->id}}">{{$user->name}}</option>
  @endforeach
</select>
	

	
</form>