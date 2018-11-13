<!-- Button trigger modal -->
<button type="button" class="btn btn-link" data-toggle="modal" data-target="#delete-modal-{{$id}}">
    <span class="glyphicon glyphicon-trash"></span>
</button>

<!-- Modal -->
<div class="modal fade" id="delete-modal-{{$id}}" tabindex="-1" role="dialog" aria-labelledby="delete-modal-label-{{$id}}" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="delete-modal-label-{{$id}}">Are you sure?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{--<div class="modal-body">--}}
                {{----}}
            {{--</div>--}}
            <div class="modal-footer">
                <form id="delete-form-{{$id}}" action="{{ $action }}" method="POST" style="display: none;">
                    @method('DELETE')
                    @csrf
                </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger" href="{{ $action }}"
                   onclick="event.preventDefault();
                           document.getElementById('delete-form-{{$id}}').submit();">
                    {{ __('Confirm Delete') }}
                </a>
            </div>
        </div>
    </div>
</div>