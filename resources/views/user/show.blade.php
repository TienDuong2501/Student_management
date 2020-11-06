@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @if(Session::has('success'))
            <div class="col-md-12 alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif
        @if(Session::has('error'))
            <div class="col-md-12 alert alert-danger">
                {{ Session::get('error') }}
            </div>
        @endif
          <div class="col-md-12">
                <div class="form-group">
                  <label for="name">Tên đăng nhập</label>
                  <input type="text" value="{{ $user->name }}" name="name" class="form-control" id="name" placeholder="Tên đăng nhập">
                </div>
                <div class="form-group">
                  <label for="fullname">Họ và tên</label>
                  <input type="text" value="{{ $user->fullname }}" class="form-control" id="fullname" name="fullname" placeholder="Họ và tên">
                </div>
                <div class="form-group">
                  <label for="phone">Phone</label>
                  <input type="phone" name="phone" value="{{ $user->phone }}" class="form-control" id="phone" placeholder="Số điện thoại">
                </div>
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" name="email" value="{{ $user->email }}" class="form-control" id="role" placeholder="email">
                </div>
          </div>
    </div>
    <hr>
    <div class="row">
      <div class="chatContainer">
    {{-- <div class="chatTitleContainer">Comments</div> --}}
  <div class="chatHistoryContainer">
      <ul class="formComments">
        @if($user->comments)
          @foreach($user->comments as $comment)
            <li class="commentLi commentstep-1" data-commentid="4">
              <table class="form-comments-table">
                <tr>
                  <td>
                    <div class="comment-timestamp">{{$comment->created_at->format('Y/m/d H:i')}}</div>
                  </td>
                  <td>
                    <div class="comment-user">{{$comment->commenter->name}}</div>
                  </td>
                  <td>
                    <div class="comment-avatar">
                      <img src="https://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50?f=y">
                    </div>
                  </td>
                  <td>
                    <div id="comment-4" data-commentid="4" class="comment comment-step1">
                      {{$comment->content}}
                    </div>
                    @if ($authUser->id == $comment->commenter_id)
                      <div class="comment-meta">
                        <span><a href="#" data-id="{{$comment->id}}" onClick="
                          event.preventDefault();
                          var id = $(this).data('id');
                          var formId = '#commentUser' + id;
                          $(formId).submit()
                          ">delete</a></span>

                        <span>
                          <a class="" role="button" data-toggle="collapse" href="{{ '#replyCommentT' . $comment->id}}" aria-expanded="false" aria-controls="collapseExample">edit</a>
                        </span>
                        <div class="collapse" id="{{ 'replyCommentT' . $comment->id}}">
                          <form action="{{ route('comments.update', ['id' => $comment->id]) }}" method="post">
                            <div class="form-group">
                               <input type="hidden" name="_method" value="PUT">
                               @csrf
                              <label for="content">Your Comment</label>
                              <input type="hidden" name="user_id" value="{{ $user->id }}">
                              <textarea name="content" class="form-control" rows="3">
                                {{ $comment->content }}
                              </textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Send</button>
                          </form>
                        </div>
                         <form action="{{ route('comments.destroy', ['id' => $comment->id]) }}" method="post" id="{{'commentUser' . $comment->id}}">
                            <div class="form-group">
                               <input type="hidden" name="_method" value="DELETE">
                               @csrf
                              <input type="hidden" name="user_id" value="{{ $user->id }}">
                            </div>
                          </form>
                      </div>
                    @endif
                  </td>
                </tr>
              </table>
            </li>
          @endforeach
        @endif
      </ul>
    </div>
      <div class="input-group input-group-sm chatMessageControls">
          <span class="input-group-addon" id="sizing-addon3">Comment</span>
        <form action="{{ route('comments.store') }}" method="post" id="commentUser">
            @csrf
          <input type="hidden" name="user_id" value="{{ $user->id }}">
          <input type="text" id="txtComment" name="content" class="form-control" placeholder="Type your message here.." aria-describedby="sizing-addon3">    
        </form>
          <span class="input-group-btn">
              <button id="sendMessageButton" class="btn btn-primary" onClick="$('#commentUser').submit();" class="btn btn-danger" type="submit"><i class="fa fa-send"></i>Send</button>
          </span>
      </div>
  </div>
    </div>
</div>
@endsection
@section('script')
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script>
$('#sendMessageButton')on('click', function() {
  $('#commentUser').submit();
});

$('#txtComment').keypress(function (e) {
 var key = e.which;
 if(key == 13)  // the enter key code
  {
    $('#commentUser').submit();
  }
});
</script>
@endsection
@section('style')
<style type="text/css">
  .chatTitleContainer {
  
    text-align: left;
    font-size: 14pt;
    vertical-align: middle;
    display: table-cell;
    height: 50px;
    width: 100%;
    font-family: Expert-Sans-Regular, verdana, Arial, helvetica, sans-serif;
    color: #b5b5b5;
    
}

.chatContainer {
    
    height: 100%;
    width: 100%;
    background-color: #e4e4e4;
    padding: 20px;
    
}

.chatHistoryContainer {
    
    padding: 20px;
    height: 400px;
    width: 100%;
    background-color: #f4f4f4;
    border-top: 1px solid #e1e1e1;
    border-left: 1px solid #d4d4d4;
    border-right: 1px solid #d4d4d4;
    border-bottom: 1px solid #c3c3c3;
    border-top-left-radius: 6px;
    border-top-right-radius: 6px;
    
}

.chatMessageControls {
    
    margin-top: 6px;
    padding: 10px;
    width: 100%;
    background-color: #fff;
    border-top: 1px solid #e1e1e1;
    border-left: 1px solid #d4d4d4;
    border-right: 1px solid #d4d4d4;
    border-bottom: 1px solid #c3c3c3;
    border-bottom-left-radius: 6px;
    border-bottom-right-radius: 6px;
    
}

#undoSendButton {
    
    margin-left: 10px;
    border-radius: 3px;
    
}

#clearMessageButton {
    
    border-radius: 0;
    border-left: none;
    border-right: none;
    
}

#sendMessageButton {
    
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
    
}

.fa {
    
    margin-right: 6px;
    
}
    
  
  
.formComments {
    
  list-style-type: none;
    overflow-y: scroll;
    height: 100%;
    padding-bottom: 60px;
    padding-left: 0px;
  
}

.formComments li {
  
  margin-bottom: 10px;
    
}

.commentstep-1 {
    
    margin-left: 0px;
    
}

.commentstep-2 {
    
    margin-left: 48px;
    
}

.commentstep-3 {
    
    margin-left: 96px;
      
}

.form-comments-table tr:nth-child(1) td:nth-child(1) {
  
    font-size: 9pt;
    color: #a7a7a7;
    white-space: nowrap;
    vertical-align: top;
  
}

.comment-user {
  
  margin-left: 10px;

}

.form-comments-table tr td {
    
     white-space: nowrap;
     
}
.form-comments-table tr:nth-child(1) td:nth-child(1) {
    
    padding-top: 8px;
  
}
.form-comments-table tr:nth-child(1) td:nth-child(2) {
  
    padding-top: 8px;
    font-size: 9pt;
    color: #737373;
    font-weight: bold;
    vertical-align: top;
  
}

.form-comments-table tr:nth-child(1) td:nth-child(3) {
    
    vertical-align: top;
  
}

.form-comments-table tr:nth-child(1) td:nth-child(4) {
  
    width: 100%;
  
}

.form-comments-table tr:nth-child(1) td:nth-child(5) {
    
  
}

.comment-step-controls {
  
  
  
}

.comment-avatar {
  
  margin-left: 10px;
  margin-right: 10px;
  width: 36px;
  height: 36px;
  background-color: #c9c9c9;
  
}

.comment-avatar img {
  
  width: 36px;
  height: 36px;
  
}


.comment-marker {

  margin-right: 10px;
  color: #aeaeae;
  
}


.comment-step1:hover {
  
  
}

.comment {
    
    width: 100%;
    background-color: #fff;
    font-size: 12px;
  margin: 0;
  padding: 8px 8px;
  line-height: 1.5;
  color: #9e9e9e;
  border-color: #ddd;
  cursor: pointer;
  border: 1px solid #e6e6e6;
  border-bottom: 3px solid #dddddd;
  border-radius: 3px;    
    
}

.comment:hover {
    
    background-color: #fafafa;   
    
}

.comment-actions {
    
    border-top: 1px solid #dddddd;
    padding-top: 8px;
    margin-top: 8px;
    display: none;
    
}

.commentTD {

    
}
</style>
@endsection