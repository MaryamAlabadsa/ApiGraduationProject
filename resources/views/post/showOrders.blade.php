<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">edit Post</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form action="{{ route('posts.store') }}" method="POST" id="form" onsubmit="submitForm(event,this)">
        @csrf

        @include('post.form')
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-danger">Save changes</button>
</div>
</div>
