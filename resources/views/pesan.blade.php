@foreach($pesan as $p)
    @if($p->id_user == Auth::user()->id_user)
        <div class="chat chat-right">
            <div class="chat-bubble">
                <div class="chat-content">
                    <p>{{ $p->pesan }}</p>
                    <span class="chat-time">{{ $p->created_at->format('H:i') }}</span>
                </div>
            </div>
        </div>
    @else
        <div class="chat chat-left">
            <div class="chat-bubble">
                <div class="chat-content">
                    <p>{{ $p->pesan }}</p>
                    <span class="chat-time">{{ $p->created_at->format('H:i') }}</span>
                </div>
            </div>
        </div>
    @endif
@endforeach
<script src="{{url('https://js.pusher.com/8.2.0/pusher.min.js')}}"></script>
  <script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('c3afeec2f5fc69f875f5', {
      cluster: 'ap1'
    });

    var channel = pusher.subscribe('pesan');
    channel.bind('MassageCreated', function(data) {
      alert(JSON.stringify(data));
    });
  </script>