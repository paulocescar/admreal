<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" id="btnSucess" data-toggle="modal" data-target="#mdsuccess" style="display:none;">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="mdsuccess" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <span style="float:left; margin-left: 20px;">{{\Session::get('success')}}</span>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="float:right; margin-right: 20px;">
              <span aria-hidden="true">&times;</span>
          </button>
      </div>
    </div>
  </div>
</div>