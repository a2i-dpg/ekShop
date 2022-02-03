<!-- delete Modal -->
<div id="delete-modal" class="modal fade delete-product-modal">
    <div class="modal-dialog modal-sm modal-dialog-centered" delete-product-modal-dialog>
        <div class="modal-content delete-product-modal-content">
            <div class="modal-header delete-product-modal-header">
                <h4 class="modal-title">{{translate('Delete Products')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body text-center delete-product-modal-body">
                <p class="mt-1">{{translate('Are you sure to delete this?')}}</p>
            </div>
            <div class="modal-footer text-center ">
                <button type="button" class="btn btn-link mt-2 cancel-and-delete text-decoration-none" data-dismiss="modal">{{translate('Cancel')}}</button>
                <a href="" id="delete-link" class="btn btn-primary text-white mt-2 cancel-and-delete">{{translate('Delete')}}</a>
            </div>
        </div>
    </div>
</div><!-- /.modal -->
